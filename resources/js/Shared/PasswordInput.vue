<template>
    <div class="mb-2">
        <label v-if="label" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" :for="id">
            {{ label }}
        </label>
        <input :value="value"
               :id="id"
               type="password"
               :placeholder="placeholder"
               @input="$emit('input', $event.target.value)"
               class="block w-full mt-1 text-sm focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input">
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
