<script setup lang="ts">
import { PropType } from "vue";
import { UserInterface } from "@/types/UserInterface";

const props = defineProps({
    user: Object as PropType<UserInterface>
});
</script>

<template>
    <div class="flex gap-2 w-full">
        <img :src="user.profile_picture" alt="Profile Picture" class="w-16 h-16 rounded object-cover">
        <div class="flex flex-col">
            <h2 class="text-xl font-semibold mb-1">{{ user.name }}</h2>
            <p>Location: <span class="font-medium">{{ user.location }}</span></p>
        </div>
    </div>
</template>

<style scoped>
/* Add styles if needed */
</style>
