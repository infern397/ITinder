<script setup lang="ts">
import {onMounted, PropType} from "vue";
import interact from 'interactjs';
import {CardInterface} from "@/types/CardInterface";

const props = defineProps({
    card: Object as PropType<CardInterface>,
    index: Number,
    cards: Array as PropType<CardInterface[]>
});

const emit = defineEmits(['remove']);

const startListener = (event) => {
    // console.log(event.type, event.target);
};

const moveListener = (event) => {
    props.card.x += event.dx;
    props.card.y += event.dy;
    const rotate = props.card.x / 10;
    event.target.style.transform =
        `translate(${props.card.x}px, ${props.card.y}px) rotate(${rotate}deg)`;

    props.card.swipeDirection = props.card.x > 0 ? 'right' : 'left';
};

const endListener = (event) => {
    if (Math.abs(props.card.x) > 300) {
        event.target.classList.add('transition');
        event.target.classList.add('opacity-0');
        setTimeout(() => {
            emit('remove', props.index);
        }, 200);
    } else {
        resetCard(event.target);
    }
};

const resetCard = (target) => {
    target.classList.add('transition');
    target.style.transform = `translate(0px, 0px) rotate(0deg)`;

    setTimeout(() => {
        target.classList.remove('transition');
        props.card.x = 0;
        props.card.y = 0;
    }, 200);
};

onMounted(() => {
    const cardRef = `card-${props.card.id}`;
    interact(`.${cardRef}`).unset();

    interact(`.${cardRef}`)
        .draggable({
            listeners: {
                start: startListener,
                move: moveListener,
                end: endListener,
            },
            inertia: {
                resistance: 20,
                minSpeed: 150,
                endSpeed: 100,
            },
        });
});

</script>

<template>
    <div
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
