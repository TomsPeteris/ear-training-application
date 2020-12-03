<template>
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
            <div v-if="correctQuestions.length > 0" class="grid justify-items-center">
                <p class="text-2xl font-bold my-8">Correct intervals by count: </p>
                <radar-chart v-if="correctQuestionsData.labels.length > 2" :data="correctQuestionsRadarData" :options="defaultChartOptions" :height="chartHeight" />
                <bar-chart v-else :data="correctQuestionsBarData" :options="countChartOptions" :width="chartWidth" :height="chartHeight" />
            </div>
            <div v-if="incorrectQuestions.length > 0" class="grid justify-items-center">
                <p class="text-2xl font-bold my-8">Incorrect intervals by count: </p>
                <radar-chart v-if="incorrectQuestionsData.labels.length > 2" :data="incorrectQuestionsRadarData" :options="defaultChartOptions" :height="chartHeight" />
                <bar-chart v-else :data="incorrectQuestionsBarData" :options="countChartOptions" :width="chartWidth" :height="chartHeight" />
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
    import RadarChart from "../../../Shared/RadarChart";
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
                        display: false
                    }
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
                            }
                        }]
                    }
                }
            }
        },

        props: {
            exerciseQuestions: Array,
            previousExerciseQuestions: Array,
        },

        components: {
            SectionBorder,
            ProgressBar,
            SecondaryButton,
            PrimaryButton,
            DoughnutChart,
            RadarChart,
            BarChart
        },

        computed: {
            correctQuestions: function () {
                return this.exerciseQuestions.filter(function (question) {
                    return question.answer === 1
                })
            },

            incorrectQuestions: function () {
                return this.exerciseQuestions.filter(function (question) {
                    return question.answer === 0
                })
            },

            previousExerciseCorrectQuestions: function () {
                return this.previousExerciseQuestions.filter(function (question) {
                    return question.answer === 1
                })
            },

            previousExerciseIncorrectQuestions: function () {
                return this.previousExerciseQuestions.filter(function (question) {
                    return question.answer === 0
                })
            },

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

            correctQuestionsRadarData: function () {
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

            incorrectQuestionsRadarData: function () {
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
            },

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
            getAccuracy(correctQuestions, allQuestions) {
                return Math.floor(correctQuestions.length * 100 / allQuestions.length)
            }
        }

    }
</script>
