<script setup lang="ts">
import {onMounted, PropType} from 'vue';
import {UserInterface} from '@/types/UserInterface';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Sidebar from "@/Components/ITinder/Matches/Sidebar.vue";

const props = defineProps({
    users: Array as PropType<UserInterface[]>,
});

onMounted(
    () => {
        console.log(props.users);
    }
)

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Matches</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="flex gap-3 p-2 bg-white w-full dark:text-gray-200
                     dark:bg-gray-800 shadow sm:rounded-lg">
                    <a href="#" class="text-center p-2 px-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="flex-1 p-2 whitespace-nowrap">New</span>
                    </a>
                    <a href="#" class="text-center p-2 px-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="flex-1 p-2 whitespace-nowrap">Accepted</span>
                    </a>
                    <a href="#" class="text-center p-2 px-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <span class="flex-1 p-2 whitespace-nowrap">Rejected</span>
                    </a>
                </div>
                <div class="sm:grid grid-cols-12 gap-3">
                    <div class="bg-white col-span-4 lg:col-span-3
                     dark:bg-gray-800 shadow sm:rounded-lg">
                        <Sidebar class="transition-transform -translate-x-full sm:translate-x-0"/>
                    </div>
                    <div class="bg-white col-span-8 lg:col-span-9 dark:bg-gray-800 shadow rounded-lg">
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
