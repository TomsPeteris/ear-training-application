<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex flex-col items-center my-5">
                <a class="text-2xl font-bold">Login</a>
            </div>
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <text-input v-model="form.email" :error="form.error('email')" label="Email" placeholder="jane.doe@example.com" />
                <password-input v-model="form.password" :error="form.error('password')" label="Password" placeholder="**********"/>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox" name="remember" v-model="form.remember">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="grid grid-cols-2 justify-items-end mt-4">
                    <inertia-link href="/register" class="underline text-sm text-gray-600 hover:text-gray-900 justify-self-start">
                        Don't have an account? Register
                    </inertia-link>

                    <primary-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Login
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
    props: {
        status: String,
    },
    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false,
            })
        }
    },
    methods: {
        submit() {
            this.form.post('/login')
        }
    }
}
</script>
