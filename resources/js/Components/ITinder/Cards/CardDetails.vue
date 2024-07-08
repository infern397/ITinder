<script setup lang="ts">
import { PropType } from "vue";
import { UserInterface } from "@/types/UserInterface";
import ExpandableBlock from "@/Components/ITinder/Cards/ExpandableBlock.vue";
import SkillList from "@/Components/ITinder/Cards/SkillList.vue";

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
            title="About"
            :content="user.bio"
            :block="'about'"
            :expandedBlock="expandedBlock"
            @toggleExpandBlock="toggleBlock"
        />
        <ExpandableBlock
            title="Experience"
            :content="user.experience"
            :block="'experience'"
            :expandedBlock="expandedBlock"
            @toggleExpandBlock="toggleBlock"
        />
        <div class="w-full overflow-y-auto border border-gray-300 rounded flex-grow">
            <SkillList
                title="Skills"
                :skills="user.skills"
                :block="'skills'"
                :expandedBlock="expandedBlock"
            />
            <SkillList
                title="Seeking Skills"
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
