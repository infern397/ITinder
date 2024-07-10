<script setup lang="ts">
import { onMounted, PropType, reactive, watch } from "vue";
import Card from "@/Components/ITinder/Cards/Card.vue";
import { CardInterface } from "@/types/CardInterface";
import { UserInterface } from "@/types/UserInterface";
import { router, useForm } from "@inertiajs/vue3";

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

const cards = reactive<CardInterface[]>(props.users.map((user) => ({
    id: user.id,
    user: user,
    x: 0,
    y: 0
})));

const addNewUsersToDeck = (newUsers: UserInterface[]) => {
    if (Array.isArray(newUsers)) {
        newUsers.forEach(user => {
            cards.push({
                id: user.id,
                user: user,
                x: 0,
                y: 0
            });
        });
    }
};

watch(() => props.users, (newUsers) => {
    console.log(newUsers)
    addNewUsersToDeck(newUsers);
});

const fetchMoreUsers = async () => {
    try {
        await router.get(route('matches.more'), {}, {
            preserveState: true,
            onSuccess: (page) => {
                addNewUsersToDeck(page.props.newUsers);
            }
        });
    } catch (error) {
        console.error("Error fetching more users", error);
    }
};

const removeCard = async (index: number) => {
    const card = cards[index];
    if (card.swipeDirection === 'right') {
        await saveMatch(card.user.id);
    }
    cards.splice(index, 1);
    if (cards.length === 1) {
        await fetchMoreUsers();
    }
};

const saveMatch = async (matchedUserId: number) => {
    try {
        useForm({ matched_user_id: matchedUserId }).post(route('matches.store'));
    } catch (error) {
        console.error("Error saving match", error);
    }
};

onMounted(() => {
    console.log(props.users);
});
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
