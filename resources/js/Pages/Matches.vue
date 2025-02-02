<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage} from "@inertiajs/vue3";
import {computed, PropType, ref} from "vue";
import Sidebar from "@/Components/ITinder/Matches/Sidebar.vue";
import Match from "@/Components/ITinder/Matches/Match.vue";
import { Link } from '@inertiajs/vue3';
import {MatchInterface} from "@/types/UserInterface";
import {match} from "@headlessui/vue/dist/utils/match";

const strings = ref(usePage().props.strings);

const { matches, selectedMatch, currentStatus } = defineProps({
    matches: {
        type: Array as PropType<MatchInterface[]>,
        required: true
    },
    selectedMatch: {
        type: [Object, null] as PropType<MatchInterface | null>,
        required: true
    },
    currentStatus: {
        type: String as PropType<string>,
        required: true
    }
});

const statuses = [
    { label: strings.value['my-matches']['new'], value: 'pending' },
    { label: strings.value['my-matches']['accepted'], value: 'accepted' },
    { label: strings.value['my-matches']['rejected'], value: 'rejected' },
];

const headTitle = computed(() => {
    switch(currentStatus) {
        case 'pending':
            return strings.value['title']['new-matches'];
        case 'accepted':
            return strings.value['title']['accepted-matches'];
        case 'rejected':
            return strings.value['title']['rejected-matches'];
    }
});

</script>

<template>
    <Head :title="headTitle"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ strings['my-matches']['my-matches'] }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="flex gap-3 p-2 bg-white w-full dark:text-gray-200 dark:bg-gray-800 shadow sm:rounded-lg">
                    <Link v-for="status in statuses" :key="status.value" :href="route('my-matches.index', { status: status.value })" preserve-scroll class="text-center p-2 px-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group" :class="{ 'bg-gray-200 dark:bg-gray-700': currentStatus === status.value }">
                        <span class="flex-1 p-2 whitespace-nowrap">{{ status.label }}</span>
                    </Link>
                </div>
                <div v-if="matches.length > 0" class="sm:grid grid-cols-12 gap-3">
                    <div class="mb-3 sm:mb-0 bg-white col-span-4 lg:col-span-3 dark:bg-gray-800 shadow sm:rounded-lg">
                        <Sidebar v-if="selectedMatch"  :matches="matches" :current-match="selectedMatch" />
                    </div>
                    <div v-if="selectedMatch" class="bg-white col-span-8 lg:col-span-9 dark:bg-gray-800 shadow rounded-lg">
                        <Match :match="selectedMatch" />
                    </div>
                </div>
                <div v-else>
                    <p class="text-center text-gray-500 dark:text-gray-400">{{ strings['my-matches']['no-matches'] }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
