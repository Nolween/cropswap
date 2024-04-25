<template>

    <div class="relative h-screen flex flex-col">
        <navigation-menu/>

        <div class="flex flex-grow">
            <!-- Left Sidebar displaying all conversations -->
            <div class="w-16 md:w-1/4 bg-orange-500 overflow-auto overflow-x-hidden left-part">
                <div class="text-white text-2xl p-2 hidden md:block text-center">CONVERSATIONS</div>
                <div class="text-white text-2xl p-3 block md:hidden">
                    <ChatOutlineIcon class="text-white" :size="40"/>
                </div>
                <div class="space-y-2">
                    <div v-for="conversation in conversations" :key="conversation.id"
                         @click="selectConversation(conversation)"
                         :class="{'bg-orange-400': conversation.conversation_id === selectedConversation.conversation_id}"
                         class="p-3 hover:bg-orange-400 cursor-pointer text-white text-xl font-bold">
                        <div class="flex items-center gap-2 justify-center md:justify-start">
                            <img :src="conversation.user_image" class="object-cover w-8 h-8 rounded-full"
                                 alt="User image"/>
                            <div class="hidden md:block">
                                {{ conversation.user }}
                                <div class="font-medium overflow-hidden whitespace-nowrap overflow-ellipsis">
                                    {{ truncateText(conversation.messages[0].content, 15) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Part with messages in chat design of the selected conversation -->
            <div class="relative w-full md:w-3/4 bg-gray-50 overflow-auto">
                <div class="absolute top-O w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    {{ selectedConversation.user }}
                </div>

                <div class="absolute top-20 p-4 gap-2 w-full">
                    <div v-for="(message, messageIndex) in selectedConversation.messages"
                         :key="messageIndex"
                         class="w-full flex"
                         :class="props.authId === message.sender_id ? 'justify-end' : 'justify-start'">
                        <div class="w-3/4 rounded-2xl p-2 mb-4 border-2 border-orange-500"
                             :class="props.authId === message.sender_id ? 'bg-orange-500 text-white' : 'bg-white text-orange-500'">

                            <div class="font-bold text-xl mb-2">{{ message.content }}</div>
                            <div class="text-end ">{{ dayjs(message.created_at).format('DD/MM/YYYY à HH:mm') }}</div>
                        </div>
                    </div>
                </div>
                <!-- WRITING PART AT BOTTOM -->
                <div class="absolute bottom-0 w-full bg-orange-500 p-2 flex gap-2">
                    <input type="text" class="w-3/4 p-2 rounded-2xl border-transparent"
                           placeholder="Votre message ici"/>
                    <button class="w-1/4 bg-lime-500 text-white p-2 rounded-2xl">ENVOYER</button>
                </div>

            </div>

        </div>
    </div>

</template>

<script setup>

import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import {defineProps, ref, onMounted} from 'vue';
import ChatOutlineIcon from "vue-material-design-icons/ChatOutline.vue";
import {useTextTools} from "@/Composables/textTools.js";
import dayjs from "dayjs";

const {truncateText} = useTextTools();

const props = defineProps({
    conversations: Array,
    authId: Number
});

const isCollapsed = ref(false);
const conversation = ref(props.conversations);
// Select the first conversation by default
const selectedConversation = ref(props.conversations[Object.keys(props.conversations)[0]]);

const collapse = () => {
    isCollapsed.value = !isCollapsed.value;
};

const selectConversation = (conversation) => {
    selectedConversation.value = conversation;
};


onMounted(() => {
    const navigationMenu = document.querySelector('.navigation-menu');
    const leftPart = document.querySelector('.left-part');

    const resizeLeftPart = () => {
        const navigationMenuHeight = navigationMenu.offsetHeight;
        leftPart.style.height = `calc(100vh - ${navigationMenuHeight}px)`;
    };

    window.addEventListener('resize', resizeLeftPart);
    resizeLeftPart();
});


</script>

<style scoped>

</style>
