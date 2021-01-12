<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex flex-col items-center my-5">
                <a class="text-2xl font-bold">Registration</a>
            </div>
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <text-input v-model="form.first_name" :error="form.error('first_name')" label="First Name" placeholder="jane.doe" />
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <text-input v-model="form.last_name" :error="form.error('last_name')" label="Last Name" placeholder="Jane Doe" />
                    </div>
                </div>
                <text-input v-model="form.email" :error="form.error('email')" label="Email" placeholder="jane.doe@example.com" />
                <password-input v-model="form.password" :error="form.error('password')" label="Password"/>
                <password-input v-model="form.password_confirmation" :error="form.error('repeat_password')" label="Confirm Password"/>
                <div class="grid grid-cols-2 justify-items-end mt-4">
                    <inertia-link href="/login" class="underline text-sm text-gray-600 hover:text-gray-900 justify-self-start">
                        Already have an account?
                        <br>
                        Login
                    </inertia-link>

                    <primary-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </primary-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import PrimaryButton from '../../Shared/PrimaryButton'
import TextInput from '../../Shared/TextInput'
import PasswordInput from '../../Shared/PasswordInput'

export default {
    components: {
        PrimaryButton,
        TextInput,
        PasswordInput
    },
    data() {
        return {
            form: this.$inertia.form({
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: ''
            })
        }
    },
    methods: {
        submit() {
            this.form.post('/register').then(() => {
                this.form.password = ''
                this.form.password_confirmation = ''
            })
        }
    }
}
</script>
