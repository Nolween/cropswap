<template>
    <template v-if="!props.isLoading">
        <div class="space-y-2 p-2 cursor-pointer" @click="goToArticle(props.id)">
            <img
                :src="props.image"
                alt="image" class="w-full object-cover max-h-40"/>
            <div class="text-black">
                <h2 class="text-3xl font-bold text-justify">{{ props.title }}</h2>
                <p class="text-xl text-justify">{{
                        props.content
                    }}</p>
            </div>
        </div>
    </template>
    <template v-else>
        <div class="w-full">
            <skeleton disposition="vertical" :max-rows="8"></skeleton>
        </div>
    </template>
</template>
<script setup>
import {defineProps} from 'vue';
import Skeleton from "@/Components/Loader/Skeleton.vue";

const props = defineProps({
    title: String,
    content: String,
    image: String,
    id: Number,
    isLoading: Boolean
});

const emit = defineEmits(['goToArticle']);

const goToArticle = (id) => {
    emit('goToArticle', id);
};

</script>
<style scoped>

</style>
