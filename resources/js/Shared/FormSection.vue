<template>

    <div class="md:grid md:grid-cols-3 md:gap-6">

        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium text-gray-900">
                    <slot name="title"></slot>
                </h3>

                <p class="mt-1 text-sm text-gray-600">
                    <slot name="description"></slot>
                </p>
            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <form @submit.prevent="$emit('received')">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <slot name="form"></slot>
                    </div>

                    <div class="flex items-center justify-end px-4 py-3 bg-white text-right sm:px-6" v-if="hasActions">
                        <slot name="actions"></slot>
                    </div>
                </div>
            </form>
        </div>

    </div>

</template>

<script>
    export default {
        computed: {
            hasActions() {
                return !! this.$slots.actions
            }
        }
    }
</script>
