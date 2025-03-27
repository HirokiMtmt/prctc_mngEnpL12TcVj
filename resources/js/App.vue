<template>
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center mt-8">
            社員管理システム
        </h1>
        <employee-list />
    </div>
</template>

<script>
import EmployeeList from './components/EmployeeList.vue'

export default {
    name: 'App',
    components: {
        EmployeeList
    }
}
</script> 