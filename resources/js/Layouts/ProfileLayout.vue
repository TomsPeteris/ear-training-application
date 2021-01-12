<template>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900 overflow-hidden">
        <div class="flex flex-col flex-1 w-full">
            <heading />
            <main class="h-full overflow-y-auto">
                <div class="container py-6 px-10 mx-auto grid">
                    <flash-messages />
                    <slot/>
                </div>
            </main>
        </div>
        <!-- Modal Portal -->
        <portal-target name="modal" multiple />
    </div>
</template>

<script>
import Heading from './Navigation/Profile/Heading'
import FlashMessages from "../Shared/FlashMessages"

export default {
    components: {
        Heading,
        FlashMessages
    },
}
</script>
