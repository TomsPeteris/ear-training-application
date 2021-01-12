<template>
    <button :type="type" class="px-4 py-2 font-semibold text-white text-gray-700 border border-gray-300 hover:border-gray-500 rounded-md">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
        }
    }
</script>
