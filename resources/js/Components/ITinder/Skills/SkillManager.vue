<script setup lang="ts">

import SkillSelector from "@/Components/ITinder/Skills/SkillSelector.vue";
import SkillList from "@/Components/ITinder/Skills/SkillList.vue";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";

interface Skill {
    id: number;
    name: string;
}

const props = defineProps<{
    modelValue: Skill[];
    label: string;
    availableSkills: Skill[];
}>();

const availableSkillsCopy = ref([...props.availableSkills]);

const emit = defineEmits<{
    (e: 'update:modelValue', skills: Skill[]): void;
}>();

const selectedSkills = ref<Skill[]>([]);

const addSkill = (skill: Skill) => {
    if (!selectedSkills.value.some(s => s.id === skill.id)) {
        selectedSkills.value.push(skill);
        availableSkillsCopy.value = availableSkillsCopy.value.filter(s => s.id !== skill.id);
        emit('update:modelValue', selectedSkills.value);
    }
};

const removeSkill = (skill: Skill) => {
    selectedSkills.value = selectedSkills.value.filter(s => s.id !== skill.id);
    availableSkillsCopy.value.push(skill);
    availableSkillsCopy.value.sort((a, b) => a.id - b.id);
    emit('update:modelValue', selectedSkills.value);
};
</script>

<template class="text-white">
    <InputLabel for="skills" :value="label"/>
    <SkillList class="" v-model=selectedSkills @skill-removed="removeSkill"/>
    <SkillSelector :availableSkills="availableSkillsCopy" @skill-added="addSkill"/>
</template>

<style scoped>

</style>
