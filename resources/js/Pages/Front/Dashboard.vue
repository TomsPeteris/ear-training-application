<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700">
            Dashboard
        </h1>

        <!-- Page content -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="mt-8 text-2xl">
                    User dashboard
                </div>

                <div class="mt-6 text-gray-600">
                    This is the main hub of activity for administrators to which they get redirected after authentication
                    and from which they can navigate to other parts of the app.
                </div>

                <div class="mt-6 text-gray-600">
                    The <b>exercise module</b> can be accessed via sidebar navigation by clicking on
                    "Exercise" on the left side of the screen or via this
                    <inertia-link class="text-blue-700 underline" :href="route('exercise')">
                        link.
                    </inertia-link>
                    There you will be asked to choose type of the exercise you want to complete. After that you will
                    be asked to choose parameters based on which the exercise will be generated. If there aren't any
                    conflicting parameters, you will be redirected to the exercise where you have to listen to questions
                    and choose the correct answers.
                </div>

                <div class="mt-6 mb-8 text-gray-600">
                    Likewise also the <b>history module</b> can be accessed via sidebar navigation by clicking on "History" or via this.
                    <inertia-link class="text-blue-700 underline" :href="route('history')">
                        link
                    </inertia-link>
                    There you can view all your exercise history data. They are displayed in a descending order based
                    on creation date so the last completed exercise will always be on the top! By clicking on any of
                    the exercises you can view a small overview about that exercise to help you understand what are
                    your strengths and weaknesses.
                </div>

                <div class="mt-6 mb-8 text-gray-600">
                    Lastly there is the <b>statistics module</b> that can be accessed via sidebar navigation by clicking on "Statistics" or via this.
                    <inertia-link class="text-blue-700 underline" :href="route('statistics')">
                        link
                    </inertia-link>
                    There you can view you overall performance data like accuracy, exercise count, accuracy and exercise
                    per last 6 months etc. This module is meant to give you an additional feedback so that you can
                    see your progress as well as better decide on what to focus on during your exercises.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'

    export default {
        layout: AppLayout,
    }
</script>
