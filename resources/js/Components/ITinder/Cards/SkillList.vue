<script setup lang="ts">
import { PropType } from "vue";

const props = defineProps({
    title: String,
    skills: Array as PropType<{ id: number; name: string }[]>,
    block: String,
    expandedBlock: String as PropType<string | null>
});
</script>

<template>
    <div class="rounded p-2" :class="{ 'hidden': expandedBlock && expandedBlock !== block }">
        <p class="text-gray-600 text-sm font-medium">{{ title }}:</p>
        <ul class="flex flex-wrap gap-1 text-sm border-indigo-500 dark:text-gray-700 rounded-md">
            <li class="px-1 rounded border border-gray-300" v-for="skill in skills" :key="skill.id">
                {{ skill.name }}
            </li>
        </ul>
    </div>
</template>

<style scoped>
/* Add styles if needed */
</style>
