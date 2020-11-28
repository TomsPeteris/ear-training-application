<template>
    <button type="button"
            :id="id"
            class="m-1 w-full px-5 py-3 text-md leading-5 font-bold border rounded-md sm:px-4 sm:py-2 sm:w-auto transform"
            :class="{ 'text-gray-700 hover:scale-110': !isActive(), 'text-white hover:scale-110 bg-purple-400': isActive() }"
            @click="click">
        <slot />
    </button>
</template>

<script>
    export default {
        data() {
            return {
                clicked: false
            }
        },

        props: {
            // id: Number,
            id: {
                type: String,
                default() {
                    return `radio-button-${this._uid}`
                },
            },
            value: [Array, Boolean, String],

            item: [String, Boolean]
        },

        methods: {
            click() {
                if (Array.isArray(this.value)) {
                    this.operateArrayValue()
                } else {
                    this.operateValue()
                }
            },

            operateArrayValue() {
                if (this.isItemInArray()) {
                    let index = this.value.indexOf(this.item);
                    this.value.splice(index, 1);
                } else {
                    this.value.push(this.item)
                }
            },

            operateValue() {
                if (this.value === this.item) {
                    this.$emit('input', null)
                } else {
                    this.$emit('input', this.item)
                }
            },

            isActive() {
                if (Array.isArray(this.value)) {
                    return this.isItemInArray()
                } else {
                    return this.value === this.item
                }
            },

            isItemInArray() {
                return this.value.includes(this.item)
            }
        }
    }
</script>
