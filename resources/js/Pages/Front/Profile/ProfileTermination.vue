<template>
    <action-section>
        <template #title>
            Delete Account
        </template>

        <template #description>
            Permanently delete your account.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <danger-button @click.native="confirmUserDeletion">
                    Delete Account
                </danger-button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <dialog-modal :show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
                <template #title>
                    Delete Account
                </template>

                <template #content>
                    Are you sure you want to delete your account? Once your account is deleted,
                    all of its resources and data will be permanently deleted. Please enter your
                    password to confirm you would like to permanently delete your account.
                    <div class="mt-4">
                        <password-input v-model="form.password" :error="form.error('password')" label="Password" placeholder="**********" @keyup.enter.native="submit"/>
                    </div>
                </template>

                <template #footer>
                    <secondary-button @click.native="confirmingUserDeletion = false">
                        Nevermind
                    </secondary-button>

                    <danger-button class="ml-2" @click.native="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Account
                    </danger-button>
                </template>
            </dialog-modal>
        </template>
    </action-section>
</template>

<script>
    import ActionSection from '../../../Shared/ActionSection'
    import DialogModal from '../../../Shared/DialogModal'
    import DangerButton from '../../../Shared/DangerButton'
    import SecondaryButton from '../../../Shared/SecondaryButton'
    import FormSection from '../../../Shared/FormSection'
    import PasswordInput from '../../../Shared/PasswordInput'

    export default {
        components: {
            ActionSection,
            DangerButton,
            DialogModal,
            SecondaryButton,
            FormSection,
            PasswordInput
        },

        data() {
            return {
                confirmingUserDeletion: false,
                deleting: false,

                form: this.$inertia.form({
                    '_method': 'DELETE',
                    password: '',
                }, {
                    bag: 'deleteUser'
                })
            }
        },

        methods: {
            // Show modal function
            confirmUserDeletion() {
                this.form.password = '';

                this.confirmingUserDeletion = true;

                setTimeout(() => {
                    this.$refs.password.focus()
                }, 250)
            },

            // Delete profile request
            submit() {
                this.form.post(route('profile.delete'), {
                    preserveScroll: true
                }).then(response => {
                    if (! this.form.hasErrors()) {
                        this.confirmingUserDeletion = false;
                    }
                })
            },
        },
    }
</script>
