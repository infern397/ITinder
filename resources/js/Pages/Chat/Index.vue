<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import {Link, usePage} from "@inertiajs/vue3";
import {PropType, ref} from "vue";
import {UserInterface} from "@/types/UserInterface";


const { users } = defineProps({
    users: {
        type: Array as PropType<UserInterface[]>,
        required: true
    }

});

</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                    <div class="mb-3 sm:mb-0 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <aside id="default-sidebar" class="z-40 h-full rounded-lg" aria-label="Sidebar">
                            <div class="h-full rounded-lg p-1 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                                <ul class="space-y-2 font-medium">
                                    <li v-for="user in users" :key="user.id">
                                        <Link :href="route('chat.chat', {'user': user.id})" preserve-scroll
                                              class="flex items-center rounded py-2 px-1 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 group"
                                              >
                                            <span class="ms-3">{{ user.name }}</span>
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </aside>
                    </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
