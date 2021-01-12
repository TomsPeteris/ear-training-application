<template>
    <div>

        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <inertia-link class="text-purple-400 hover:text-purple-700" :href="route('users')">Users</inertia-link>
            <span class="text-purple-400 font-medium">/</span> Create
        </h1>

        <!-- Page content -->
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form @submit.prevent="submit">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <text-input v-model="form.first_name" :error="form.error('first_name')" label="First Name" placeholder="Jane" />
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <text-input v-model="form.last_name" :error="form.error('last_name')" label="Last Name" placeholder="Doe" />
                    </div>
                </div>
                <text-input v-model="form.email" :error="form.error('email')" label="Email" placeholder="jane.doe@example.com" />
                <password-input v-model="form.password" :error="form.error('password')" label="Password"/>
                <password-input v-model="form.password_confirmation" :error="form.error('repeat_password')" label="Confirm Password"/>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-1/2 px-3">
                        <image-input v-model="form.avatar" :error="form.error('avatar')" type="file" accept="image/*" label="Photo" />
                    </div>
                    <div class="w-1/2 px-3">
                        <select-input v-model="form.role" :options="roles" :option="role" :error="form.error('role')" label="Role"/>
                    </div>
                </div>
                <div class="flex justify-end">
                    <secondary-button class="capitalize" @click.native="back">Back</secondary-button>
                    <primary-button class="ml-2" type="submit">Create</primary-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import PrimaryButton from '../../../Shared/PrimaryButton'
    import TextInput from '../../../Shared/TextInput'
    import PasswordInput from "../../../Shared/PasswordInput"
    import SecondaryButton from '../../../Shared/SecondaryButton'
    import ImageInput from '../../../Shared/ImageInput'
    import SelectInput from '../../../Shared/SelectInput'
    import AdminLayout from '../../../Layouts/AdminLayout'

    export default {
        layout: AdminLayout,

        data() {
            return {
                form: this.$inertia.form({
                    first_name: null,
                    last_name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    avatar: null,
                    role: null,
                }, {
                    bag: 'createUser'
                }),
                option: null
            }
        },

        props: {
            roles: {
                default: null
            },
        },

        computed: {
            role: function () {
                return this.$page.current_user.role === 'Admin' ? 'Member' : null
            }
        },

        components: {
            PrimaryButton,
            TextInput,
            PasswordInput,
            SelectInput,
            SecondaryButton,
            ImageInput,
        },

        methods: {

            submit() {
                this.form.post(this.route('users.store'));
            },

            back() {
                this.$inertia.visit(this.route('users'), { method: 'get' });
            },
        }
    }
</script>
