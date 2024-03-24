<template>
    <div class="rounded-md">
        <!-- TABS  -->
        <div class="w-full flex flex-nowrap justify-center bg-gray-300 space-x-2">
            <div v-for="(article, articleIndex) in props.articles" :key="articleIndex"
                 @click="changeArticle(articleIndex)"
                 class="p-2 cursor-pointer hover:bg-gray-400 rounded-tl-md rounded-tr-md"
                 :class="activeArticle === articleIndex ? 'bg-gray-500' : 'bg-gray-300'">
                {{ article.title }}
            </div>
        </div>
        <!-- IMAGE FULL WITH WITH ARTICLE DESCRIPTION IN ABSOLUTE -->
        <div class="w-full relative" v-for="(article, articleIndex) in props.articles" :key="articleIndex">
            <template v-if="articleIndex === activeArticle">
                <img :src="article.image" alt="image"
                     class="object-contain w-full">
                <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50">
                    <div class="text-white p-4">
                        <h2 class="text-2xl font-bold">{{ article.title }}</h2>
                        <p class="text-lg">{{ article.content }}</p>
                    </div>
                </div>
            </template>
        </div>
    </div>


</template>
<script setup>

import {defineProps, ref} from 'vue';

const props = defineProps({
    articles: Array,
});

const activeArticle = ref(0);
const timer = ref(0);

const changeArticle = (index) => {
    activeArticle.value = index;
    clearInterval(timer.value);
};

const autoChangeArticle = () => {
    timer.value = setInterval(() => {
        activeArticle.value = activeArticle.value === props.articles.length - 1 ? 0 : activeArticle.value + 1;
    }, 10000);
};

autoChangeArticle();

</script>

<style scoped>

</style>
