<script setup lang="ts">
import {PropType, ref} from "vue";
import { UserInterface } from "@/types/UserInterface";
import ExpandableBlock from "@/Components/ITinder/Cards/ExpandableBlock.vue";
import SkillList from "@/Components/ITinder/Cards/SkillList.vue";
import {usePage} from "@inertiajs/vue3";

const strings = ref(usePage().props.strings);

const props = defineProps({
    user: Object as PropType<UserInterface>,
    expandedBlock: String as PropType<string | null>
});

const emit = defineEmits(['toggleExpandBlock']);

const toggleBlock = (block: string) => {
    emit('toggleExpandBlock', block);
};
</script>

<template>
    <div class="relative flex-grow gap-2 flex flex-col h-[100px]">
        <ExpandableBlock
            :title="strings['matches']['about']"
            :content="user.bio"
            :block="'about'"
            :expandedBlock="expandedBlock"
            @toggleExpandBlock="toggleBlock"
        />
        <ExpandableBlock
            :title="strings['matches']['experience']"
            :content="user.experience"
            :block="'experience'"
            :expandedBlock="expandedBlock"
            @toggleExpandBlock="toggleBlock"
        />
        <div class="w-full overflow-y-auto border border-gray-300 rounded flex-grow">
            <SkillList
                :title="strings['matches']['skills']"
                :skills="user.skills"
                :block="'skills'"
                :expandedBlock="expandedBlock"
            />
            <SkillList
                :title="strings['matches']['seeking-skills']"
                :skills="user.seeking_skills"
                :block="'seeking-skills'"
                :expandedBlock="expandedBlock"
            />
        </div>
    </div>
</template>

<style scoped>
/* Add styles if needed */
</style>
