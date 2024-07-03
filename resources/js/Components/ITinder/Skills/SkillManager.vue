<script setup lang="ts">

import SkillSelector from "@/Components/ITinder/Skills/SkillSelector.vue";
import SkillList from "@/Components/ITinder/Skills/SkillList.vue";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";

interface Skill {
    id: number;
    name: string;
}

defineProps<{
    modelValue: Skill[];
    label: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', skills: Skill[]): void;
}>();

const availableSkills = ref<Skill[]>([
    {id: 1, name: 'JavaScript'},
    {id: 2, name: 'Vue.js'},
    {id: 3, name: 'CSS'},
    {id: 4, name: 'HTML'},
    {id: 5, name: 'Node.js'},
    {id: 6, name: 'React'},
    {id: 7, name: 'Angular'},
    {id: 8, name: 'TypeScript'},
    {id: 9, name: 'Python'},
    {id: 10, name: 'Java'},
    {id: 11, name: 'C#'},
    {id: 12, name: 'C++'},
    {id: 13, name: 'C'},
    {id: 14, name: 'PHP'},
    {id: 15, name: 'Ruby'},
    {id: 16, name: 'Swift'},
    {id: 17, name: 'Kotlin'},
    {id: 18, name: 'Go'},
    {id: 19, name: 'Rust'},
    {id: 20, name: 'Dart'},
    {id: 21, name: 'Scala'},
    {id: 22, name: 'Perl'},
    {id: 23, name: 'Lua'},
    {id: 24, name: 'R'},
    {id: 25, name: 'Haskell'},
    {id: 26, name: 'Erlang'},
    {id: 27, name: 'Clojure'},
    {id: 28, name: 'F#'},
    {id: 29, name: 'Assembly'},
    {id: 30, name: 'Shell'},
    {id: 31, name: 'PowerShell'},
    {id: 32, name: 'Bash'},
    {id: 33, name: 'Makefile'},
    {id: 34, name: 'Batchfile'},
    {id: 35, name: 'Objective-C'},
    {id: 36, name: 'Vim script'},
    {id: 37, name: 'TeX'},
    {id: 38, name: 'Emacs Lisp'},
    {id: 39, name: 'Perl 6'},
    {id: 40, name: 'Racket'},
    {id: 41, name: 'Crystal'},
    {id: 42, name: 'Elixir'},
]);

const selectedSkills = ref<Skill[]>([]);

const addSkill = (skill: Skill) => {
    if (!selectedSkills.value.some(s => s.id === skill.id)) {
        selectedSkills.value.push(skill);
        availableSkills.value = availableSkills.value.filter(s => s.id !== skill.id);
        emit('update:modelValue', selectedSkills.value);
    }
};

const removeSkill = (skill: Skill) => {
    selectedSkills.value = selectedSkills.value.filter(s => s.id !== skill.id);
    availableSkills.value.push(skill);
    availableSkills.value.sort((a, b) => a.id - b.id);
    emit('update:modelValue', selectedSkills.value);
};
</script>

<template>
    <InputLabel for="skills" :value="label"/>
    <SkillList class="" v-model="selectedSkills" @skill-removed="removeSkill"/>
    <SkillSelector :availableSkills="availableSkills" @skill-added="addSkill"/>
</template>

<style scoped>

</style>
