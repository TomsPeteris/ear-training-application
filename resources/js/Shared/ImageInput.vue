<template>
    <div class="py-2">
        <label v-if="label" class="capitalize text-gray-700 font-semibold mb-2">{{ label }}</label>
            <div v-if="value">
                <div class="m-2">
                    <img :src="previewImage ? previewImage : $page.current_user.avatar" alt="No image found" class="rounded-md h-32 w-32 object-cover">
                </div>
            </div>
            <div class="flex-auto self-center">
                <div :class="{ 'border-red-600': error }" class="block w-full text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input">
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
                <div v-show="error" class="mt-2 mb-4">
                    <p class="text-sm text-red-600">
                        {{ error }}
                    </p>
                </div>
            </div>
        </div>
</template>

<script>
    import PrimaryButton from './PrimaryButton'

    export default {
        components: {PrimaryButton},
        data() {
            return {
                previewImage: null,
            }
        },

        props: {
            value: File,
            label: String,
            accept: String,
            error: String,
        },

        watch: {
            value(value) {
                if (!value) {
                    this.$refs.file.value = ''
                } else {
                    this.previewImage = URL.createObjectURL(this.value)
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
