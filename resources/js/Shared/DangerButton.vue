<template>
    <button :type="type" class="px-4 py-2 bg-red-600 rounded-md font-semibold text-white capitalise hover:bg-red-600">
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
