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
                        <text-input v-model="form.username" :error="form.error('username')" label="Username" placeholder="jane.doe" />
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <text-input v-model="form.full_name" :error="form.error('full_name')" label="Full Name" placeholder="Jane Doe" />
                    </div>
                </div>
                <text-input v-model="form.email" :error="form.error('email')" label="Email" placeholder="jane.doe@example.com" />
                <password-input v-model="form.password" :error="form.error('password')" label="Password"/>
                <password-input v-model="form.password_confirmation" :error="form.error('repeat_password')" label="Confirm Password"/>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <file-input v-model="form.avatar" :error="form.error('avatar')" type="file" accept="image/*" label="Photo" />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <select-input v-model="form.role" :options="roles" :error="form.error('role')" label="Role"/>
                    </div>
                </div>
                <div class="flex justify-end">
                    <secondary-button @click.native="back">Back</secondary-button>
                    <primary-button class="ml-2" type="submit">Create</primary-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import PrimaryButton from '../../../Shared/PrimaryButton'
    import TextInput from '../../../Shared/TextInput'
    import PasswordInput from "../../../Shared/PasswordInput";
    import JetInputError from '../../../Jetstream/InputError'
    import SecondaryButton from '../../../Shared/SecondaryButton'
    import FileInput from "../../../Shared/FileInput";
    import SelectInput from "../../../Shared/SelectInput";
    import AdminLayout from "../../../Layouts/AdminLayout";

    export default {
        layout: AdminLayout,

        data() {
            return {
                form: this.$inertia.form({
                    username: null,
                    full_name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    avatar: null,
                    role: null,
                }),
            }
        },

        props: {
            roles: {
                default: null
            },
        },

        components: {
            PrimaryButton,
            TextInput,
            PasswordInput,
            SelectInput,
            JetInputError,
            SecondaryButton,
            FileInput,
        },

        methods: {
            submit() {
                const data = new FormData()
                data.append('username', this.form.username)
                data.append('full_name', this.form.full_name)
                data.append('email', this.form.email)
                data.append('password', this.form.password)
                data.append('password_confirmation', this.form.password)
                if (this.form.avatar) {
                    data.append('avatar', this.form.avatar)
                }
                data.append('role', this.form.role)

                this.$inertia.post(this.route('users.store'), data);
            },

            back() {
                console.log(this.$page);
                this.$inertia.visit(this.route('users'), { method: 'get' });
            }
        }
    }
</script>
