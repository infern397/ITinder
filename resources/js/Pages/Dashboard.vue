<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, onMounted, ref, reactive, nextTick } from "vue";
import interact from 'interactjs';

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


const initializeInteract = () => {
    cards.forEach((card, index) => {
        const cardRef = `card-${card.id}`;
        interact(`.${cardRef}`).unset();

        interact(`.${cardRef}`)
            .draggable({
                listeners: {
                    start(event) {
                        // console.log(event.type, event.target);
                    },
                    move(event) {
                        card.x += event.dx;
                        card.y += event.dy;
                        const rotate = card.x / 10;
                        event.target.style.transform =
                            `translate(${card.x}px, ${card.y}px) rotate(${rotate}deg)`;

                        card.swipeDirection = card.x > 0 ? 'right' : 'left';
                    },
                    end(event) {
                        if (Math.abs(card.x) > 300) {
                            event.target.classList.add('transition');
                            event.target.classList.add('opacity-0');
                            setTimeout(() => {
                                removeCard(index);
                            }, 200);
                        } else {
                            event.target.classList.add('transition');
                            event.target.style.transform = `translate(0px, 0px) rotate(0deg)`;

                            setTimeout(() => {
                                event.target.classList.remove('transition');
                                card.x = 0;
                                card.y = 0;
                            }, 200);
                        }
                    },
                },
                inertia: {
                    resistance: 20,
                    minSpeed: 150,
                    endSpeed: 100,
                },
            });
    });
};

const removeCard = (index: number) => {
    cards.splice(index, 1);
    nextTick(() => initializeInteract());
};

onMounted(() => {
    initializeInteract();
});
</script>

<template class="overflow-hidden">
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="flex justify-center items-center relative overflow-hidden" :style="`height: ${computedHeight}px`">
            <div class="deck relative w-[301px] h-[401px]" >
                <div
                    v-for="(card, index) in cards"
                    :key="card.id"
                    :class="`absolute transition-shadow select-none touch-none flex items-center justify-center
                    text-center rounded-lg shadow bg-white w-[300px] h-[400px] card-${card.id}
                    ${Math.abs(card.x) > 100 ? (card.swipeDirection === 'right' ? 'green-glow' : 'red-glow') : ''}`"
                    :ref="`card-${card.id}`"
                    :style="` z-index: ${cards.length - index};`"
                >
                    <div class="card-content">
                        id:{{ card.id }}
                        <br>
                        x:{{ card.x }}
                        y:{{ card.y }}
                    </div>
                </div>
            </div>

            <div
                id="center"
                class="top-1/2 left-1/2 absolute w-[305px] h-[405px] pointer-events-none -translate-x-1/2 -translate-y-1/2"
            ></div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.card-content {
    padding: 20px;
}

.transition {
    transition: all 0.2s ease-out;
}

.green-glow {
    box-shadow: 0 0 10px 5px rgba(0, 255, 0, 0.5);
}

.red-glow {
    box-shadow: 0 0 10px 5px rgba(255, 0, 0, 0.5);
}
</style>
