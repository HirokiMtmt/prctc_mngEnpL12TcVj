<template>
  <div class="mt-6 mb-8">
    <h3 class="text-lg font-semibold mb-2">CSVファイルから社員データをインポート</h3>
    
    <!-- アップロード成功メッセージ -->
    <div v-if="successMessage" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
      {{ successMessage }}
    </div>
    
    <!-- エラーメッセージ -->
    <div v-if="errorMessage" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
      {{ errorMessage }}
    </div>
    
    <!-- ドラッグ＆ドロップエリア -->
    <div
      class="border-2 border-dashed rounded-lg p-8 text-center cursor-pointer transition-colors"
      :class="[
        isDragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-400',
        isProcessing ? 'opacity-50 cursor-not-allowed' : ''
      ]"
      @dragover.prevent="isDragging = true"
      @dragleave.prevent="isDragging = false"
      @drop.prevent="onFileDrop"
      @click="triggerFileInput"
    >
      <input 
        type="file" 
        ref="fileInput" 
        class="hidden" 
        accept=".csv" 
        @change="onFileSelected"
      >
      
      <div v-if="isProcessing" class="flex flex-col items-center">
        <svg class="animate-spin h-8 w-8 text-blue-500 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>処理中...</span>
      </div>
      
      <div v-else class="flex flex-col items-center">
        <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
        </svg>
        <p class="mb-1 font-medium">CSVファイルをここにドラッグ＆ドロップ</p>
        <p class="text-sm text-gray-500">または、ここをクリックしてファイルを選択</p>
      </div>
    </div>
    
    <!-- CSVフォーマット説明 -->
    <div class="mt-4 text-sm text-gray-600">
      <p class="font-medium">CSVファイル形式:</p>
      <p>1行目: ヘッダー (name,email,department,position,hired_date,phone,address)</p>
      <p>2行目以降: データ (例: 山田太郎,yamada@example.com,営業部,部長,2020-04-01,090-1234-5678,東京都港区...)</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CsvUploader',
  data() {
    return {
      isDragging: false,
      isProcessing: false,
      errorMessage: '',
      successMessage: '',
    }
  },
  methods: {
    triggerFileInput() {
      // ファイル選択ダイアログを表示
      if (!this.isProcessing) {
        this.$refs.fileInput.click();
      }
    },
    
    onFileDrop(e) {
      this.isDragging = false;
      const files = e.dataTransfer.files;
      if (files.length) {
        this.processFile(files[0]);
      }
    },
    
    onFileSelected(e) {
      const files = e.target.files;
      if (files.length) {
        this.processFile(files[0]);
      }
    },
    
    processFile(file) {
      // ファイルタイプの検証
      if (file.type !== 'text/csv' && !file.name.endsWith('.csv')) {
        this.errorMessage = 'CSVファイルのみアップロードできます。';
        return;
      }
      
      this.isProcessing = true;
      this.errorMessage = '';
      this.successMessage = '';
      
      const reader = new FileReader();
      
      reader.onload = async (e) => {
        try {
          const csvData = e.target.result;
          const employees = this.parseCSV(csvData);
          
          if (employees.length === 0) {
            throw new Error('CSVファイルに有効なデータがありません。');
          }
          
          // APIにデータを送信
          await this.uploadEmployees(employees);
          
          this.successMessage = `${employees.length}件の社員データを正常にインポートしました。`;
          // 親コンポーネントに更新を通知
          this.$emit('imported');
        } catch (error) {
          console.error('CSV処理エラー:', error);
          this.errorMessage = `エラー: ${error.message}`;
        } finally {
          this.isProcessing = false;
          // ファイル入力をリセット
          this.$refs.fileInput.value = '';
        }
      };
      
      reader.onerror = () => {
        this.isProcessing = false;
        this.errorMessage = 'ファイルの読み込み中にエラーが発生しました。';
      };
      
      reader.readAsText(file);
    },
    
    parseCSV(csvText) {
      // CSVを解析して配列に変換
      const lines = csvText.split(/\r\n|\n/);
      const headers = lines[0].split(',');
      
      // ヘッダーを検証
      const requiredHeaders = ['name', 'email', 'department', 'position'];
      const missingHeaders = requiredHeaders.filter(h => !headers.includes(h));
      
      if (missingHeaders.length) {
        throw new Error(`必須ヘッダーがありません: ${missingHeaders.join(', ')}`);
      }
      
      const employees = [];
      
      // 2行目以降のデータを処理
      for (let i = 1; i < lines.length; i++) {
        // 空行をスキップ
        if (!lines[i].trim()) continue;
        
        const values = lines[i].split(',');
        
        // 値の数とヘッダーの数が一致するか確認
        if (values.length !== headers.length) {
          console.warn(`行 ${i + 1} のデータ形式が不正です: ${lines[i]}`);
          continue;
        }
        
        const employee = {};
        
        // ヘッダーに対応する値を割り当て
        headers.forEach((header, index) => {
          employee[header.trim()] = values[index].trim();
        });
        
        // 必須フィールドの検証
        if (!employee.name || !employee.email || !employee.department || !employee.position) {
          console.warn(`行 ${i + 1} に必須フィールドがありません: ${lines[i]}`);
          continue;
        }
        
        employees.push(employee);
      }
      
      return employees;
    },
    
    async uploadEmployees(employees) {
      const baseUrl = window.location.origin;
      const response = await fetch(`${baseUrl}/api/employees/import`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ employees })
      });
      
      if (!response.ok) {
        const error = await response.json();
        throw new Error(error.message || 'データのインポートに失敗しました。');
      }
      
      return await response.json();
    }
  }
}
</script> 