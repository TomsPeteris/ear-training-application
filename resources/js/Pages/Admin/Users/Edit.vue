<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <inertia-link class="text-purple-400 hover:text-purple-700" :href="route('users')">Users</inertia-link>
            <span class="text-purple-400 font-medium">/</span> {{ user.first_name + ' ' + user.last_name }}
        </h1>

        <!-- Page content -->
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div v-if="user.avatar" class="flex">
                <img :src="user.avatar" alt="No avatar available" class="w-40 h-40 rounded-full justify-self-center content-center ml-5 mt-5 mr-10" />
                <div class="w-full mt-3">
                    <text-input v-model="form.first_name" :error="form.error('first_name')" label="First Name" placeholder="Jane" disabled/>
                    <text-input v-model="form.last_name" :error="form.error('last_name')" label="Last Name" placeholder="Doe" disabled/>
                </div>
            </div>
            <div v-else class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <text-input v-model="form.first_name" :error="form.error('first_name')" label="First Name" placeholder="Jane" disabled/>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <text-input v-model="form.last_name" :error="form.error('last_name')" label="Last Name" placeholder="Doe" disabled/>
                </div>
            </div>
            <text-input v-model="form.email" :error="form.error('email')" label="Email" placeholder="jane.doe@example.com" disabled/>
            <div class="flex -mx-3 mb-6">
                <div class="w-1/2 px-3">
                    <reset-password class="" label="Password"/>
                </div>
                <div class="w-1/2 px-3">
                    <select-input v-model="form.role" :disabled="isRoleSuperior($page.current_user.role)" :options="roles" :option="role" label="Role" />
                </div>
            </div>
            <div v-if="isRoleSuperior($page.current_user.role)" class="flex justify-end">
                <danger-button @click.native="destroy">Delete Account</danger-button>
                <primary-button class="ml-2" @click.native="submit">Update</primary-button>
            </div>
        </div>
    </div>
</template>

<script>
    import AdminLayout from './../../../Layouts/AdminLayout'
    import DangerButton from './../../../Shared/DangerButton'
    import PrimaryButton from '../../../Shared/PrimaryButton'
    import TextInput from '../../../Shared/TextInput'
    import SelectInput from '../../../Shared/SelectInput'
    import ImageInput from '../../../Shared/ImageInput'
    import ResetPassword from './Modals/ResetPassword'

    export default {
        layout: AdminLayout,

        data() {
            return {
                form: this.$inertia.form({
                    first_name: this.user.first_name,
                    last_name: this.user.last_name,
                    email: this.user.email,
                    role: this.user.role,
                }, {
                    bag: 'updateUser'
                }),
            }
        },

        props: {
            user: Object,
            roles: [String, Array],
        },

        computed: {
            role: function () {
                return this.$page.current_user.role === 'Admin' ? 'Member' : null
            }
        },

        components: {
            PrimaryButton,
            TextInput,
            SelectInput,
            ImageInput,
            DangerButton,
            ResetPassword
        },

        methods: {
            // Update user request
            submit() {
                this.form.put(this.route('users.update', this.user.id));
            },

            // Delete user request
            destroy() {
                this.$inertia.delete(this.route('users.destroy', this.user.id));
            },

            // Checks if the current user role is superior to the selected user role
            isRoleSuperior(role) {
                switch (role) {
                    case 'Super Admin':
                        return true;
                    case 'Admin':
                        return !(this.user.role === 'Admin' || this.user.role === 'Super Admin');
                    default:
                        return false
                }
            }
        },
    }
</script>
