<template>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <profile-information />

        <section-border />

        <profile-password class="mt-10 sm:mt-0" />

        <section-border />

        <profile-termination class="mt-10 sm:mt-0" />

    </div>

</template>

<script>
    import ProfileLayout from '../../../Layouts/ProfileLayout'
    import ProfileTermination from './ProfileTermination'
    import SectionBorder from '../../../Shared/SectionBorder'
    import ProfilePassword from './ProfilePassword'
    import ProfileInformation from './ProfileInformation'

    export default {
        layout: ProfileLayout,

        components: {
            ProfileTermination,
            SectionBorder,
            ProfilePassword,
            ProfileInformation,
        },
    }
</script>
