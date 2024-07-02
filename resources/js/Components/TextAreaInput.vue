<script setup lang="ts">
import {ref, onMounted, nextTick} from "vue";

const model = defineModel<string>({required: true});

const input = ref<HTMLTextAreaElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

const autoExpand = () => {
    nextTick(() => {
        if (input.value) {
            input.value.style.height = 'auto';
            input.value.style.height = input.value.scrollHeight + 'px';
        }
    });
};

defineExpose({focus: () => input.value?.focus()});

</script>

<template>
    <textarea
        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500
        dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        rows="3"
        placeholder="Some information about yourself."
        ref="input"
        @input="autoExpand"
    ></textarea>
</template>

<style scoped>

</style>
