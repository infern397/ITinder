<script setup lang="ts">
import { ref, computed, PropType } from 'vue';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import {router} from "@inertiajs/vue3";

// Интерфейс для локалей
interface Locales {
    [key: string]: string;
}

// Определение пропсов
const props = defineProps<{
    currentLocale: string;
    locales: Locales;
}>();

// Состояния для dropdown
const dropdownOpen = ref(false);

// Переключение dropdown
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

// Смена локали
const changeLocale = (locale: string) => {
    // Метод для изменения локали
    router.get(`/locale/${locale}`)
};

// Метка для текущей локали
const currentLocaleLabel = computed(() => {
    return props.locales[props.currentLocale] || 'Select Locale';
});
</script>

<template>
    <Dropdown align="right" width="48">
        <template #trigger>
      <span class="inline-flex rounded-md">
        <button
            type="button"
            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
        >
          {{ currentLocaleLabel }}
          <svg
              class="ms-2 -me-0.5 h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
          >
            <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
            />
          </svg>
        </button>
      </span>
        </template>

        <template #content>
            <div class="py-1">
                <DropdownLink
                    v-for="(label, locale) in locales"
                    :key="locale"
                    @click="changeLocale(locale)"
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    {{ label }}
                </DropdownLink>
            </div>
        </template>
    </Dropdown>
</template>

<style scoped>

</style>
