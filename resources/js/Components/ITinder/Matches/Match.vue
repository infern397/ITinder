<script setup lang="ts">
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    match: Object,
});
</script>

<template>
    <div class="flex flex-col p-3 text-gray-900 dark:text-gray-100 space-y-4">
        <div class="flex items-center space-x-4">
            <img :src="match.user.profile_picture" alt="Profile Picture" class="w-20 h-20 rounded object-cover">
            <div>
                <h2 class="text-2xl font-bold">{{ match.user.name }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ match.user.location }}</p>
            </div>
        </div>
        <div>
            <h3 class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">About</h3>
            <p class="p-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                {{ match.user.bio }}</p>
        </div>
        <div>
            <h3 class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Experience</h3>
            <p class="p-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300  rounded-md shadow-sm">
                {{ match.user.experience }}</p>
        </div>
        <div>
            <h3 class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Skills</h3>
            <ul class="flex flex-wrap gap-2 p-2 border-gray-300
            dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm rounded-md shadow-sm">
                <li class="p-2 text-sm rounded border border-gray-300" v-for="skill in match.user.skills"
                    :key="skill.id">{{ skill.name }}
                </li>
            </ul>
        </div>
        <div>
            <h3 class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Seeking Skills</h3>
            <ul class="flex flex-wrap gap-2 p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                rounded-md shadow-sm rounded-md shadow-sm">
                <li class="p-2 text-sm rounded border border-gray-300"
                    v-for="skill in match.user.seeking_skills" :key="skill.id">{{ skill.name }}
                </li>
            </ul>
        </div>
        <div class="flex gap-2">
            <PrimaryButton>Accept</PrimaryButton>
            <PrimaryButton>Reject</PrimaryButton>

        </div>
    </div>
</template>

<style scoped>

</style>
