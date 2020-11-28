<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="px-6 mt-8 text-2xl font-semibold">
            Choose correct answer:
            <section-border />
        </div>
        <div class="px-20">
            <progress-bar :percentage="getProgress()" color="purple" class="mx-2 mb-2 h-3"/>
            <template v-for="(question, index) in questions">
                <div class="py-10 px-40" :key="index" v-if="isActive(index)">
                    <div class="flex justify-center">
                        <audio controls>
                            <source :src="question.sound.root" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                        <audio controls>
                            <source :src="question.sound.end" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                    <div class="mt-10 grid grid-cols-2 gap-4 justify-items-stretch">
                        <template v-for="answer in question.answers">
                            <secondary-button @click.native="answerClicked(answer, question)">{{ answer }}</secondary-button>
                        </template>
                    </div>
                </div>
            </template>
            <div class="py-10 px-40 grid justify-items-center" v-if="getProgress() === 100">
                <p class="py-3 text-2xl text-bold">Congratulations!</p>
                <p class="py-2 text-bold">You've finished the exercise!</p>
                <PrimaryButton @click.native="submit">Overview</PrimaryButton>
            </div>
        </div>
    </div>
</template>

<script>
    import AppLayout from '../../../Layouts/AppLayout'
    import SectionBorder from '../../../Shared/SectionBorder'
    import ProgressBar from "../../../Shared/ProgressBar"
    import SecondaryButton from "../../../Shared/SecondaryButton"
    import PrimaryButton from "../../../Shared/PrimaryButton";

    export default {
        layout: AppLayout,

        data() {
            return {
                form: this.$inertia.form({
                    exercise_type: this.exercise_type,
                    questions: []
                }),
                activeId: 0,
                answered: false,
            }
        },

        props: {
            questions: Array,
            playback_speed: String,
            retry: Boolean,
            exercise_type: String,
        },

        components: {
            SectionBorder,
            ProgressBar,
            SecondaryButton,
            PrimaryButton
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('exercise.store'), this.form);
            },

            isActive(index) {
                return index === this.activeId
            },

            answerClicked(answer, question) {
                if (this.retry) {
                    if (answer === question.correct_answer) {
                        question.answer = !this.answered;
                        this.answered = false
                        this.activeId++
                        this.form.questions.push(question)
                        return
                    }
                    this.answered = true
                } else {
                    question.answer = answer === question.correct_answer;
                    this.activeId++
                }
                this.form.questions.push(question)
            },

            getProgress() {
                let questionCount = this.questions.length
                return this.activeId * 100 / questionCount
            }
        },
    }
</script>
