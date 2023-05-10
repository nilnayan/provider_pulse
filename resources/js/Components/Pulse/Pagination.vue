<template>
    <div class="py-3 flex items-center justify-between border-t border-gray-200 sm:px-3">
        <span></span>
        <nav class="relative z-0 inline-flex rounded-md -space-x-px hover:cursor-pointer" aria-label="Pagination">
            <Component :is="link.url ? 'Link' : 'span'" v-for="link in links" :href="link.url" v-html="link.label"
                       class="relative inline-flex items-center px-2 py-1 border" :class="link.active ? active : inactive" />
        </nav>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
export default {
    components: {
        Link,
    },
    data() {
        return {
            active: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600",
            inactive: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50",
        }
    },
    props: {
        links: Array,
    },
}
</script>
