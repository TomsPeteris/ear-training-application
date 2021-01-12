<template>
    <header class="z-10 py-4 bg-white shadow-md">
        <div class="container flex items-center justify-between  h-full px-6 mx-auto text-purple-600">
            <inertia-link class="flex justify-start items-center font-bold text-gray-800" :href="route('dashboard')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <span class="ml-2">Dashboard</span>
            </inertia-link>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <ul class="flex items-center flex-shrink-0 space-x-6">
                        <li class="flex">
                            <dropdown-menu align="right" width="48">
                                <template #trigger>
                                    <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                        <span class="mr-2">{{ $page.current_user.full_name }}</span>
                                        <img
                                            v-if="$page.current_user.avatar"
                                            class="object-cover w-10 h-10 rounded-full"
                                            :src="$page.current_user.avatar"
                                            alt=""
                                            aria-hidden="true"
                                        />
                                        <svg class="ml-1 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <inertia-link :href="route('profile')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100">
                                        Profile
                                    </inertia-link>

                                    <div class="border-t border-gray-100"></div>

                                    <form @submit.prevent="logout">
                                        <button type="submit" class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 text-left hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </template>
                            </dropdown-menu>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import DropdownMenu from "../../../Shared/DropdownMenu"

export default {
    components: {
        DropdownMenu
    },

    methods: {
        logout() {
            axios.post(route('logout').url()).then(response => {
                window.location = '/';
            })
        },
    }

}

</script>
