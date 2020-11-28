<template>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-6 py-2 text-2xl font-semibold text-white bg-purple-600">
                Exercises:
            </div>
            <div class="flex justify-evenly m-10">
                <template v-for="exercise in exercises">
                    <inertia-link :href="route('exercises.interval')"
                                  class="text-center rounded-full transform hover:scale-110 duration-100"
                                  :class="{ 'opacity-25': exercise !== 'interval' }">
                        <img :src="getImageUrl()" alt="No Image" class="rounded-full h-30 w-30 object-cover mb-4">
                        <p class="text-lg front-bold capitalize">{{ exercise }}</p>
                    </inertia-link>
                </template>
            </div>
        </div>
</template>

<script>
    import AppLayout from '../../../Layouts/AppLayout'

    export default {
        layout: AppLayout,

        props: {
            exercises: Array,
        },

        methods: {
            getImageUrl() {
                return `https://robohash.org/${Math.floor(Math.random() * 20)}?set=set2&size=180x180`
            }
        }
    }
</script>
