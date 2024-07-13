<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3';
import {PropType, ref} from "vue";

const props = defineProps({
    matches: {
        type: Array as PropType<Array<any>>,
        required: true,
    },
    currentMatch: {
        type: Object as PropType<any>,
        required: true,
    },
});
</script>

<template>
    <aside id="default-sidebar" class="z-40 h-full rounded-lg" aria-label="Sidebar">
        <div class="h-full rounded-lg p-1 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li v-for="match in matches" :key="match.id">
                    <Link :href="route('my-matches.index', { status: match.status, match: match.id,  })" preserve-scroll
                          class="flex items-center rounded py-2 px-1 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group"
                          :class="{ 'bg-gray-200 dark:bg-gray-700': currentMatch.id === match.id }">
                        <span class="ms-3">{{ match.user.name }}</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<style scoped></style>
