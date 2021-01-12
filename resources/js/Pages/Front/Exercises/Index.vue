<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Choose Exercise Type:
        </h1>

        <!-- Page Content -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="flex justify-evenly m-10">
                <template v-for="exercise in exercises">
                    <inertia-link :href=" exercise === 'interval' ? route('exercise.interval') : '#'"
                                  class="text-center rounded-full transform hover:scale-110 duration-100"
                                  :class="{ 'opacity-25': exercise !== 'interval' }">
                        <div class="rounded-full h-24 w-24 flex items-center justify-center bg-purple-600 text-white font-semibold">{{ exercise }}</div>
                    </inertia-link>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import AppLayout from '../../../Layouts/AppLayout'

    export default {
        layout: AppLayout,

        props: {
            exercises: Array,
        }
    }
</script>
