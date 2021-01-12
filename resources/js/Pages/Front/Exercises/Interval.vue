<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <inertia-link class="text-purple-400 hover:text-purple-700 capitalize" :href="route('exercise')">{{ type }}</inertia-link>
            <span class="text-purple-400 font-medium">/</span>
            Choose Parameters
        </h1>

        <!-- Page Content -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="grid grid-cols-3">
                <div class="ml-10 mb-10 mt-5 mr-10 col-span-2">
                    <div class="text-xl font-semibold">
                        Intervals:
                    </div>
                    <div v-show="form.error('intervals')" class="mt-2 mb-4">
                        <p class="text-sm text-red-600">
                            {{ form.error('interval') }}
                        </p>
                    </div>
                    <div class="flex flex-wrap justify-start">
                        <template v-for="interval in intervals">
                            <radio-button v-model="form.intervals" :item="interval.name">{{ interval.name }}</radio-button>
                        </template>
                    </div>
                </div>
                <div class="ml-10 mb-10 mt-5">
                    <div class="text-xl font-semibold">
                        Direction:
                    </div>
                    <div v-show="form.error('direction')" class="mt-2 mb-4">
                        <p class="text-sm text-red-600">
                            {{ form.error('direction') }}
                        </p>
                    </div>
                    <div class="flex flex-wrap justify-start">
                        <radio-button v-model="form.direction" item="ascending">Ascending</radio-button>
                        <radio-button v-model="form.direction" item="descending">Descending</radio-button>
                    </div>
                    <div class="text-xl font-semibold mt-2">
                        Type:
                    </div>
                    <div v-show="form.error('type')" class="mt-2 mb-4">
                        <p class="text-sm text-red-600">
                            {{ form.error('type') }}
                        </p>
                    </div>
                    <div class="flex flex-wrap justify-start">
                        <radio-button v-model="form.type" item="melodic">Melodic</radio-button>
                        <radio-button v-model="form.type" item="harmonic">Harmonic</radio-button>
                    </div>
                    <div class="text-xl font-semibold mt-2">
                        Retry:
                    </div>
                    <div v-show="form.error('retry')" class="mt-2 mb-4">
                        <p class="text-sm text-red-600">
                            {{ form.error('retry') }}
                        </p>
                    </div>
                    <div class="flex flex-wrap justify-start">
                        <radio-button v-model="form.retry" :item="true">Yes</radio-button>
                        <radio-button v-model="form.retry" :item="false">No</radio-button>
                    </div>
                    <div class="text-xl font-semibold mt-2">
                        Count:
                    </div>
                    <div v-show="form.error('question_count')" class="mt-2 mb-4">
                        <p class="text-sm text-red-600">
                            {{ form.error('question_count') }}
                        </p>
                    </div>
                    <input v-model="form.question_count" type="number" min="1" max="50" class="border rounded-md py-2 px-4" @input="questionCount">
                </div>
            </div>
            <div class="grid">
                <primary-button class="grid justify-self-center mb-10" @click.native="submit">Start the exercise</primary-button>
            </div>
        </div>
    </div>
</template>

<script>
    import AppLayout from '../../../Layouts/AppLayout'
    import RadioButton from "../../../Shared/RadioButton"
    import PrimaryButton from "../../../Shared/PrimaryButton";

    export default {
        layout: AppLayout,

        data() {
            return {
                form: this.$inertia.form({
                    exercise_type: this.type,
                    intervals: ['m2', 'M2', 'm3', 'M3', 'p4', 'tritone', 'p5', 'm6', 'M6', 'm7', 'M7', 'p8'],
                    direction: 'ascending',
                    type: 'melodic',
                    retry: false,
                    question_count: 20,
                }, {
                    bag: 'generateExercise'
                }),
            }
        },

        components: {
            RadioButton,
            PrimaryButton
        },

        props: {
            type: String,
            intervals: Array,
        },

        methods: {
            // Start exercise request
            submit() {
                this.form.post(this.route('exercise.execute'))
            },

            questionCount(e) {
                this.form.question_count = e.target.value
            }
        }
    }
</script>
