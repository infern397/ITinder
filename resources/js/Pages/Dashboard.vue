<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {computed, onMounted, ref, reactive, PropType} from "vue";
import Deck from "@/Components/ITinder/Cards/Deck.vue";
import { UserInterface } from "@/types/UserInterface";

const props = defineProps({
    users: {
        type: Array as PropType<UserInterface[]>,
        required: true
    },
    newUsers: {
        type: Array as PropType<UserInterface[]>,
        required: false,
        default: () => []
    }
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
        <div class="flex justify-center items-center relative overflow-hidden py-10 md:py-20" :style="`height: ${computedHeight}px`">
            {{ newUsers }}
            <Deck :users="props.users" :new-users="props.newUsers"/>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
