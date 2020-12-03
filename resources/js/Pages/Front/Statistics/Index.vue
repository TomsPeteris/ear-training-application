<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="px-20 py-10">
            <p class="text-center text-5xl font-semibold text-purple-500">Accuracy</p>
            <section-border />
            <div class="grid grid-cols-2 mb-20">
                <div class="float-left relative">
                    <p class="text-center text-2xl font-bold mb-2">Total:</p>
                    <div class="w-full top-1/3 absolute text-center text-2xl font-bold text-purple-500">
                        <br>
                        <span>
                            {{ totalAccuracy }}%
                        </span>
                        <p>ACCURACY</p>
                    </div>
                    <doughnut-chart :data="doughnutAccuracyData" :options="defaultChartOptions" :width="chartWidth" :height="chartHeight"/>
                </div>
                <div>
                    <p class="text-center text-2xl font-bold mb-2">Per Month:</p>
                    <line-chart :data="lineAccuracyData" :options="defaultChartOptions" :width="chartWidth" :height="chartHeight"/>
                </div>
            </div>
            <p class="text-center text-5xl font-semibold text-purple-500">Exercises</p>
            <section-border />
            <div class="grid grid-cols-2 mb-20">
                <div class="grid justify-center">
                    <p class="text-2xl font-bold mb-2">Count:</p>
                    <p class="text-8xl font-bold text-purple-500">{{ exercises.length }}</p>
                </div>
                <div>
                    <p class="text-center text-2xl font-bold mb-2">Per Month:</p>
                    <line-chart :data="lineExerciseData" :options="countChartOptions" :width="chartWidth" :height="chartHeight"/>
                </div>
            </div>
            <p class="text-center text-5xl font-semibold text-purple-500">Intervals</p>
            <section-border />
            <div class="grid">
                <p class="text-2xl font-bold mb-2">Count per interval:</p>
                <bar-chart :data="barIntervalData" :options="countChartOptions" :height="chartHeight"/>
            </div>
            <div class="grid">
                <p class="text-2xl font-bold my-2">Accuracy per interval:</p>
                <bar-chart :data="barIntervalAccuracyData" :options="defaultChartOptions" :height="chartHeight"/>
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
    import LineChart from "../../../Shared/LineChart";
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
                            }
                        }]
                    }
                }
            }
        },

        props: {
            exercises: Array,
            questions: Array,
            intervals: Object
        },

        components: {
            SectionBorder,
            ProgressBar,
            SecondaryButton,
            PrimaryButton,
            DoughnutChart,
            LineChart,
            BarChart
        },

        methods: {
            getAccuracy(questions) {
                if (questions.length < 1) return null
                let correctQuestionCount = questions.filter(function (question) {
                    return question.answer === 1
                }).length

                return correctQuestionCount * 100 / questions.length
            },

            getMonthName(id) {
                switch (id) {
                    case 0:
                        return 'January'
                    case 1:
                        return 'February'
                    case 2:
                        return 'March'
                    case 3:
                        return 'April'
                    case 4:
                        return 'May'
                    case 5:
                        return 'June'
                    case 6:
                        return 'July'
                    case 7:
                        return 'August'
                    case 8:
                        return 'September'
                    case 9:
                        return 'October'
                    case 10:
                        return 'November'
                    case 11:
                        return 'December'
                    default:
                        return 'Error in month'
                }
            },

            getAccuracyPerMonthForLastSixMonths() {
                let thisMonth = new Date()
                let lastMonth = new Date()
                let twoMonthsAgo = new Date()
                let threeMonthsAgo = new Date()
                let fourMonthsAgo = new Date()
                let fiveMonthsAgo = new Date()

                lastMonth.setMonth(lastMonth.getMonth() - 1)
                twoMonthsAgo.setMonth(twoMonthsAgo.getMonth() - 2)
                threeMonthsAgo.setMonth(threeMonthsAgo.getMonth() - 3)
                fourMonthsAgo.setMonth(fourMonthsAgo.getMonth() - 4)
                fiveMonthsAgo.setMonth(fiveMonthsAgo.getMonth() - 5)

                return {
                    thisMonth: {
                        month: this.getMonthName(thisMonth.getMonth()),
                        accuracy: this.getAccuracy(this.questions.filter(function (question) {
                            return thisMonth.getMonth() === question.date - 1
                        }))
                    },
                    lastMonth: {
                        month: this.getMonthName(lastMonth.getMonth()),
                        accuracy: this.getAccuracy(this.questions.filter(function (question) {
                            return lastMonth.getMonth() === question.date - 1
                        }))
                    },
                    twoMonthsAgo: {
                        month: this.getMonthName(twoMonthsAgo.getMonth()),
                        accuracy: this.getAccuracy(this.questions.filter(function (question) {
                            return twoMonthsAgo.getMonth() === question.date - 1
                        }))
                    },
                    threeMonthsAgo: {
                        month: this.getMonthName(threeMonthsAgo.getMonth()),
                        accuracy: this.getAccuracy(this.questions.filter(function (question) {
                            return threeMonthsAgo.getMonth() === question.date - 1
                        }))
                    },
                    fourMonthsAgo: {
                        month: this.getMonthName(fourMonthsAgo.getMonth()),
                        accuracy: this.getAccuracy(this.questions.filter(function (question) {
                            return fourMonthsAgo.getMonth() === question.date - 1
                        }))
                    },
                    fiveMonthsAgo: {
                        month: this.getMonthName(fiveMonthsAgo.getMonth()),
                        accuracy: this.getAccuracy(this.questions.filter(function (question) {
                            return fiveMonthsAgo.getMonth() === question.date - 1
                        }))
                    }
                }
            },

            getExerciseCountPerMonthForLastSixMonths() {
                let thisMonth = new Date()
                let lastMonth = new Date()
                let twoMonthsAgo = new Date()
                let threeMonthsAgo = new Date()
                let fourMonthsAgo = new Date()
                let fiveMonthsAgo = new Date()

                lastMonth.setMonth(lastMonth.getMonth() - 1)
                twoMonthsAgo.setMonth(twoMonthsAgo.getMonth() - 2)
                threeMonthsAgo.setMonth(threeMonthsAgo.getMonth() - 3)
                fourMonthsAgo.setMonth(fourMonthsAgo.getMonth() - 4)
                fiveMonthsAgo.setMonth(fiveMonthsAgo.getMonth() - 5)

                return {
                    thisMonth: {
                        month: this.getMonthName(thisMonth.getMonth()),
                        exerciseCount: this.exercises.filter(function (exercise) {
                            return thisMonth.getMonth() === exercise.date - 1
                        }).length
                    },
                    lastMonth: {
                        month: this.getMonthName(lastMonth.getMonth()),
                        exerciseCount: this.exercises.filter(function (exercise) {
                            return lastMonth.getMonth() === exercise.date - 1
                        }).length
                    },
                    twoMonthsAgo: {
                        month: this.getMonthName(twoMonthsAgo.getMonth()),
                        exerciseCount: this.exercises.filter(function (exercise) {
                            return twoMonthsAgo.getMonth() === exercise.date - 1
                        }).length
                    },
                    threeMonthsAgo: {
                        month: this.getMonthName(threeMonthsAgo.getMonth()),
                        exerciseCount: this.exercises.filter(function (exercise) {
                            return threeMonthsAgo.getMonth() === exercise.date - 1
                        }).length
                    },
                    fourMonthsAgo: {
                        month: this.getMonthName(fourMonthsAgo.getMonth()),
                        exerciseCount: this.exercises.filter(function (exercise) {
                            return fourMonthsAgo.getMonth() === exercise.date - 1
                        }).length
                    },
                    fiveMonthsAgo: {
                        month: this.getMonthName(fiveMonthsAgo.getMonth()),
                        exerciseCount: this.exercises.filter(function (exercise) {
                            return fiveMonthsAgo.getMonth() === exercise.date - 1
                        }).length
                    }
                }
            }
        },

        computed: {
            totalAccuracy: function () {
                return Math.floor(this.getAccuracy(this.questions))
            },

            intervalCountPerInterval: function () {
                let intervalData = {
                    labels: [],
                    data: []
                }

                for (let interval in this.intervals) {
                    intervalData.labels.push(interval)
                    intervalData.data.push(this.intervals[interval].amount)
                }

                return intervalData
            },

            intervalAccuracyPerInterval: function () {
                let intervalData = {
                    labels: [],
                    data: []
                }

                for (let interval in this.intervals) {
                    if (this.intervals[interval].accuracy !== null) {
                        intervalData.labels.push(interval)
                        intervalData.data.push(this.intervals[interval].accuracy)
                    }
                }
                return intervalData
            },

            accuracyPerMonthForLastSixMonthsData: function () {
                let unsortedData = this.getAccuracyPerMonthForLastSixMonths()
                let accuracyData = {
                    labels: [],
                    data: []
                }

                for (let item in unsortedData) {
                    if (unsortedData[item].accuracy) {
                        accuracyData.labels.push(unsortedData[item].month)
                        accuracyData.data.push(unsortedData[item].accuracy)
                    }
                }

                return accuracyData
            },

            exerciseCountPerMonthForLastSixMonthData: function () {
                let unsortedData = this.getExerciseCountPerMonthForLastSixMonths()
                let exerciseData = {
                    labels: [],
                    data: []
                }

                for (let item in unsortedData) {
                    if (unsortedData[item].exerciseCount) {
                        exerciseData.labels.push(unsortedData[item].month)
                        exerciseData.data.push(unsortedData[item].exerciseCount)
                    }
                }

                return exerciseData
            },

            correctQuestionCount: function () {
                return this.questions.filter(function (question) {
                    return question.answer === 1
                }).length
            },

            incorrectQuestionCount: function () {
                return this.questions.filter(function (question) {
                    return question.answer === 0
                }).length
            },

            doughnutAccuracyData: function () {
                return {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: ["Correct", "Incorrect"],
                    datasets: [
                        {
                            label: "Accuracy",
                            backgroundColor: ["#7e3af2"],
                            data: [this.correctQuestionCount, this.incorrectQuestionCount]
                        }
                    ]
                }
            },

            lineAccuracyData: function () {
                return {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: this.accuracyPerMonthForLastSixMonthsData.labels.reverse(),
                    datasets: [
                        {
                            label: 'Accuracy',
                            backgroundColor: ["#7e3af2", "#7e3af2", "#7e3af2", "#7e3af2", "#7e3af2", "#7e3af2"],
                            borderColor: ['#7e3af2'],
                            data: this.accuracyPerMonthForLastSixMonthsData.data.reverse(),
                            fill: false
                        }
                    ]
                }
            },

            lineExerciseData: function () {
                return {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: this.exerciseCountPerMonthForLastSixMonthData.labels.reverse(),
                    datasets: [
                        {
                            label: 'Count',
                            backgroundColor: ["#7e3af2", "#7e3af2", "#7e3af2", "#7e3af2", "#7e3af2", "#7e3af2"],
                            borderColor: ['#7e3af2'],
                            data: this.exerciseCountPerMonthForLastSixMonthData.data.reverse(),
                            fill: false
                        }
                    ]
                }
            },

            barIntervalData: function () {
                return {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: this.intervalCountPerInterval.labels,
                    datasets: [
                        {
                            label: 'Count',
                            backgroundColor: "#7e3af2",
                            borderColor: ['#7e3af2'],
                            data: this.intervalCountPerInterval.data,
                            fill: false
                        }
                    ]
                }
            },

            barIntervalAccuracyData: function () {
                return {
                    hoverBackgroundColor: "red",
                    hoverBorderWidth: 10,
                    labels: this.intervalAccuracyPerInterval.labels,
                    datasets: [
                        {
                            label: 'Accuracy',
                            backgroundColor: "#7e3af2",
                            borderColor: ['#7e3af2'],
                            data: this.intervalAccuracyPerInterval.data,
                            fill: false
                        }
                    ]
                }
            }
        }
    }
</script>
