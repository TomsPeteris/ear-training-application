<template>
    <div class="mt-6 -mb-1 flex flex-wrap">
        <template v-for="(link, key) in links">
            <div v-if="link.url === null" :key="key" class="mr-1 mb-1 px-4 py-3 text-sm border rounded-md text-gray-400">{{ link.label }}</div>
            <inertia-link v-else :key="key" class="mr-1 mb-1 px-4 py-3 text-sm border rounded-md" :class="{ 'bg-purple-600 text-white': link.active, 'hover:bg-white': !link.active }" :href="link.url">{{ link.label }}</inertia-link>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            links: Array,
        },
    }
</script>
