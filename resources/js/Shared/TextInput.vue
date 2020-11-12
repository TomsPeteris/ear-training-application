<template>
    <div class="mb-2">
        <label v-if="label" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" :for="id">
            {{ label }}
        </label>
        <input :value="value"
               :id="id"
               type="text"
               :placeholder="placeholder"
               @input="$emit('input', $event.target.value)"
               class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
        <div v-show="error" class="mt-2 mb-4">
            <p class="text-sm text-red-600">
                {{ error }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                type: String,
                default() {
                    return `text-input-${this._uid}`
                },
            },
            value: String,
            placeholder: String,
            label: String,
            error: String,
        },
    }
</script>
