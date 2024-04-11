<template>
    <div class="space-y-2 p-2 cursor-pointer" @click="goToArticle(props.id)">
        <img
            :src="props.image"
            alt="image" class="w-full object-cover max-h-40"/>
        <div class="text-black">
            <h2 class="text-3xl font-bold">{{ props.title }}</h2>
            <p class="text-xl">{{
                    props.content
                }}</p>
        </div>
    </div>
</template>
<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    title: String,
    content: String,
    image: String,
    id: Number,
});

const emit = defineEmits(['goToArticle']);

const goToArticle = (id) => {
    emit('goToArticle', id);
};

</script>
<style scoped>

</style>
