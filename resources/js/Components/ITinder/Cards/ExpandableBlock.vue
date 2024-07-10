<script setup lang="ts">
import {computed, PropType} from "vue";

const props = defineProps({
    title: String,
    content: String,
    block: String,
    expandedBlock: String as PropType<string | null>
});

const emit = defineEmits(['toggleExpandBlock']);

const toggleBlock = () => {
    emit('toggleExpandBlock', props.block);
};

const reduction = function(content: string): string {
    return content.substring(0, 100) + (content.length > 100 ? '...' : '');
};
</script>

<template>
    <div
        class="text-sm text-gray-600 border border-gray-300 rounded sm:p-1.5 p-1 bg-inherit cursor-pointer"
        @click="toggleBlock"
        :class="{ 'expanded': expandedBlock === block, 'hidden': expandedBlock && expandedBlock !== block }"
    >
        <p class="text-gray-600 font-medium">{{ title }}:</p>
        <p v-text="expandedBlock === block ? content : reduction(content)"></p>
    </div>
</template>

<style scoped>
.expanded {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    overflow-y: auto;
}
</style>
