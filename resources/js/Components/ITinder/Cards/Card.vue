<script setup lang="ts">
import {onMounted, ref, PropType, computed} from "vue";
import interact from 'interactjs';
import { CardInterface } from "@/types/CardInterface";
import { UserInterface } from "@/types/UserInterface";
import UserProfile from "@/Components/ITinder/Cards/UserProfile.vue";
import CardDetails from "@/Components/ITinder/Cards/CardDetails.vue";

const props = defineProps({
    card: {
        type: Object as PropType<CardInterface & { user: UserInterface }>,
        default: () => ({ x: 0, swipeDirection: '', user: {} })
    },
    index: Number,
    cards: Array as PropType<CardInterface[]>
});

const emit = defineEmits(['remove']);

const isCardMoved = ref(false);
const expandedBlock = ref<string | null>(null);

const color = computed(() => {
    return Math.abs(props.card.x) > 100 ? (props.card.swipeDirection === 'right' ? 'green-glow' : 'red-glow') : '';
});

const toggleExpandBlock = (block: string) => {
    if (isCardMoved.value) return;
    expandedBlock.value = expandedBlock.value === block ? null : block;
};

const startListener = () => {
    isCardMoved.value = true;
};

const moveListener = (event) => {
    props.card.x += event.dx;
    props.card.y += event.dy;
    const rotate = props.card.x / 10;
    event.target.style.transform = `translate(${props.card.x}px, ${props.card.y}px) rotate(${rotate}deg)`;
    props.card.swipeDirection = props.card.x > 0 ? 'right' : 'left';
};

const endListener = (event) => {
    if (Math.abs(props.card.x) > 300) {
        event.target.classList.add('transition', 'opacity-0');
        setTimeout(() => emit('remove', props.index), 200);
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
        isCardMoved.value = false;
    }, 200);
};

onMounted(() => {
    const cardRef = `card-${props.card.id}`;
    interact(`.${cardRef}`).unset();
    interact(`.${cardRef}`).draggable({
        listeners: { start: startListener, move: moveListener, end: endListener },
        inertia: { resistance: 20, minSpeed: 150, endSpeed: 100 },
    });
});
</script>

<template>
    <div
        :class="`absolute transition-shadow select-none touch-none rounded-lg
        shadow-lg bg-white w-full h-full card-${card.id} ${color}`"
        :style="{ zIndex: cards.length - index }"
    >
        <div class="card-content p-1.5 sm:p-4 flex flex-col gap-2 h-full">
            <UserProfile :user="card.user" />
            <CardDetails
                :user="card.user"
                :expandedBlock="expandedBlock"
                @toggleExpandBlock="toggleExpandBlock"
            />
        </div>
    </div>
</template>

<style scoped>
.transition {
    transition: all 0.2s ease-out;
}

.green-glow {
    box-shadow: 0 0 10px 5px rgba(0, 255, 0, 0.5);
}

.red-glow {
    box-shadow: 0 0 10px 5px rgba(255, 0, 0, 0.5);
}

.expanded {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 10;
    overflow-y: auto;
}

.hidden {
    display: none;
}
</style>
