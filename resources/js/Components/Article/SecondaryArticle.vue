<template>
    <template v-if="!props.isLoading">
        <div class="min-h-52 space-x-2 flex cursor-pointer items-center"
             @click="goToArticle(props.id)">
            <img :src="props.image"
                 alt="image" class="w-1/2 object-cover"/>
            <div class="text-white w-1/2 p-2">
                <h2 class="text-3xl font-bold text-justify">{{ props.title }}</h2>
                <p class="text-md text-justify">{{
                        props.content
                    }}</p>
            </div>
        </div>
    </template>
    <template v-else>
        <div class="w-full">
            <skeleton></skeleton>
        </div>

    </template>
</template>
<script setup>
import {defineProps, defineEmits} from 'vue';
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
