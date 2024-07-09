<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    matches: Array,
});

</script>

<template>
    <aside id="default-sidebar" class="z-40  h-full rounded-lg" aria-label="Sidebar">
        <div class="h-full rounded-lg p-1 overflow-y-auto bg-gray-50 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li v-for="match of matches">
                    <Link :href="route('matches.show', { id: match.id })" preserve-scroll
                          class="flex items-center rounded py-2 px-1 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="ms-3">{{ match.user.name }}</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<style scoped>

</style>
