<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Notes
        </h1>

        <!-- Page content -->
        <div class="flex flex-col sm:flex-row flex-col-reverse items-center justify-between mb-6">
            <div class="w-full sm:w-1/2">
                <div class="relative text-gray-500 focus-within:text-purple-600">
                    <input type="text" class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" placeholder="Search...">
                    <button class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        <svg class="h-4 w-4 text-grey-dark" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Path</th>
                        <th class="px-5 py-3" colspan="2">Updated at</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr v-for="note in notes.data" :key="note.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="px-4 py-3">
                            <inertia-link :href="route('notes.edit', note.id)" class="flex items-center">
                                <div class="ml-3">
                                    <p class="text-gray-900">
                                        {{ note.name }}
                                    </p>
                                </div>
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="p-4 flex items-center text-left" :href="route('notes.edit', note.id)" tabindex="-1">
                                {{ note.file }}
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="p-4 flex items-center text-left" :href="route('notes.edit', note.id)" tabindex="-1">
                                {{ note.updated_at }}
                            </inertia-link>
                        </td>
                        <td class="border-t w-px">
                            <inertia-link class="p-4 flex items-center" :href="route('notes.edit', note.id)" tabindex="-1">
                                <svg viewBox="0 0 20 20" class="h-5 w-5 text-gray-400 fill-current">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </inertia-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <pagination :links="notes.links" />
    </div>
</template>

<script>
    import AdminLayout from './../../../Layouts/AdminLayout'
    import Pagination from "../../../Shared/Pagination";

    export default {
        layout: AdminLayout,

        props: {
            notes: Object,
        },

        components: {
            Pagination,
        }
    }
</script>
