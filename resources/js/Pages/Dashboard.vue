<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {computed, onMounted, ref,} from "vue";
import interact from 'interactjs';

const position = ref({x: 0, y: 0});



const card = ref(null);
const center = ref(null);

const windowHeight = ref(window.innerHeight);

onMounted(() => {
    window.addEventListener('resize', () => {
        windowHeight.value = window.innerHeight;
    });
});

const computedHeight = computed(() => windowHeight.value - 65);

onMounted(() => {

    interact(card.value)
        .draggable({
            listeners: {
                start(event) {
                    console.log(event.type, event.target)
                },
                move(event) {
                    position.value.x += event.dx
                    position.value.y += event.dy

                    const rotate = position.value.x / 10;

                    event.target.style.transform =
                        `translate(${position.value.x}px, ${position.value.y}px) rotate(${rotate}deg)`
                },

            },
            modifiers: [
                interact.modifiers.restrict({
                    restriction: center.value,
                    endOnly: true,
                    elementRect: {top: 0, left: 0, bottom: 1, right: 1}
                })
            ],
            inertia: {
                resistance: 20,
                minSpeed: 150,
                endSpeed: 100
            }
        })
})

</script>

<template class="overflow-hidden">
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-center items-center relative overflow-hidden" :style="`height: ${computedHeight}px`">
            <div
                class="card select-none touch-none flex items-center justify-center text-center rounded-lg shadow bg-white w-[300px] h-[400px]"
                ref="card">
                <div class="card-content">
                    x:{{ position.x }}
                    <br>
                    y:{{ position.y }}
                </div>
            </div>
            <div
                class="top-1/2 left-1/2 absolute w-[305px] h-[405px] pointer-events-none -translate-x-1/2 -translate-y-1/2"
                ref="center">
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>


.card-content {
    padding: 20px;
}
</style>
