<template>
    <div class="">
        <div class="w-full overflow-hidden h-[600px] relative">
            <img :src="props.articles[activeArticle].image" class="w-full h-full object-cover" alt="Description">

            <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50">
                <div class="text-white p-4">
                    <h2 class="text-2xl font-bold">{{ props.articles[activeArticle].title }}</h2>
                    <p class="text-lg">{{ props.articles[activeArticle].content }}</p>
                </div>
            </div>

            <!-- LEFT ARROW TO PREVIOUS ARTICLE -->
            <div class="absolute top-1/2 left-1 transform -translate-y-1/2">
                <button
                    @click="changeArticle(activeArticle === 0 ? props.articles.length - 1 : activeArticle - 1)"
                    class="bg-black text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
            </div>
            <!-- RIGHT ARROW TO NEXT ARTICLE -->
            <div class="absolute top-1/2 right-1 transform -translate-y-1/2">
                <button
                    @click="changeArticle(activeArticle === props.articles.length - 1 ? 0 : activeArticle + 1)"
                    class="bg-black text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
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
