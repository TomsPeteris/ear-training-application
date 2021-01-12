<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <inertia-link class="text-purple-400 hover:text-purple-700 capitalize" :href="route('exercise')">{{ exerciseType }}</inertia-link>
            <span class="text-purple-400 font-medium">/</span>
            <inertia-link class="text-purple-400 hover:text-purple-700 capitalize" :href="route('exercise.' + exerciseType)">Choose Parameters</inertia-link>
            <span class="text-purple-400 font-medium">/</span>
            Choose correct answer:
        </h1>

        <!-- Page Content -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-20 mt-8">
                <progress-bar :percentage="getProgress()" color="purple" class="mx-2 mb-2 h-3"/>
                <template v-for="(question, index) in questions">
                    <div class="py-10 px-40" :key="index" v-if="isActive(index)">
                        <div class="flex justify-center">
                            <button class="p-4 rounded-full bg-purple-500 text-white transform hover:scale-110 duration-150 hover:bg-purple-600" @click="play(question.sound, question.direction, question.playback_type)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="mt-10 grid grid-cols-2 gap-4 justify-items-stretch">
                            <template v-for="answer in question.answers">
                                <secondary-button @click.native="checkAnswer(answer, question)">{{ answer }}</secondary-button>
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
                    exercise_type: this.exerciseType,
                    questions: [],
                    accuracy: null
                }),
                activeId: 0,
                answered: false,
            }
        },

        props: {
            questions: Array,
            retry: Boolean,
            exerciseType: String,
        },

        components: {
            SectionBorder,
            ProgressBar,
            SecondaryButton,
            PrimaryButton
        },

        methods: {
            // Function used to submit exercise data
            submit() {
                this.calculateAccuracy()
                this.form.post(this.route('exercise.store'));
            },

            // Function used to display the current questions
            isActive(index) {
                return index === this.activeId
            },

            // Function checks if the clicked answer is the correct answer
            // and depending on retry value moves the exercise forward
            checkAnswer(answer, question) {
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

            // Function used to display progress bar value
            getProgress() {
                let questionCount = this.questions.length
                return this.activeId * 100 / questionCount
            },

            // Function used to calculate exercise accuracy
            calculateAccuracy() {
                let correctQuestionCount = this.form.questions.filter(function (question) {
                    return question.answer === true
                }).length

                this.form.accuracy = correctQuestionCount * 100 / this.form.questions.length
            },

            // Function used to play the question according to chosen parameters
            play(sound, direction, playbackType) {
                let root, end

                if (direction === 'ascending') {
                    root = new Audio(sound.first)
                    end = new Audio(sound.second)

                    if (playbackType === 'melodic') {
                        root.play()
                        setTimeout(() => {
                            end.play()
                        }, 1500)
                    } else {
                        root.play()
                        end.play()
                    }
                } else {
                    root = new Audio(sound.second)
                    end = new Audio(sound.first)

                    if (playbackType === 'melodic') {
                        root.play()
                        setTimeout(() => {
                            end.play()
                        }, 1500)
                    } else {
                        root.play()
                        end.play()
                    }
                }
            }
        },
    }
</script>
