<template>
    <div>
        <a v-if="$page.flash.success && show" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-white bg-green-400 rounded-lg shadow-md focus:outline-none focus:shadow-outline-green">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-4 mr-2 flex-shrink-0 w-4 h-4 fill-current">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <div class="text-white text-sm font-medium">{{ $page.flash.success }}</div>
            </div>
            <button type="button" class="group text-green-600 hover:text-white mr-2 p-2" @click="show = false">
                <svg class="block w-2 h-2 fill-current" xmlns="http://www.w3.org/2000/svg" width="235.908" height="235.908" viewBox="278.046 126.846 235.908 235.908">
                    <path d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z" />
                </svg>
            </button>
        </a>
        <a v-if="($page.flash.error || Object.keys($page.errors).length > 0) && show" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-white bg-red-500 rounded-lg shadow-md focus:outline-none focus:shadow-outline-red">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ml-4 mr-2 flex-shrink-0 w-4 h-4 fill-current">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <div v-if="$page.flash.error" class="text-white text-sm font-medium">{{ $page.flash.error }}</div>
                <div v-else class="text-sm font-medium">
                    <span v-if="Object.keys($page.errors).length === 1">There is one form error.</span>
                    <span v-else>There are {{ Object.keys($page.errors).length }} form errors.</span>
                </div>            </div>
            <button type="button" class="group text-red-800 hover:text-white mr-2 p-2" @click="show = false">
                <svg class="block w-2 h-2 fill-current" xmlns="http://www.w3.org/2000/svg" width="235.908" height="235.908" viewBox="278.046 126.846 235.908 235.908">
                    <path d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z" />
                </svg>
            </button>
        </a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                show: true,
            }
        },
        watch: {
            '$page.flash': {
                handler() {
                    this.show = true
                },
                deep: true,
            },
        },
    }
</script>
