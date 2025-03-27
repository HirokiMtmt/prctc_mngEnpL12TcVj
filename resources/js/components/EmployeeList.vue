<template>
  <div class="mt-6">
    <h2 class="text-xl font-semibold mb-3">社員一覧</h2>
    <div v-if="employees.length > 0" class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">名前</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">部署</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">役職</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="employee in employees" :key="employee.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ employee.id }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ employee.name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ employee.department }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ employee.position }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else class="text-center py-4 bg-white shadow rounded-lg">
      <p class="text-gray-500">社員データがありません</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EmployeeList',
  data() {
    return {
      employees: [
        { id: 1, name: '山田太郎', department: '営業部', position: '部長' },
        { id: 2, name: '佐藤花子', department: '人事部', position: '主任' },
        { id: 3, name: '鈴木一郎', department: '開発部', position: 'リーダー' }
      ]
    }
  }
}
</script> 