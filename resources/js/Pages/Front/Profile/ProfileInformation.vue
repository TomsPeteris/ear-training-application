<template>
    <form-section @received="submit">

        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>

            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4">
                <image-input v-model="form.avatar" :error="form.error('avatar')" type="file" accept="image/*" label="Avatar" />
            </div>

            <!-- Name -->
            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <text-input v-model="form.first_name" :error="form.error('first_name')" label="First Name" placeholder="Jane" />
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <text-input v-model="form.last_name" :error="form.error('last_name')" label="Last Name" placeholder="Doe" />
                </div>
            </div>

            <!-- Email -->
            <text-input v-model="form.email" :error="form.error('email')" label="Email" placeholder="jane.doe@example.com" />

        </template>

        <template #actions>

            <action-message :on="form.recentlySuccessful" class="mr-3">
                Profile information has been updated.
            </action-message>

            <primary-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </primary-button>

        </template>

    </form-section>
</template>

<script>
    import PrimaryButton from '../../../Shared/PrimaryButton'
    import FormSection from '../../../Shared/FormSection'
    import TextInput from '../../../Shared/TextInput'
    import ImageInput from '../../../Shared/ImageInput'
    import ActionMessage from '../../../Shared/ActionMessage'

    export default {
        components: {
            PrimaryButton,
            FormSection,
            TextInput,
            ImageInput,
            ActionMessage
        },

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'put',
                    first_name: this.$page.user.first_name,
                    last_name: this.$page.user.last_name,
                    email: this.$page.user.email,
                    avatar: this.$page.current_user.avatar ? new File(
                        [this.$page.current_user.avatar],
                        this.$page.current_user.avatar.split('\\').pop().split('/').pop()
                    ) : null,
                }, {
                    bag: 'updateProfileInformation'
                }),
                avatarPreview: null,
            }
        },

        methods: {
            // Update profile information request
            submit() {
                this.form.post(this.route('profile.update-information'));
            },
        },
    }
</script>
