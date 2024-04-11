<template>
    <div class="h-52 space-x-2 flex cursor-pointer"
    @click="goToArticle(props.id)">
        <img
            :src="props.image"
            alt="image" class="w-1/2 object-cover"/>
        <div class="text-white w-1/2 p-2">
            <h2 class="text-3xl font-bold">{{ props.title }}</h2>
            <p class="text-md">{{
                    props.content
                }}</p>
        </div>
    </div>
</template>
<script setup>
import { defineProps, defineEmits } from 'vue';

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
