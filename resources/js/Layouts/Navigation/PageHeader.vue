<template>
    <header class="z-10 py-4 bg-white shadow-md">
        <div class="container flex items-center justify-end  h-full px-6 mx-auto text-purple-600">
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <ul class="flex items-center flex-shrink-0 space-x-6">
                        <li class="flex">
                            <jet-dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                        <span v-if="!$page.avatar" class="pr-2">{{ $page.user.full_name }}</span>
                                        <img
                                            v-else
                                            class="object-cover w-10 h-10 rounded-full"
                                            :src="$page.avatar"
                                            alt=""
                                            aria-hidden="true"
                                        />
                                        <svg class="ml-1 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <jet-dropdown-link :href="route('profile.show')">
                                        Profile
                                    </jet-dropdown-link>

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <jet-dropdown-link as="button">
                                            Logout
                                        </jet-dropdown-link>
                                    </form>
                                </template>
                            </jet-dropdown>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
    import JetDropdown from '../../Jetstream/Dropdown'
    import JetDropdownLink from '../../Jetstream/DropdownLink'

    export default {
        components: {
            JetDropdown,
            JetDropdownLink,
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
