<script setup lang="ts">
import {TrashIcon} from '@heroicons/vue/24/solid'

interface Skill {
    id: number;
    name: string;
}

defineProps<{
    modelValue: Skill[];
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', skills: Skill[]): void;
    (e: 'skill-removed', skill: Skill): void;
}>();

const removeSkill = (skill: Skill) => {
    emit('skill-removed', skill);
};

</script>

<template>
    <div v-if="modelValue.length" class="text-white mt-1 mb-2" @mousedown.prevent>
        <ul class="flex flex-wrap gap-2 border-indigo-500 dark:text-gray-300
            rounded-md shadow-sm">
            <li class="flex items-center gap-1 rounded cursor-pointer border border-gray-300"
                v-for="skill in modelValue" :key="skill.id">
                <div class="py-1 px-3 ">
                    {{ skill.name }}
                </div>
                <div @click="removeSkill(skill)"
                     class="flex rounded items-center justify-center h-full py-1 px-2 hover:bg-gray-500
                     hover:text-gray-100">
                    <TrashIcon class="w-4 h-4 block"/>
                </div>
            </li>
        </ul>
    </div>
</template>

<style scoped>

</style>
