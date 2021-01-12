<template>
    <form-section @received="submit">

        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>

            <!-- Current password -->
            <password-input v-model="form.current_password" :error="form.error('current_password')" label="Current Password"/>

            <!-- New password -->
            <password-input v-model="form.password" :error="form.error('password')" label="New Password"/>

            <!-- New password confirmation -->
            <password-input v-model="form.password_confirmation" :error="form.error('password_confirmation')" label="Confirm Password"/>

        </template>

        <template #actions>

            <action-message :on="form.recentlySuccessful" class="mr-3">
                Password has been updated.
            </action-message>

            <primary-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </primary-button>

        </template>

    </form-section>
</template>

<script>
    import FormSection from '../../../Shared/FormSection'
    import PrimaryButton from '../../../Shared/PrimaryButton'
    import PasswordInput from '../../../Shared/PasswordInput'
    import ActionMessage from "../../../Shared/ActionMessage";

    export default {
        components: {
            FormSection,
            PrimaryButton,
            PasswordInput,
            ActionMessage
        },

        data() {
            return {
                form: this.$inertia.form({
                    current_password: null,
                    password: null,
                    password_confirmation: null,
                }, {
                    bag: 'updatePassword'
                }),
            }
        },

        methods: {
            // Update password request
            submit() {
                this.form.put(this.route('profile.update-password'))
            },
        },
    }
</script>
