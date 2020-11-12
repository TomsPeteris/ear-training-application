<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

            <div class="mt-8 text-2xl">
                Admin dashboard
            </div>

            <div class="mt-6 text-gray-500">
                This is the main hub of activity for admins to which they get redirected after authentication
                and from which they can navigate to other parts of the app.
            </div>
        </div>

    </div>
</template>

<script>
    import JetApplicationLogo from './../../Jetstream/ApplicationLogo'

    export default {
        components: {
            JetApplicationLogo,
        },
    }
</script>
