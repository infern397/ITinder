<script setup lang="ts">
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {router, usePage} from '@inertiajs/vue3';
import {MatchInterface} from "@/types/UserInterface";
import {PropType, ref} from "vue";

const strings = ref(usePage().props.strings);

const props = defineProps({
    match: Object as PropType<MatchInterface>,
});

const acceptMatch = function () {
    router.post(route('my-matches.accept', {match: props.match.id}), {}, {
        onSuccess: () => {
            router.get(route('my-matches.index', {status: 'accepted', match: props.match.id}));
        },

    });
};

const rejectMatch = function () {
    router.post(route('my-matches.reject', {match: props.match.id}), {}, {
        onSuccess: () => {
            router.get(route('my-matches.index', {status: 'rejected', match: props.match.id}));
        },
    });
};

const cancelMatch = function () {
    router.post(route('my-matches.cancel', {match: props.match.id}), {}, {
        onSuccess: () => {
            router.get(route('my-matches.index', {status: 'pending', match: props.match.id}));
        },
    });
}
</script>

<template>
    <div v-if="match" class="flex flex-col p-3 text-gray-900 dark:text-gray-100 space-y-4">
        <div class="flex items-center space-x-4">
            <img :src="match.user.profile_picture" alt="Profile Picture" class="w-20 h-20 rounded object-cover">
            <div>
                <h2 class="text-2xl font-bold">{{ match.user.name }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ match.user.location }}</p>
            </div>
        </div>
        <div>
            <h3 class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ strings['matches']['about'] }}</h3>
            <p class="p-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                {{ match.user.bio }}</p>
        </div>
        <div>
            <h3 class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ strings['matches']['experience'] }}</h3>
            <p class="p-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                {{ match.user.experience }}</p>
        </div>
        <div>
            <h3 class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ strings['matches']['skills'] }}</h3>
            <ul class="flex flex-wrap gap-2 p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                <li class="px-2 py-1 text-sm rounded border border-gray-300" v-for="skill in match.user.skills"
                    :key="skill.id">{{ skill.name }}
                </li>
            </ul>
        </div>
        <div>
            <h3 class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ strings['matches']['seeking-skills'] }}</h3>
            <ul class="flex flex-wrap gap-2 p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                <li class="px-2 py-1 text-sm rounded border border-gray-300" v-for="skill in match.user.seeking_skills"
                    :key="skill.id">{{ skill.name }}
                </li>
            </ul>
        </div>
        <div class="flex gap-2">
            <PrimaryButton v-if="match.status !== 'pending'" @click="cancelMatch">{{ strings['my-matches']['cancel'] }}</PrimaryButton>
            <PrimaryButton v-if="match.status !== 'accepted'" @click="acceptMatch">{{ strings['my-matches']['accept'] }}</PrimaryButton>
            <PrimaryButton v-if="match.status !== 'rejected'" @click="rejectMatch">{{ strings['my-matches']['reject'] }}</PrimaryButton>
        </div>
    </div>
</template>

<style scoped></style>
