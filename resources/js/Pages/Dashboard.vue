<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, onMounted, ref, reactive, nextTick } from "vue";
import Deck from "@/Components/ITinder/Cards/Deck.vue";

const windowHeight = ref(window.innerHeight);
const cards = reactive([
    { id: 1, x: 0, y: 0 },
    { id: 2, x: 0, y: 0 },
    { id: 3, x: 0, y: 0 },
]);

onMounted(() => {
    window.addEventListener('resize', () => {
        windowHeight.value = window.innerHeight;
    });
});

const computedHeight = computed(() => windowHeight.value - 65);


</script>

<template class="overflow-hidden">
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="flex justify-center items-center relative overflow-hidden" :style="`height: ${computedHeight}px`">
            <Deck />

            <div
                id="center"
                class="top-1/2 left-1/2 absolute w-[305px] h-[405px] pointer-events-none -translate-x-1/2 -translate-y-1/2"
            ></div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
