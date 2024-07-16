<script setup lang="ts">
import {computed, onMounted, ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';
import LocaleDropdown from "@/Components/ITinder/LocaleDropdown.vue";

const showingNavigationDropdown = ref(false);

const currentLocale = ref(usePage().props.currentLocale);
const locales = ref({
    en: 'English',
    ru: 'Русский',
});

const newMessagesAmount = ref(usePage().props.newMessagesAmount);
const newMatchesAmount = ref(usePage().props.newMatchesAmount);
const strings = ref(usePage().props.strings);

const clippedNewMessagesAmount = computed(() => {
    const amount = newMessagesAmount;
    return amount > 99 ? '99+' : amount;
});

const clippedNewMatchesAmount = computed(() => {
    const amount = newMatchesAmount;
    return amount > 99 ? '99+' : amount;
});

onMounted(() => {
    window.Echo.channel(`messages.${usePage().props.auth.user.id}`)
        .listen('NewMessage', (e) => {
            newMessagesAmount.value = e.messageCount;
        });

    window.Echo.channel(`matches.${usePage().props.auth.user.id}`)
        .listen('NewMatch', (e) => {
            newMatchesAmount.value = e.matchesCount;
        });
});

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('matches.index')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('matches.index')" :active="route().current('matches.index')">
                                    {{ strings['header']['home'] }}
                                </NavLink>
                                <NavLink class="relative" :href="route('my-matches.index', { status: 'pending' })"
                                         :active="route().current('my-matches.index')">
                                    {{ strings['header']['matches'] }}
                                    <div v-if="newMatchesAmount > 0"
                                         class="absolute flex justify-center items-center top-[10%] right-[-10px] p-2 h-5 rounded-full bg-indigo-500">
                                        <div class="text-center text-sm">{{ clippedNewMatchesAmount }}</div>
                                    </div>
                                </NavLink>
                                <NavLink class="relative" :href="route('chat.index')"
                                         :active="route().current('chat.index')">
                                    {{ strings['header']['chat'] }}
                                    <div v-if="newMessagesAmount > 0"
                                         class="absolute flex justify-center items-center top-[10%] right-[-10px] p-2 h-5 rounded-full bg-indigo-500">
                                        <div class="text-center text-sm">{{ clippedNewMessagesAmount }}</div>
                                    </div>
                                </NavLink>
                            </div>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative flex">
                                <LocaleDropdown :currentLocale="currentLocale" :locales="locales"/>
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

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
                                        <DropdownLink :href="route('profile.edit')">{{ strings['header']['profile'] }}</DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            {{ strings['header']['logout'] }}
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <LocaleDropdown :currentLocale="currentLocale" :locales="locales"/>

                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('matches.index')" :active="route().current('matches.index')">
                            {{ strings['header']['home'] }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('my-matches.index', { status: 'pending' })" :active="route().current('my-matches.index')">
                            {{ strings['header']['matches'] }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('chat.index')" :active="route().current('chat.index')">
                            {{ strings['header']['chat'] }}
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">{{ strings['header']['profile'] }}</ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                {{ strings['header']['logout'] }}
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
