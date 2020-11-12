<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <inertia-link class="text-purple-400 hover:text-purple-700" :href="route('users')">Users</inertia-link>
            <span class="text-purple-400 font-medium">/</span> {{ user.full_name }}
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
                <password-input v-model="form.password_confirm" :error="form.error('repeat_password')" label="Repeat Password"/>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <file-input v-model="form.avatar" type="file" accept="image/*" label="Photo" />
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <select-input v-model="form.role" :options="roles" label="Role" />
                    </div>
                </div>
                <div class="flex justify-end">
                    <danger-button @click.native="destroy">Delete Account</danger-button>
                    <primary-button class="ml-2" type="submit">Update</primary-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import AdminLayout from './../../../Layouts/AdminLayout'
    import DangerButton from './../../../Shared/DangerButton'
    import PrimaryButton from "../../../Shared/PrimaryButton";
    import TextInput from "../../../Shared/TextInput";
    import PasswordInput from "../../../Shared/PasswordInput";
    import SelectInput from "../../../Shared/SelectInput";
    import FileInput from '../../../Shared/FileInput'

    export default {
        layout: AdminLayout,

        data() {
            return {
                form: this.$inertia.form({
                    username: this.user.username,
                    full_name: this.user.full_name,
                    email: this.user.email,
                    password: null,
                    password_confirm: null,
                    avatar: this.user.avatar,
                    role: this.user.role,
                }),
            }
        },

        props: {
            user: Object,
            roles: Array,
        },

        components: {
            PrimaryButton,
            TextInput,
            PasswordInput,
            SelectInput,
            FileInput,
            DangerButton,
        },

        methods: {
            submit() {
                const data = new FormData()
                data.append('username', this.form.username)
                data.append('full_name', this.form.full_name)
                data.append('email', this.form.email)
                if(this.form.password) {
                    data.append('password', this.form.password)
                    data.append('password_confirmation', this.form.password)
                }
                if (this.form.role.id !== this.user.role.id) {
                    data.append('role_id', this.form.role.id)
                }
                if (this.form.avatar) {
                    data.append('avatar', this.form.avatar)
                }
                data.append('_method', 'put')

                this.$inertia.post(this.route('users.update', this.user.id), data);
            },

            destroy() {
                this.$inertia.delete(this.route('users.destroy', this.user.id));
            }
        },
    }
</script>
