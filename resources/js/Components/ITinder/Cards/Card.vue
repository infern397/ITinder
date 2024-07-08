<script setup lang="ts">
import {onMounted, ref, PropType} from "vue";
import interact from 'interactjs';
import {CardInterface} from "@/types/CardInterface";
import {UserInterface} from "@/types/UserInterface";

const props = defineProps({
    card: Object as PropType<CardInterface & { user: UserInterface }>,
    index: Number,
    cards: Array as PropType<CardInterface[]>
});

const emit = defineEmits(['remove']);

const isCardMoved = ref(false);

const expandedBlock = ref<string | null>(null);

const toggleExpandBlock = (block: string) => {
    if (isCardMoved.value) {
        return;
    }

    if (expandedBlock.value === block) {
        expandedBlock.value = null;
    } else {
        expandedBlock.value = block;
    }
};

const startListener = (event) => {
    isCardMoved.value = true;

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
        isCardMoved.value = false;
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
        :class="`absolute transition-shadow select-none touch-none rounded-lg shadow-lg bg-white w-[400px] h-[500px] card-${card.id} ${Math.abs(card.x) > 100 ? (card.swipeDirection === 'right' ? 'green-glow' : 'red-glow') : ''}`"
        :ref="`card-${card.id}`"
        :style="` z-index: ${cards.length - index};`"
    >
        <div class="card-content p-4 flex flex-col gap-2 h-full">
            <div class="flex gap-2 w-full">
                <img :src="card.user.profile_picture" alt="Profile Picture"
                     class="w-16 h-16 rounded object-cover">
                <div class="flex flex-col">
                    <h2 class="text-xl font-semibold mb-1">{{ card.user.name }}</h2>
                    <p>Location: <span class="font-medium">{{ card.user.location }}</span></p>
                </div>
            </div>
            <div class="relative flex-grow gap-2 flex flex-col h-[100px]">
                <div
                    class="text-sm text-gray-600 border border-gray-300 rounded p-2 bg-inherit cursor-pointer"
                    @click="toggleExpandBlock('about')"
                    :class="{ 'expanded': expandedBlock === 'about', 'hidden': expandedBlock && expandedBlock !== 'about' }"
                >
                    <p class="text-gray-600 text-sm font-medium">About:</p>
                    <p v-text="expandedBlock === 'about' ? card.user.bio : card.user.bio.substring(0, 100) + (card.user.bio.length > 100 ? '...' : '')"></p>
                </div>
                <div
                    class="text-sm text-gray-600 border border-gray-300 rounded p-2 cursor-pointer"
                    @click="toggleExpandBlock('experience')"
                    :class="{ 'expanded': expandedBlock === 'experience', 'hidden': expandedBlock && expandedBlock !== 'experience' }"
                >
                    <p class="text-gray-600 text-sm font-medium">Experience:</p>
                    <p v-text="expandedBlock === 'experience' ? card.user.experience : card.user.experience.substring(0, 100) + (card.user.experience.length > 100 ? '...' : '')"></p>

                </div>
                <div class="w-full overflow-y-auto border border-gray-300 rounded flex-grow">
                    <div
                        class="rounded p-2 "
                        :class="{ 'hidden': expandedBlock && expandedBlock !== 'skills' }"
                    >
                        <p class="text-gray-600 text-sm font-medium">Skills:</p>
                        <ul
                            class="flex flex-wrap gap-1 text-sm border-indigo-500 dark:text-gray-700 rounded-md"
                        >
                            <li class="px-1 rounded border border-gray-300"
                                v-for="skill in card.user.seeking_skills" :key="skill.id">{{ skill.name }}
                            </li>
                        </ul>
                    </div>
                    <div
                        class=" rounded p-2 "
                        :class="{ 'hidden': expandedBlock && expandedBlock !== 'seeking-skills' }"
                    >
                        <p class="text-gray-600 text-sm font-medium">Seeking Skills:</p>
                        <ul
                            class="flex flex-wrap gap-1 text-sm border-indigo-500 dark:text-gray-700 rounded-md"
                        >
                            <li class="px-1 rounded border border-gray-300"
                                v-for="skill in card.user.skills" :key="skill.id">{{ skill.name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
