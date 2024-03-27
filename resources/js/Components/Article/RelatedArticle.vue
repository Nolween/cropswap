<template>
    <div class="flex flex-wrap justify-between items-center w-1/2 xl:w-full cursor-pointer"
    @click="goToArticle(props.id)">
        <div class="w-1/2">
            <img class="w-full h-32 object-cover rounded-md"
                 :src="props.image"
                 alt="image">
        </div>
        <div class="w-1/2 p-2">
            <div class="text-md font-bold mb-2">{{ props.title}}</div>
            <div class="text-xs flex flex-nowrap space-x-2">
                <img class="w-6 h-6 rounded-3xl" src="https://plus.unsplash.com/premium_photo-1711051475117-f3a4d3ff6778?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                     alt="facebook"/>
                <div>
                    <div class="font-bold">{{ props.author }}</div>
                    <div class="font-medium">{{ props.date }}</div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>

import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    title: String,
    author: String,
    date: String,
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
