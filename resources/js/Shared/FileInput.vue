<template>
    <div class="mb-2">
        <label v-if="label" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">{{ label }}</label>
        <div class="block w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" :class="{ error: errors.length }">
            <input ref="file" type="file" :accept="accept" class="hidden" @change="change">
            <div v-if="!value">
                <button type="button" class="px-4 py-1 bg-purple-600 hover:bg-purple-700 rounded-md text-xs font-medium text-white" @click="browse">
                    Browse
                </button>
            </div>
            <div v-else class="flex items-center justify-between p-2 text-gray-700 border border-gray-200 rounded-md shadow-sm">
                <div class="flex-1 pr-1">{{ value.name }} <span class="text-gray-500 text-xs">({{ fileSize(value.size) }})</span></div>
                <button type="button" class="px-4 py-1 bg-purple-600 hover:bg-purple-700 rounded-md text-xs font-medium text-white" @click="remove">
                    Remove
                </button>
            </div>
        </div>
        <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
    </div>
</template>

<script>

    export default {
        props: {
            value: File,
            label: String,
            accept: String,
            errors: {
                type: Array,
                default: () => [],
            },
        },

        watch: {
            value(value) {
                if (!value) {
                    this.$refs.file.value = ''
                }
            },
        },

        methods: {
            fileSize(size) {
                let i = Math.floor(Math.log(size) / Math.log(1024))
                return (size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
            },

            browse() {
                this.$refs.file.click()
            },

            change(e) {
                this.$emit('input', e.target.files[0])
            },

            remove() {
                this.$emit('input', null)
            },
        },
    }

</script>
