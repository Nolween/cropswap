<template>
    <div class="min-w-[320px] bg-white shadow-lg p-3 cursor-pointer article-card"
            @click="goToArticle"
    >
        <img :src="props.image" alt="image" class="w-full object-cover mb-4"/>
        <div class="flex flex-wrap gap-1 mb-4">
                        <span v-for="(tag, tagIndex) in props.tags" @click.stop="goToTag(tag)" :key="tagIndex"
                              class="card-tag border-2 border-transparent hover:border-blue-500 hover:text-blue-500 hover:bg-white py-0.5 px-1 rounded-md text-xs bg-blue-500 text-white font-bold">
                            {{ tag }}
                        </span>
        </div>
        <div class="text-black font-bold flex flex-wrap mb-3 text-lg ">{{ props.title }}</div>
        <div class="article-card-content font-light text-sm text-justify mb-3"> {{ truncateText(props.content, props.contentLength) }}</div>

        <div class="w-full flex flex-grow items-center">
            <img :src="props.user?.image" class="w-10 h-10 object-cover rounded-md mr-3" alt=""/>
            <div class="items-center">
                <span class="text-xs font-medium">{{ props.user?.name }}</span>
                <div class="flex flex-wrap">
                                <span class="text-xs font-medium">{{
                                        dayjs(props.created_at).format('DD/MM/YYYY')
                                    }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import dayjs from "dayjs";
import {defineProps, defineEmits} from "vue";
import {useTextTools} from "@/Composables/textTools.js";

const {truncateText} = useTextTools()

const props = defineProps({
    title: String,
    content: String,
    image: String,
    date: String,
    tags: Array,
    user: Object,
    id: Number,
    isLoading: {type: Boolean, default: false},
    contentLength: {type: Number, default: 150}
});

const emit = defineEmits(['goToArticle', 'goToTag']);

const goToTag = (tag) => {
    emit('goToTag', tag);
}

const goToArticle = () => {
    emit('goToArticle', props.id);
}

</script>

<style scoped>

.article-card:hover {
    transition: all 0.3s ease;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
}
</style>
