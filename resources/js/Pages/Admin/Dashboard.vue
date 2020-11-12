<template>
<!--    <div>-->
<!--        <div class="flex items-center px-4 mb-4 sm:px-6 lg:px-8">-->
<!--            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>-->
<!--        </div>-->
<!--        <div class="py-12">-->
<!--            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">-->
<!--                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">-->
<!--                    <welcome />-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
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
