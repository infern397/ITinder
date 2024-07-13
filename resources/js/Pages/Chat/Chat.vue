<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import {computed, nextTick, onMounted, onUnmounted, ref, watch} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import {MessageInterface} from "@/types/MessageInterface";
import {UserInterface} from "@/types/UserInterface";
import {CheckIcon} from '@heroicons/vue/16/solid';
import axios from 'axios';

const strings = ref(usePage().props.strings);

const {messages: initialMessages, user, receiver} = defineProps({
    messages: {
        type: Array as PropType<MessageInterface[]>,
        required: true
    },
    user: {
        type: Object as PropType<UserInterface>,
        required: true
    },
    receiver: {
        type: Object as PropType<UserInterface>,
        required: true
    }
});

const message = ref<string>('');
const messages = ref([...initialMessages]);

const form = useForm({
    content: message.value,
    sender_id: user.id,
    receiver_id: receiver.id,
});

const sendMessage = () => {
    if (message.value.trim() === '') {
        return;
    }

    form.content = message.value;

    axios.post(route('chat.store', {'user': receiver.id}), form.data())
        .then(response => {
            const newMessage = response.data;
            messages.value.push(newMessage);

            message.value = '';

            nextTick(() => {
                if (messageContainer.value) {
                    messageContainer.value.scrollTop = messageContainer.value.scrollHeight;
                }
            });
        })
        .catch(error => {
            console.error("Error sending message:", error);
        });
};

const markAsRead = (message) => {
    if (!message.read_at && message.sender_id !== user.id) {
        axios.post(route('chat.markAsRead', {message: message.id}));
    }
};

const windowHeight = ref(window.innerHeight);
const computedHeight = computed(() => windowHeight.value - 65);
const messageContainer = ref(null);

onMounted(() => {
    window.addEventListener('resize', () => {
        windowHeight.value = window.innerHeight;
    });

    window.Echo.channel(`chat.${receiver.id}.${user.id}`)
        .listen('MessageSent', (data) => {
            markAsRead(data.message);
            if (!messages.value.find(m => m.id === data.message.id)) {
                messages.value.push(data.message);
                nextTick(() => {
                    if (messageContainer.value) {
                        messageContainer.value.scrollTop = messageContainer.value.scrollHeight;
                    }
                });
            }
        })
        .listen('MessageRead', (data) => {
            const message = messages.value.find(m => m.id === data.message.id);
            if (message) {
                message.read_at = data.message.read_at;
            }
        });

    nextTick(() => {
        if (messageContainer.value) {
            messageContainer.value.scrollTop = messageContainer.value.scrollHeight;
        }
    });
});

onUnmounted(() => {
    console.log(123)
    window.Echo.channel(`chat.${receiver.id}.${user.id}`).stopListening('MessageSent');
});


watch(messages, (newMessages) => {
    newMessages.forEach((message) => {
        markAsRead(message);
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
                        <Link class="pl-3" :href="route('chat.index')">{{strings['chat']['back']}}</Link>
                        <div class="font-bold">{{ receiver.name }}</div>
                        <img :src="receiver.profile_picture" alt="Profile Picture"
                             class="w-14 h-14 rounded object-cover">
                    </div>

                    <div class="px-5 pt-5 h-full overflow-y-auto" ref="messageContainer">
                        <div v-for="message in messages" :key="message.id" class="mb-4 text-gray-300">
                            <div
                                :class="{
                  'bg-gray-200 dark:bg-gray-700 mr-5 rounded-bl': message.sender_id !== user.id,
                  'bg-blue-200 dark:bg-indigo-700 ml-auto rounded-br': message.sender_id === user.id
                }"
                                class="p-3 rounded-xl shadow-sm w-fit max-w-[75%]">
                                <p class="text-sm">{{ message.content }}</p>
                                <div class="flex gap-2 items-center">
                  <span class="text-xs text-gray-300">{{
                          new Date(message.created_at).toLocaleString()
                      }}</span>
                                    <div v-if="message.sender_id === user.id && message.read_at">
                                        <CheckIcon class="w-4 h-4"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="gap-2 bottom-0 left-0 right-0 p-3 bg-white dark:bg-gray-800 border-t-2 border-t-gray-600 flex">
                        <TextAreaInput class="max-h-[100px]" v-model="message" :placeholder="strings['chat']['placeholder']"
                                       :rows="1"/>
                        <PrimaryButton class="h-fit mt-auto" @click="sendMessage">{{ strings['chat']['send'] }}</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
</style>
