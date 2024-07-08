<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {computed, onMounted, ref, reactive, PropType} from "vue";
import Deck from "@/Components/ITinder/Cards/Deck.vue";
import { UserInterface } from "@/types/UserInterface";

const props = defineProps({
    users: Array as PropType<UserInterface[]>,
});

const windowHeight = ref(window.innerHeight);

onMounted(() => {
    window.addEventListener('resize', () => {
        windowHeight.value = window.innerHeight;
    });
});

const computedHeight = computed(() => windowHeight.value - 65);
</script>

<template class="overflow-hidden">
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-center items-center relative overflow-hidden" :style="`height: ${computedHeight}px`">
            <Deck :users="props.users"/>

            <div
                id="center"
                class="top-1/2 left-1/2 absolute w-[305px] h-[405px] pointer-events-none -translate-x-1/2 -translate-y-1/2"
            ></div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
