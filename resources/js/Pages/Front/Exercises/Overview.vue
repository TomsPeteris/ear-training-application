<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="px-6 mt-8 text-2xl font-semibold">
            Overview:
            <section-border />
        </div>
        <div class="px-20 mb-10">
            <div class="grid grid-cols-2">
                <div>
                    <p class="text-xl font-semibold">Interval count: {{ questions.length }}</p>
                    <p class="text-xl font-semibold">Accuracy: {{ correctnessPercentage }}%</p>
                </div>
                <div>
                    <p v-if="previousExerciseQuestions" class="text-xl font-semibold">Previous exercise accuracy: {{ previousExerciseCorrectness }}%</p>
                </div>
            </div>
            <section-border />
            <p class="text-xl font-semibold">Correct intervals: </p>
            <p v-for="question in correctQuestions" class="flex text-xl font-semibold">{{ question.interval.name }}</p>
            <section-border />
            <p class="text-xl font-semibold">Incorrect intervals: </p>
            <p v-for="question in incorrectQuestions" class="flex text-xl font-semibold">{{ question.interval.name }}</p>
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

    props: {
        questions: [Object, Array],
        incorrectQuestions: [Object, Array],
        correctQuestions: [Object, Array],
        previousExerciseQuestions: [Object, Array],
    },

    components: {
        SectionBorder,
        ProgressBar,
        SecondaryButton,
        PrimaryButton
    },

    computed: {
        correctnessPercentage: function () {
            return Math.round(this.correctQuestions.length * 100 / this.questions.length)
        },

        previousExerciseCorrectness: function () {
            let correctQuestionCount = this.previousExerciseQuestions.filter(question => question.answer === 1).length
            return Math.round(correctQuestionCount * 100 / this.previousExerciseQuestions.length)
        }
    }

}
</script>
