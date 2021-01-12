<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-purple-600 rounded-md font-semibold text-white capitalize tracking-widest hover:bg-purple-700">
        <slot />
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    }
</script>
