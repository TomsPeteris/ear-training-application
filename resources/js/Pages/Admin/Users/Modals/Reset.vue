<template>
    <div>
        <label v-if="label" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
            {{ label }}
        </label>
        <div class="relative mb-2">
            <input type="password" class="block w-full mt-1 text-sm disabled:opacity-25 form-input" value="Password" disabled>
            <button @click="showModal = true" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Reset
            </button>
        </div>

        <dialog-modal :show="showModal" @close="showModal = false">
            <template #title>
                Reset password
            </template>

            <template #content>
                <div class="mt-4">
                    <password-input v-model="form.password" :error="passwordError" label="new password"/>
                    <password-input v-model="form.password_confirmation" label="confirm password"/>

                </div>
            </template>

            <template #footer>
                <secondary-button @click.native="nevermind">
                    Nevermind
                </secondary-button>

                <primary-button class="ml-2" @click.native="submit">
                    Reset
                </primary-button>
            </template>
        </dialog-modal>
    </div>
</template>

<script>
    import PrimaryButton from '../../../../Shared/PrimaryButton'
    import PasswordInput from "../../../../Shared/PasswordInput"
    import SecondaryButton from '../../../../Shared/SecondaryButton'
    import DialogModal from "../../../../Shared/DialogModal"

    export default {
        data() {
            return {
                form: this.$inertia.form({
                    password: null,
                    password_confirmation: null,
                }),

                showModal: false,
                passwordError: null,
            }
        },

        props: {
            label: String,
        },

        components: {
            PrimaryButton,
            PasswordInput,
            SecondaryButton,
            DialogModal
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('users.reset', this.$page.user.id), this.form);
            },

            nevermind() {
                this.showModal = false;
            },

            error() {
                if (this.showModal) {
                    this.passwordError = this.form.error('password');
                    this.$page.errors = {};
                }
            }
        },

        watch: {
            '$page.flash': {
                handler() {
                    this.error()
                }
            },
        },
    }
</script>
