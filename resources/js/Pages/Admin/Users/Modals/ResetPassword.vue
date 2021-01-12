<template>
    <div class="py-2">
        <label v-if="label" class="capitalize text-gray-700 font-semibold mb-2">
            {{ label }}
        </label>
        <div class="relative">
            <input type="password" class="block w-full mt-1 text-sm disabled:opacity-25 form-input" value="***************" disabled>
            <button @click="showModal = true" class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white bg-purple-600 rounded-r-md hover:bg-purple-700">
                Reset
            </button>
        </div>

        <dialog-modal :show="showModal" @close="back">
            <template #title>
                Reset password
            </template>

            <template #content>
                <div class="mt-4">
                    <password-input v-model="form.password" label="password"/>
                </div>
            </template>

            <template #footer>
                <secondary-button @click.native="back">
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
                console.log(this.$page.user);
                //this.$inertia.put(this.route('users.reset', this.$page.user.id), this.form);
            },

            back() {
                this.showModal = false;
                this.passwordError = null;
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
                    if (Object.keys(this.$page.errors).length > 0) {
                        this.error();
                    } else {
                        this.showModal = false;
                    }
                }
            },
        },
    }
</script>
