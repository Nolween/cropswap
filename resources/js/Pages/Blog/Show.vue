<template>
    <div>
        <navigation-menu></navigation-menu>
        <div class="flex flex-nowrap justify-around items-center">
            <div class="w-full md:w-1/2 p-6 font-title text-gray-700 space-y-4">
                <h2 class="text-4xl font-extrabold ">{{ props.title }}</h2>
                <!-- SEPARATOR -->
                <div class="w-1/4 h-0.5 bg-gray-200"></div>
                <div class="flex justify-between">
                    <div>
                        <div class="font-bold">{{ props.author }}</div>
                        <div class="font-medium">Le {{ dayjs(props.created_at).format('DD/MM/YYYY') }}</div>
                    </div>
                    <div class="space-x-2">
                        <div class="text-sm font-medium">Partager l'article</div>
                        <div class="flex flex-wrap justify-around">
                            <img class="w-6 h-6" src="https://img.icons8.com/ios/50/000000/facebook-new.png"
                                 alt="facebook"/>
                            <img class="w-6 h-6" src="https://img.icons8.com/ios/50/000000/twitter.png" alt="twitter"/>
                            <img class="w-6 h-6" src="https://img.icons8.com/ios/50/000000/linkedin.png"
                                 alt="linkedin"/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="w-full md:w-1/2 relative">
                <div class="absolute inset-0 bg-gradient-to-r from-white to-transparent"></div>
                <img class="w-full h-full object-cover"
                     :src="props.image"
                     alt="image">
            </div>
        </div>
        <!-- SEPARATOR -->
        <div class="w-full h-0.5 bg-gray-200"></div>

        <!-- ARTICLE RESUME -->
        <div class="flex flex-wrap">
            <div class="p-6 w-full xl:w-3/4 space-y-4 text-justify">
                <div v-html="props.content"></div>
            </div>
            <!--RELATED POST COLUMN -->
            <div class="w-full xl:w-1/4 p-5 bg-orange-500">
                <div class="font-bold text-2xl mb-3">Articles similaire</div>
                <!--  RELATED POST  -->
                <div class="space-y-4 flex flex-wrap">
                    <related-article v-for="(relatedArticle, relatedArticleIndex) in props.related_articles"
                                     :key="relatedArticleIndex"
                                     :title="relatedArticle.title"
                                     :author="relatedArticle.author"
                                     :date="relatedArticle.date"
                                     :image="relatedArticle.image"
                                     :id="relatedArticle.id"
                                     @goToArticle="goToArticle(relatedArticle.id)"
                    />
                </div>

            </div>
        </div>

    </div>
</template>
<script setup>
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import RelatedArticle from "@/Components/Article/RelatedArticle.vue";
import {router} from '@inertiajs/vue3';
import {defineProps} from 'vue';
import dayjs from "dayjs";

const props = defineProps({
    title: String,
    content: String,
    image: String,
    id: Number,
    author: String,
    created_at: String,
    updated_at: String,
    tags: Array,
    related_articles: Array
});

const goToArticle = (id) => {
    router.visit(`/blog/${id}`);
};

</script>

<style scoped>


</style>
