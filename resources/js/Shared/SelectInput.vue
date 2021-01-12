<template>
    <div class="py-2">
        <label v-if="label" class="capitalize text-gray-700 font-semibold mb-2" :for="id">
            {{ label }}
        </label>
        <div v-if="option === null" :id="id" class="relative w-full text-left mb-2 outline-none rounded-md focus:border-purple-400 focus:shadow-outline-purple" @focus="focus" :tabindex="tabindex" @blur="blur">
            <div class="form-input text-sm mt-1 pl-3 cursor-pointer" :class="{ 'border-purple-400': selectFocus }" @click="open = !open">
                {{ selected }}
            </div>
            <div class="overflow-hidden bg-white border absolute z-10 w-full pb-1 pt-1 rounded-md" :class="{ 'hidden': !open }">
                <div class="cursor-pointer pl-3 text-sm hover:text-white hover:bg-purple-600" v-for="option in options"  :key="i" @click="selected = option; open = false; $emit('input', option);">
                    {{ option }}
                </div>
            </div>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>
        <div v-else class="relative w-full text-left mb-2 outline-none rounded-md">
            <div class="form-input text-sm mt-1 pl-3 opacity-50">
                {{ option }}
            </div>
        </div>
        <div v-show="error" class="mt-2 mb-4">
            <p class="text-sm text-red-600">
                {{ error }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selected: this.value ? this.value : this.options[0],
                open: false,
                selectFocus: false,
            };
        },

        props: {
            id: {
                type: String,
                default() {
                    return `text-input-${this._uid}`
                },
            },
            value: String,
            disabled: Boolean,
            label: String,
            error: String,
            options: Array,
            option: String,
            default: {
                type: String,
                default: null,
            },
            tabindex: {
                type: Number,
                default: 0,
            },
        },

        mounted() {
            this.$emit("input", this.selected);
        },

        methods: {
            blur() {
                this.open = false
                this.selectFocus = false
            },

            focus() {
                this.selectFocus = true
            }
        }
    };
</script>
