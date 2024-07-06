<script setup lang="ts">
import { reactive } from "vue";
import Card from "@/Components/ITinder/Cards/Card.vue";
import {CardInterface} from "@/types/CardInterface";

const cards: CardInterface[] = reactive([
    { id: 1, x: 0, y: 0 },
    { id: 2, x: 0, y: 0 },
    { id: 3, x: 0, y: 0 },
]);

const removeCard = (index: number) => {
    cards.splice(index, 1);
};
</script>

<template>
    <div class="deck relative w-[301px] h-[401px]">
        <Card
            v-for="(card, index) in cards"
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
