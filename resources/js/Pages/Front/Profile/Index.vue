<template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <profile-information />

                <section-border />

                <profile-password class="mt-10 sm:mt-0" />

                <section-border />

                <profile-termination class="mt-10 sm:mt-0" />
            </div>
        </div>

</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'
    import ProfileTermination from './ProfileTermination'
    import SectionBorder from './../../Shared/SectionBorder'
    import ProfilePassword from './ProfilePassword'
    import ProfileInformation from './ProfileInformation'

    export default {
        layout: AppLayout,

        components: {
            ProfileTermination,
            SectionBorder,
            ProfilePassword,
            ProfileInformation,
        },
    }
</script>
