<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            History
        </h1>

        <!-- Page Content -->
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-5 py-3">Type</th>
                        <th class="px-5 py-3">Accuracy</th>
                        <th class="px-5 py-3" colspan="2">Date</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr v-for="exercise in exercises.data" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="px-4 py-3">
                            <inertia-link :href="route('history.overview', exercise.id)" class="flex items-center">
                                <p class="text-gray-900 capitalize">
                                    {{ exercise.type }}
                                </p>
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="p-4 flex items-center text-left" :href="route('history.overview', exercise.id)" tabindex="-1">
                                {{ exercise.accuracy }}%
                            </inertia-link>
                        </td>
                        <td class="border-t">
                            <inertia-link class="p-4 flex items-center" :href="route('history.overview', exercise.id)" tabindex="-1">
                                {{ exercise.date }}
                            </inertia-link>
                        </td>
                        <td class="border-t w-px">
                            <inertia-link class="p-4 flex items-center" :href="route('history.overview', exercise.id)" tabindex="-1">
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
        <pagination :links="exercises.links" />
    </div>
</template>

<script>
    import AppLayout from '../../../Layouts/AppLayout'
    import Pagination from '../../../Shared/Pagination'

    export default {
        layout: AppLayout,

        props: {
            exercises: Object
        },

        components: {
            Pagination
        }
    }
</script>
