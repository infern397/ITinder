<script setup lang="ts">
import {computed, ref} from "vue";
import TextInput from "@/Components/TextInput.vue";

interface Skill {
    id: number;
    name: string;
}

const props = defineProps<{
    availableSkills: Skill[];
}>();

const emit = defineEmits<{
    (e: 'skill-added', skill: Skill): void;
}>();

const searchQuery = ref('');
const isFocused = ref(false);

const filteredSkills = computed(() => {
    const query = searchQuery.value.toLowerCase();
    if (query) {
        return props.availableSkills.filter(skill =>
            skill.name.toLowerCase().includes(query)
        );
    } else {
        return props.availableSkills;
    }
});

const addSkill = (skill: Skill) => {
    emit('skill-added', skill);
    searchQuery.value = '';
};

const onFocus = () => {
    isFocused.value = true;
};

const onBlur = () => {
    isFocused.value = false;
    searchQuery.value = '';
};
</script>

<template>
    <div class="mt-1">
        <TextInput
            class="block w-full"
            placeholder="Search skills..."
            @focus="onFocus"
            @blur="onBlur"
            v-model="searchQuery"/>
        <ul
            class="max-h-[200px] p-1 overflow-y-scroll mt-2 flex flex-wrap items-start gap-2 border-indigo-500 dark:text-gray-300
            rounded-md shadow-sm"
            v-show="filteredSkills.length && isFocused"
            @mousedown.prevent>
            <li class="bg-gray-900 rounded py-1 px-3 rounded cursor-pointer border border-gray-300 hover:border-indigo-500"
                v-for="skill in filteredSkills" :key="skill.id" @click="addSkill(skill)">
                {{ skill.name }}
            </li>
        </ul>
    </div>
</template>

<style scoped>

</style>
