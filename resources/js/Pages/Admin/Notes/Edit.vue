<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <inertia-link class="text-purple-400 hover:text-purple-700" :href="route('notes')">Notes</inertia-link>
            <span class="text-purple-400 font-medium">/</span> {{ note.name }}
        </h1>

        <!-- Page content -->
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form @submit.prevent="submit">
                <div class="flex flex-wrap -mx-3 p  b-3">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <text-input v-model="form.name" :error="form.error('name')" :disabled="true" label="Name" />
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <file-input v-model="form.file" type="file" :error="form.error('file')" label="Sound file" />
                    </div>
                </div>
                <div class="flex justify-end">
                    <primary-button class="ml-2" type="submit">Update</primary-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import AdminLayout from './../../../Layouts/AdminLayout'
    import PrimaryButton from "../../../Shared/PrimaryButton";
    import TextInput from "../../../Shared/TextInput";
    import FileInput from '../../../Shared/FileInput'

    export default {
        layout: AdminLayout,

        data() {
            return {
                form: this.$inertia.form({
                    name: this.note.name,
                    file_path: this.note.file,
                }),
            }
        },

        props: {
            note: Object,
        },

        components: {
            PrimaryButton,
            TextInput,
            FileInput,
        },

        methods: {
            submit() {
                const data = new FormData()
                data.append('file', this.form.file)
                data.append('_method', 'put')

                this.$inertia.post(this.route('notes.update', this.note.id), data);
            },
        },
    }
</script>
