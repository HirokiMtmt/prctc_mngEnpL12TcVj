<template>
  <div class="mt-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold">社員一覧</h2>
      <button 
        v-if="!showForm"
        @click="createEmployee" 
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
      >
        新規社員を登録
      </button>
    </div>

    <!-- フォーム表示領域 -->
    <div v-if="showForm">
      <EmployeeForm 
        :employee-data="selectedEmployee" 
        :is-editing="isEditing"
        @saved="handleSaved" 
        @cancel="cancelForm"
      />
    </div>

    <!-- 確認モーダル -->
    <div v-if="showDeleteConfirm" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto">
        <h3 class="text-lg font-bold mb-4">削除の確認</h3>
        <p>{{ selectedEmployee.name }}を削除してもよろしいですか？</p>
        <div class="flex justify-end mt-4 space-x-2">
          <button @click="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
            キャンセル
          </button>
          <button @click="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            削除
          </button>
        </div>
      </div>
    </div>

    <!-- ローディング表示 -->
    <div v-if="loading" class="text-center py-4">
      <p class="text-gray-500">データを読み込み中...</p>
    </div>

    <!-- エラー表示 -->
    <div v-else-if="error" class="text-center py-4 bg-red-50 text-red-500 rounded-lg">
      <p>{{ error }}</p>
    </div>

    <!-- 社員リスト表示 -->
    <div v-else-if="employees.length > 0" class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">名前</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">メールアドレス</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">部署</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">役職</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="employee in employees" :key="employee.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ employee.id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ employee.name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ employee.email }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ employee.department }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ employee.position }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <button 
                @click="editEmployee(employee)" 
                class="text-indigo-600 hover:text-indigo-900 mr-3"
              >
                編集
              </button>
              <button 
                @click="deleteEmployee(employee)" 
                class="text-red-600 hover:text-red-900"
              >
                削除
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- データがない場合 -->
    <div v-else class="text-center py-4 bg-white shadow rounded-lg">
      <p class="text-gray-500">社員データがありません</p>
    </div>
  </div>
</template>

<script>
import EmployeeForm from './EmployeeForm.vue';

export default {
  name: 'EmployeeList',
  components: {
    EmployeeForm
  },
  data() {
    return {
      employees: [],
      loading: true,
      error: null,
      showForm: false,
      isEditing: false,
      selectedEmployee: null,
      showDeleteConfirm: false
    }
  },
  mounted() {
    this.fetchEmployees();
  },
  methods: {
    async fetchEmployees() {
      try {
        this.loading = true;
        this.error = null;
        const baseUrl = window.location.origin;
        
        const response = await fetch(`${baseUrl}/api/employees`);
        
        if (!response.ok) {
          const errorText = await response.text();
          throw new Error(`サーバーエラー (${response.status}): ${errorText}`);
        }
        
        const data = await response.json();
        console.log('社員データ取得成功:', data);
        this.employees = data;
      } catch (error) {
        console.error('Error fetching employees:', error);
        this.error = `APIからのデータ取得に失敗: ${error.message}`;
        this.useMockData();
      } finally {
        this.loading = false;
      }
    },
    
    // APIが利用できない場合のフォールバック
    useMockData() {
      console.log('モックデータを使用します');
      this.employees = [
        { id: 1, name: '山田太郎', email: 'yamada@example.com', department: '営業部', position: '部長' },
        { id: 2, name: '佐藤花子', email: 'sato@example.com', department: '人事部', position: '主任' },
        { id: 3, name: '鈴木一郎', email: 'suzuki@example.com', department: '開発部', position: 'リーダー' }
      ];
      this.error = "APIから取得できませんでした。モックデータを表示しています。";
    },
    
    // 新規社員登録モードに切り替え
    createEmployee() {
      this.isEditing = false;
      this.selectedEmployee = null;
      this.showForm = true;
    },
    
    // 社員編集モードに切り替え
    editEmployee(employee) {
      this.isEditing = true;
      this.selectedEmployee = { ...employee };
      this.showForm = true;
    },
    
    // 社員削除確認ダイアログを表示
    deleteEmployee(employee) {
      this.selectedEmployee = employee;
      this.showDeleteConfirm = true;
    },
    
    // 削除をキャンセル
    cancelDelete() {
      this.showDeleteConfirm = false;
      this.selectedEmployee = null;
    },
    
    // 削除を確定
    async confirmDelete() {
      try {
        const baseUrl = window.location.origin;
        const response = await fetch(`${baseUrl}/api/employees/${this.selectedEmployee.id}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json'
          }
        });
        
        if (!response.ok) {
          throw new Error(`削除に失敗しました (${response.status})`);
        }
        
        // 削除後にリストを更新
        this.employees = this.employees.filter(e => e.id !== this.selectedEmployee.id);
        this.showDeleteConfirm = false;
        this.selectedEmployee = null;
      } catch (error) {
        console.error('Delete error:', error);
        this.error = `削除中にエラーが発生しました: ${error.message}`;
      }
    },
    
    // フォームの保存完了ハンドラ
    handleSaved(employee) {
      if (this.isEditing) {
        // 編集モード: 既存の社員データを更新
        const index = this.employees.findIndex(e => e.id === employee.id);
        if (index !== -1) {
          this.employees.splice(index, 1, employee);
        }
      } else {
        // 新規作成モード: 社員データを追加
        this.employees.push(employee);
      }
      
      // フォームを閉じる
      this.showForm = false;
      this.selectedEmployee = null;
    },
    
    // フォームをキャンセル
    cancelForm() {
      this.showForm = false;
      this.selectedEmployee = null;
    }
  }
}
</script> 