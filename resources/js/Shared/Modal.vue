<template>
    <portal to="modal">
        <transition leave-active-class="duration-200">
            <div v-show="show" class="z-40 overflow-auto left-0 top-0 bottom-0 right-0 w-full h-full fixed bg-opacity-50 bg-black">
                <transition enter-active-class="ease-out duration-300"
                            enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                            leave-active-class="ease-in duration-300"
                            leave-class="opacity-100 translate-y-0 sm:scale-100"
                            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div v-show="show" class="z-50 relative mx-auto my-0 max-w-lg mt-12">
                        <div class="bg-white shadow overflow-hidden relative rounded-md">
                            <slot></slot>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>
    </portal>
</template>

<script>
    export default {
        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: '3xl'
            },
            closeable: {
                default: true
            },
        },

        methods: {
            close() {
                if (this.closeable) {
                    this.$emit('close')
                }
            }
        },

        watch: {
            show: {
                immediate: true,
                handler: (show) => {
                    if (show) {
                        document.body.style.overflow = 'hidden'
                    } else {
                        document.body.style.overflow = null
                    }
                }
            }
        },

        created() {
            const closeOnEscape = (e) => {
                if (e.key === 'Escape' && this.show) {
                    this.close()
                }
            }

            document.addEventListener('keydown', closeOnEscape)

            this.$once('hook:destroyed', () => {
                document.removeEventListener('keydown', closeOnEscape)
            })
        },

        computed: {
            maxWidthClass() {
                return {
                    'sm': 'sm:max-w-sm',
                    'md': 'sm:max-w-md',
                    'lg': 'sm:max-w-lg',
                    'xl': 'sm:max-w-xl',
                    '2xl': 'sm:max-w-2xl',
                    '3xl': 'sm:max-w-3xl',
                }[this.maxWidth]
            }
        }
    }
</script>
