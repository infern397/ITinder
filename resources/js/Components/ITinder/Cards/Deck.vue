<script setup lang="ts">
import {PropType, reactive} from "vue";
import Card from "@/Components/ITinder/Cards/Card.vue";
import {CardInterface} from "@/types/CardInterface";
import { UserInterface } from "@/types/UserInterface"; // добавляем интерфейс пользователя

const props = defineProps({
    users: Array as PropType<UserInterface[]>, // ожидаем список пользователей в пропсах
});

const cards: CardInterface[] = reactive(props.users.map((user, index) => ({
    id: user.id,
    user: user,
    x: 0,
    y: 0,
})));

const removeCard = (index: number) => {
    cards.splice(index, 1);
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
