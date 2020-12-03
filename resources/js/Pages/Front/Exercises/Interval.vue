<template>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-6 py-2 text-2xl font-semibold text-white bg-purple-600">
                Create exercise:
            </div>
            <div class="grid grid-cols-3">
                <div class="ml-10 mb-10 mt-5 mr-10 col-span-2">
                    <div class="text-xl font-semibold">
                        Intervals:
                    </div>
                    <div class="flex flex-wrap justify-start">
                        <template v-for="interval in intervals">
                            <radio-button v-model="form.question_attributes.intervals" :item="interval.name">{{ interval.name }}</radio-button>
                        </template>
                    </div>
                    <div class="text-xl font-semibold mt-4">
                        Playback speed:
                    </div>
                    <div class="flex flex-wrap justify-start">
                        <radio-button v-model="form.playback_speed" item="slow">Slow</radio-button>
                        <radio-button v-model="form.playback_speed" item="medium">Medium</radio-button>
                        <radio-button v-model="form.playback_speed" item="fast">Fast</radio-button>
                    </div>
                </div>
                <div class="ml-10 mb-10 mt-5">
                    <div class="text-xl font-semibold">
                        Direction:
                    </div>
                    <div class="flex flex-wrap justify-start">
                        <radio-button v-model="form.question_attributes.direction" item="ascending">Ascending</radio-button>
                        <radio-button v-model="form.question_attributes.direction" item="descending">Descending</radio-button>
                    </div>
                    <div class="text-xl font-semibold mt-2">
                        Type:
                    </div>
                    <div class="flex flex-wrap justify-start">
                        <radio-button v-model="form.question_attributes.type" item="melodic">Melodic</radio-button>
                        <radio-button v-model="form.question_attributes.type" item="harmonic">Harmonic</radio-button>
                    </div>
                    <div class="text-xl font-semibold mt-2">
                        Retry:
                    </div>
                    <div class="flex flex-wrap justify-start">
                        <radio-button v-model="form.retry" :item="true">Yes</radio-button>
                        <radio-button v-model="form.retry" :item="false">No</radio-button>
                    </div>
                    <div class="text-xl font-semibold mt-2">
                        Count:
                    </div>
                    <input v-model="form.question_count" type="number" min="1" max="50" class="border rounded-md py-2 px-4" @input="questionCount">
                </div>
            </div>
            <div class="grid">
                <primary-button class="grid justify-self-center mb-10" @click.native="submit">Start the exercise</primary-button>
            </div>
        </div>
</template>

<script>
    import AppLayout from '../../../Layouts/AppLayout'
    import RadioButton from "../../../Shared/RadioButton"
    import RangeSlider from "../../../Shared/RangeSlider"
    import PrimaryButton from "../../../Shared/PrimaryButton";

    export default {
        layout: AppLayout,

        data() {
            return {
                form: this.$inertia.form({
                    exercise_type: this.type,
                    question_attributes: {
                        intervals: ['m2', 'M2', 'm3', 'M3', 'p4', 'tritone', 'p5', 'm6', 'M6', 'm7', 'M7', 'p8'],
                        direction: 'ascending',
                        type: 'melodic',
                    },
                    retry: false,
                    question_count: 20,
                    playback_speed: 'medium'
                }),
            }
        },

        components: {
            RadioButton,
            RangeSlider,
            PrimaryButton
        },

        props: {
            type: String,
            intervals: Array,
        },

        methods: {
            getImageUrl() {
                return `https://robohash.org/${Math.floor(Math.random() * 20)}?set=set2&size=180x180`
            },

            submit() {
                this.$inertia.post(this.route('exercise'), this.form)
            },

            questionCount(e) {
                this.form.question_count = e.target.value
            }
        }
    }
</script>
