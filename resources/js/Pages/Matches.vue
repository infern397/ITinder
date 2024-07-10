<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import Sidebar from "@/Components/ITinder/Matches/Sidebar.vue";
import Match from "@/Components/ITinder/Matches/Match.vue";
import { Link } from '@inertiajs/vue3';

const { props } = usePage();
const matches = ref(props.matches);
const selectedMatch = ref(props.selectedMatch);
const currentStatus = ref(props.currentStatus);

const statuses = [
    { label: 'New', value: 'pending' },
    { label: 'Accepted', value: 'accepted' },
    { label: 'Rejected', value: 'rejected' },
];

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Matches</h2>
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
                        <Sidebar :matches="matches" :current-match="selectedMatch" />
                    </div>
                    <div class="bg-white col-span-8 lg:col-span-9 dark:bg-gray-800 shadow rounded-lg">
                        <Match :match="selectedMatch" />
                    </div>
                </div>
                <div v-else>
                    <p class="text-center text-gray-500 dark:text-gray-400">No matches found</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
