<template>
    <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
        <div class="py-4 text-gray-500 dark:text-gray-400">
            <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                Admin Panel
            </a>
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    <span :class="{ 'hidden' : !isRoute('admin') }" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true" />
                    <inertia-link :class="isRoute('admin') ? 'text-gray-800 transform scale-110 translate-x-5' : 'transition duration-150 transform hover:scale-110 hover:text-gray-800 hover:translate-x-5'" class="inline-flex items-center w-full text-sm font-semibold" :href="route('admin')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </inertia-link>
                </li>
                <li class="relative px-6 py-3">
                    <span :class="{ 'hidden' : !isRoute('users') }" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true" />
                    <inertia-link :class="isRoute('users') ? 'text-gray-800  transform scale-110 translate-x-5' : 'transition duration-150 transform hover:scale-110 hover:text-gray-800 hover:translate-x-5'" class="inline-flex items-center w-full text-sm font-semibold" :href="route('users')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="ml-4">Users</span>
                    </inertia-link>
                </li>
            </ul>
        </div>
    </aside>
</template>
<script>
    export default {
        methods: {
            logout() {
                axios.post(route('logout').url()).then(response => {
                    window.location = '/';
                })
            },

            isRoute(routeName) {
                return routeName === this.$page.route.split('.')[0];
            },
        },
    }
</script>
