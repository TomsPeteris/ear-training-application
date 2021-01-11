<template>
    <aside class="z-20 hidden w-64 overflow-y-auto bg-white md:block flex-shrink-0">
        <div class="py-4 text-gray-500">
            <a class="ml-6 text-lg font-bold text-gray-800" href="#">
                Qualification project
            </a>
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    <span :class="{ 'hidden' : !isRoute('dashboard') }" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true" />
                    <inertia-link :class="isRoute('dashboard') ? 'text-gray-800 transform scale-110 translate-x-5' : 'transition duration-150 transform hover:scale-110 hover:text-gray-800 hover:translate-x-5'" class="inline-flex items-center w-full text-sm font-semibold" :href="route('dashboard')">
                        <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="ml-4">Dashboard</span>
                    </inertia-link>
                </li>
                <li class="relative px-6 py-3">
                    <span :class="{ 'hidden' : !isRoute('exercises') }" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true" />
                    <inertia-link :class="isRoute('exercises') ? 'text-gray-800  transform scale-110 translate-x-5' : 'transition duration-150 transform hover:scale-110 hover:text-gray-800 hover:translate-x-5'" class="inline-flex items-center w-full text-sm font-semibold" :href="route('exercises')">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="ml-4">Exercises</span>
                    </inertia-link>
                </li>
                <li class="relative px-6 py-3">
                    <span :class="{ 'hidden' : !isRoute('history') }" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true" />
                    <inertia-link :class="isRoute('history') ? 'text-gray-800  transform scale-110 translate-x-5' : 'transition duration-150 transform hover:scale-110 hover:text-gray-800 hover:translate-x-5'" class="inline-flex items-center w-full text-sm font-semibold" :href="route('history')">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-4">History</span>
                    </inertia-link>
                </li>
                <li class="relative px-6 py-3">
                    <span :class="{ 'hidden' : !isRoute('statistics') }" class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true" />
                    <inertia-link :class="isRoute('statistics') ? 'text-gray-800  transform scale-110 translate-x-5' : 'transition duration-150 transform hover:scale-110 hover:text-gray-800 hover:translate-x-5'" class="inline-flex items-center w-full text-sm font-semibold" :href="route('statistics')">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="ml-4">Statistics</span>
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
