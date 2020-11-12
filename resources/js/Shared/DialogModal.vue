<template>
    <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
        <div class="px-6 py-4 bg-gray-800 text-white">
            <div class="text-lg">
                <slot name="title">
                </slot>
            </div>
        </div>

        <div class="px-6 py-4 mr-6 ml-6">
            <div class="mt-4">
                <slot name="content">
                </slot>
            </div>
        </div>

        <div class="px-6 py-4 border text-right">
            <slot name="footer">
            </slot>
        </div>
    </modal>
</template>

<script>
    import Modal from './Modal'

    export default {
        components: {
            Modal,
        },

        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: '2xl'
            },
            closeable: {
                default: true
            },
        },

        methods: {
            close() {
                this.$emit('close')
            },
        }
    }
</script>
