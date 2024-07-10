<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import {Link, useForm, usePage} from "@inertiajs/vue3";
import {computed, nextTick, onMounted, ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ChatInput from "@/Components/ITinder/Chat/ChatInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";

const {props} = usePage();
const messages = ref(props.messages);
const user = ref(props.user);
const receiver = ref(props.receiver);

const message = ref<string>('');


const form = useForm({
    content: message.value,
    sender_id: user.value.id,
    receiver_id: receiver.value.id,
})

const sendMessage = () => {
    console.log(message)
    if (message.value.trim() === '') {
        return;
    }

    form.content = message.value;

    form.post(route('chat.store', {'user': receiver.value.id}), {
        errorBag: 'chat',
        preserveScroll: true,
        onSuccess: () => {
            messages.value.push({
                id: messages.value.length + 1,
                content: message.value,
                sender_id: user.value.id,
                created_at: new Date().toISOString(),
            });

            message.value = '';
        }
    });
};

const windowHeight = ref(window.innerHeight);

const computedHeight = computed(() => windowHeight.value - 65);

const messageContainer = ref(null);

onMounted(() => {
    window.addEventListener('resize', () => {
        windowHeight.value = window.innerHeight;
    });

    nextTick(() => {
        if (messageContainer.value) {
            messageContainer.value.scrollTop = messageContainer.value.scrollHeight;
        }
    });
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12" :style="`height: ${computedHeight}px`">
            <div class="h-full max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="h-full flex flex-col w-full mb-3 sm:mb-0 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div
                        class="flex items-center py-3 px-5 justify-between rounded-t top-0 left-0 right-0 dark:bg-gray-800 dark:text-gray-300 border-b-2 border-b-gray-600">
                        <Link class="pl-3" :href="route('chat.index')">Back</Link>
                        <div class="font-bold">{{ user.name }}</div>
                        <img :src="user.profile_picture" alt="Profile Picture" class="w-14 h-14 rounded object-cover">
                    </div>

                    <div class="px-5 pt-5 h-full overflow-y-auto" ref="messageContainer">
                        <div v-for="message in messages" :key="message.id" class="mb-4 text-gray-300">
                            <div
                                :class="{'bg-gray-200 dark:bg-gray-700 mr-5 rounded-bl': message.sender_id !== user.id, 'bg-blue-200 dark:bg-indigo-700 ml-auto rounded-br': message.sender_id === user.id}"
                                class="p-3 rounded-xl shadow-sm w-fit max-w-[75%]">
                                <p class="text-sm">{{ message.content }}</p>
                                <span class="text-xs text-gray-300">{{
                                        new Date(message.created_at).toLocaleString()
                                    }}</span>
                            </div>
                        </div>
                    </div>
                        <div
                            class="gap-2 bottom-0 left-0 right-0 p-3 bg-white dark:bg-gray-800 border-t-2 border-t-gray-600 flex">
                            <TextAreaInput class="max-h-[100px]" v-model="message" placeholder="Enter your message..."
                                           :rows="1"/>
                            <PrimaryButton class="h-fit mt-auto" @click="sendMessage">Send</PrimaryButton>
                        </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
