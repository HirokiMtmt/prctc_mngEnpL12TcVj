<template>
  <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h2 class="text-xl font-semibold mb-4">{{ isEditing ? '社員情報を編集' : '新規社員を登録' }}</h2>
    
    <div v-if="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      {{ errorMessage }}
    </div>
    
    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
          氏名
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="name"
          type="text"
          placeholder="例: 山田太郎"
          v-model="employee.name"
          required
        >
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
          メールアドレス
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="email"
          type="email"
          placeholder="例: yamada@example.com"
          v-model="employee.email"
          required
        >
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="department">
          部署
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="department"
          type="text"
          placeholder="例: 営業部"
          v-model="employee.department"
          required
        >
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="position">
          役職
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="position"
          type="text"
          placeholder="例: 部長"
          v-model="employee.position"
          required
        >
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="hired_date">
          入社日
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="hired_date"
          type="date"
          v-model="employee.hired_date"
        >
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
          電話番号
        </label>
        <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="phone"
          type="text"
          placeholder="例: 090-1234-5678"
          v-model="employee.phone"
        >
      </div>
      
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
          住所
        </label>
        <textarea
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="address"
          placeholder="例: 東京都港区芝浦1-1-1"
          v-model="employee.address"
          rows="2"
        ></textarea>
      </div>
      
      <div class="flex items-center justify-between">
        <button
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          type="submit"
          :disabled="loading"
        >
          {{ isEditing ? '更新' : '登録' }}
        </button>
        <button
          class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          type="button"
          @click="cancel"
        >
          キャンセル
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'EmployeeForm',
  props: {
    // 編集モードの場合、既存の社員データを受け取る
    employeeData: {
      type: Object,
      default: null
    },
    // 新規作成か編集かを判別
    isEditing: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      employee: {
        name: '',
        email: '',
        department: '',
        position: '',
        hired_date: '',
        phone: '',
        address: ''
      },
      loading: false,
      errorMessage: ''
    }
  },
  created() {
    // 編集モードの場合、プロパティからデータをコピー
    if (this.isEditing && this.employeeData) {
      this.employee = { ...this.employeeData };
    }
  },
  methods: {
    async submitForm() {
      this.loading = true;
      this.errorMessage = '';
      const baseUrl = window.location.origin;
      
      try {
        let response;
        
        if (this.isEditing) {
          // 編集モード: PUTリクエスト
          response = await fetch(`${baseUrl}/api/employees/${this.employee.id}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            },
            body: JSON.stringify(this.employee)
          });
        } else {
          // 新規作成モード: POSTリクエスト
          response = await fetch(`${baseUrl}/api/employees`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            },
            body: JSON.stringify(this.employee)
          });
        }
        
        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || 'エラーが発生しました');
        }
        
        const data = await response.json();
        
        // 親コンポーネントに成功を通知
        this.$emit('saved', data);
        
        // フォームをリセット
        if (!this.isEditing) {
          this.resetForm();
        }
      } catch (error) {
        console.error('Error saving employee:', error);
        this.errorMessage = `社員データの保存に失敗しました: ${error.message}`;
      } finally {
        this.loading = false;
      }
    },
    resetForm() {
      this.employee = {
        name: '',
        email: '',
        department: '',
        position: '',
        hired_date: '',
        phone: '',
        address: ''
      };
    },
    cancel() {
      this.$emit('cancel');
    }
  }
}
</script> 