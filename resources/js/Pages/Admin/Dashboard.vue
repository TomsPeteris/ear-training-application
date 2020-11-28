<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h1>

        <!-- Page content -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <welcome />
        </div>
    </div>
</template>

<script>
    import AdminLayout from './../../Layouts/AdminLayout'
    import Welcome from './Welcome'

    export default {
        components: {
            Welcome,
        },

        layout: AdminLayout,
    }
</script>
