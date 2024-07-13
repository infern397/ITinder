<script setup lang="ts">
import {PropType, ref} from "vue";
import { UserInterface } from "@/types/UserInterface";
import {usePage} from "@inertiajs/vue3";

const strings = ref(usePage().props.strings);

const props = defineProps({
    user: Object as PropType<UserInterface>
});
</script>

<template>
    <div class="flex gap-2 w-full ">
        <img :src="user.profile_picture" alt="Profile Picture" class="w-12 h-12 sm:w-16 sm:h-16 rounded object-cover">
        <div class="flex flex-col justify-around">
            <h2 class="text-l md:text-lg font-semibold mb-1">{{ user.name }}</h2>
            <p class="text-sm md:text-m">{{ strings['matches']['location'] }}: <span class="font-medium">{{ user.location }}</span></p>
        </div>
    </div>
</template>

<style scoped>
/* Add styles if needed */
</style>
