<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <inertia-link class="text-purple-400 hover:text-purple-700 capitalize" :href="route('history')">History</inertia-link>
            <span class="text-purple-400 font-medium">/</span>
            {{ exercise.id }}
        </h1>

        <!-- Page Content -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-20 py-10">
                <p class="text-center text-5xl font-semibold text-purple-500">Overview</p>
                <section-border />
                <div class="grid grid-cols-2 mb-20">
                    <div class="relative">
                        <p class="text-center text-2xl font-bold mb-2">This exercise:</p>
                        <div class="w-full top-1/3 absolute text-center text-2xl font-bold text-purple-500">
                            <br>
                            <span>
                            {{ getAccuracy(correctQuestions, exerciseQuestions) }}%
                        </span>
                            <p>ACCURACY</p>
                        </div>
                        <doughnut-chart :data="thisExerciseAccuracyData" :options="defaultChartOptions" :width="chartWidth" :height="chartHeight"/>
                    </div>
                    <div v-if="previousExerciseQuestions" class="relative">
                        <p class="text-center text-2xl font-bold mb-2">Previous exercise:</p>
                        <div class="w-full top-1/3 absolute text-center text-2xl font-bold text-purple-500">
                            <br>
                            <span>
                            {{ getAccuracy(previousExerciseCorrectQuestions, previousExerciseQuestions) }}%
                        </span>
                            <p>ACCURACY</p>
                        </div>
                        <doughnut-chart :data="previousExerciseAccuracyData" :options="defaultChartOptions" :width="chartWidth" :height="chartHeight"/>
                    </div>
                    <div v-else>
                        <p class="text-center text-2xl font-bold mb-2">No previous exercise data</p>
                    </div>
                </div>
                <div v-if="correctQuestions.length > 0" class="grid">
                    <p class="text-2xl font-bold my-8">Correct intervals by count: </p>
                    <bar-chart :class="{'justify-self-center': correctQuestionsData.labels.length < 3}" :data="correctQuestionsBarData" :options="countChartOptions" :width="chartWidth" :height="chartHeight" />
                </div>
                <div v-if="incorrectQuestions.length > 0" class="grid">
                    <p class="text-2xl font-bold my-8">Incorrect intervals by count: </p>
                    <bar-chart :class="{'justify-self-center': incorrectQuestionsData.labels.length < 3}" :data="incorrectQuestionsBarData" :options="countChartOptions" :width="chartWidth" :height="chartHeight" />
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
    import DoughnutChart from "../../../Shared/DoughnutChart";
    import BarChart from "../../../Shared/BarChart";

    export default {
        layout: AppLayout,

        data() {
            return {
                chartWidth: 300,
                chartHeight: 300,
                defaultChartOptions: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                },
                countChartOptions: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            },
                        }],
                    }
                }
            }
        },

        props: {
            exerciseQuestions: Array,
            previousExerciseQuestions: Array,
            exercise: Object,
        },

        components: {
            SectionBorder,
            ProgressBar,
            SecondaryButton,
            PrimaryButton,
            DoughnutChart,
            BarChart
        },

        computed: {
            // Filters out and returns the correct questions from exercise
            correctQuestions: function () {
                return this.exerciseQuestions.filter(function (question) {
                    return question.answer === 1
                })
            },

            // Filters out and returns the incorrect questions from exercise
            incorrectQuestions: function () {
                return this.exerciseQuestions.filter(function (question) {
                    return question.answer === 0
                })
            },

            // Filters out and returns the previous exercise correct questions
            previousExerciseCorrectQuestions: function () {
                return this.previousExerciseQuestions.filter(function (question) {
                    return question.answer === 1
                })
            },

            // Filters out and returns the previous exercise incorrect questions
            previousExerciseIncorrectQuestions: function () {
                return this.previousExerciseQuestions.filter(function (question) {
                    return question.answer === 0
                })
            },

            // Sorts correct questions data in a format that can be understood by chartJS
            correctQuestionsData: function () {
                let questionsData = {
                    labels: [],
                    data: []
                }

                for (let item in this.correctQuestions) {
                    let interval = this.correctQuestions[item].interval
                    if (!questionsData.labels.includes(interval)) {
                        let intervalCount = this.correctQuestions.filter(function (question) {
                            return question.interval === interval
                        }).length
                        questionsData.labels.push(interval)
                        questionsData.data.push(intervalCount)
                    }
                }

                return questionsData
            },

            // Sorts incorrect questions data in a format that can be understood by chartJS
            incorrectQuestionsData: function () {
                let questionsData = {
                    labels: [],
                    data: []
                }

                for (let item in this.incorrectQuestions) {
                    let interval = this.incorrectQuestions[item].interval
                    if (!questionsData.labels.includes(interval)) {
                        let intervalCount = this.incorrectQuestions.filter(function (question) {
                            return question.interval === interval
                        }).length
                        questionsData.labels.push(interval)
                        questionsData.data.push(intervalCount)
                    }
                }

                return questionsData
            },

            // Displays accuracy chart data of this exercise
            thisExerciseAccuracyData: function () {
                return {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: ['Correct', 'Incorrect'],
                    datasets: [
                        {
                            label: "Accuracy",
                            backgroundColor: ["#7e3af2"],
                            data: [this.correctQuestions.length, this.incorrectQuestions.length]
                        }
                    ]
                }
            },

            // Displays accuracy chart data of previous exercise
            previousExerciseAccuracyData: function () {
                return {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: ['Correct', 'Incorrect'],
                    datasets: [
                        {
                            label: "Accuracy",
                            backgroundColor: ["#7e3af2"],
                            data: [this.previousExerciseCorrectQuestions.length, this.previousExerciseIncorrectQuestions.length]
                        }
                    ]
                }
            },

            // Displays correct questions chart data of this exercise
            correctQuestionsBarData: function () {
                return {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: this.correctQuestionsData.labels,
                    datasets: [
                        {
                            label: "Count",
                            backgroundColor: "#7e3af2",
                            data: this.correctQuestionsData.data
                        }
                    ]
                }
            },

            // Displays incorrect questions chart data of this exercise
            incorrectQuestionsBarData: function () {
                return {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: this.incorrectQuestionsData.labels,
                    datasets: [
                        {
                            label: "Count",
                            backgroundColor: "#7e3af2",
                            data: this.incorrectQuestionsData.data
                        }
                    ]
                }
            }
        },

        methods: {
            // Calculated exercise accuracy
            getAccuracy(correctQuestions, allQuestions) {
                return Math.floor(correctQuestions.length * 100 / allQuestions.length)
            }
        }

    }
</script>
