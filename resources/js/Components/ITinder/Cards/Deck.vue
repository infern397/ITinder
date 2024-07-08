<script setup lang="ts">
import {PropType, reactive} from "vue";
import Card from "@/Components/ITinder/Cards/Card.vue";
import {CardInterface} from "@/types/CardInterface";
import { UserInterface } from "@/types/UserInterface";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    users: Array as PropType<UserInterface[]>,
});

const cards: CardInterface[] = reactive(props.users.map((user, index) => ({
    id: user.id,
    user: user,
    x: 0,
    y: 0,
})));

const removeCard = async (index: number) => {
    console.log(index)
    const card = cards[index];
    if (card.swipeDirection === 'right') {
        await saveMatch(card.user.id);
    }
    cards.splice(index, 1);
};

const saveMatch = async (matchedUserId: number) => {
    try {
        useForm({ matched_user_id: matchedUserId }).post(route('matches.store'));
    } catch (error) {
        console.error("Error saving match", error);
    }
};
</script>

<template>
    <div class="deck relative aspect-[4/3] max-w-[80%] h-full">
        <Card
            v-for="(card, index) in cards.slice(0, 2)"
            :key="card.id"
            :card="card"
            :index="index"
            :cards="cards"
            @remove="removeCard"
        />
    </div>
</template>

<style scoped>

</style>
