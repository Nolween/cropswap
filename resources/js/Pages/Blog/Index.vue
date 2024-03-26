<template>
    <div>
        <navigation-menu></navigation-menu>
        <div class="bg-orange-500 w-full">
            <h1 class="text-9xl text-center text-white font-extrabold font-title py-8">LE BLOG</h1>
        </div>
        <div class="flex flex-wrap w-full bg-orange-500">
            <!-- LAST ARTICLE -->
            <div class="w-full lg:w-1/2 p-3 lg:p-6 space-y-4 cursor-pointer"
                 @click="goToArticle(articles[0].id)">
                <img
                    src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="image" class="w-full"/>
                <div class="text-white">
                    <h2 class="text-3xl font-bold">{{ articles[0].title }}</h2>
                    <p class="text-xl">{{
                            articles[0].description
                        }}</p>
                </div>
            </div>
            <!-- 3 OTHER ARTICLES -->
            <div class="w-full lg:w-1/2 flex flex-wrap p-3 lg:p-6 space-y-2">
                <template v-for="(secondaryArticle, secondaryArticleIndex) in computedSecondaryArticles"
                          :key="secondaryArticleIndex">
                    <secondary-article :title="secondaryArticle.title"
                                       :description="secondaryArticle.description"
                                       :image="secondaryArticle.image"
                                       :id="secondaryArticle.id"
                                       @go-to-article="goToArticle(secondaryArticle.id)"
                    />
                </template>
            </div>
        </div>

        <!-- OTHER ARTICLES AND SEARCH -->
        <div class=" w-full flex flex-wrap p-6
                    ">
            <div class="w-1/2 text-2xl pl-2">Autres Articles</div>
            <div class="w-1/2">
                <input type="text"
                       v-model="search"
                       placeholder="Rechercher un article"
                       class="w-full p-2"/>
            </div>
        </div>

        <!-- OTHER ARTICLES IN GRID -->
        <div class="w-full p-3 lg:p-6 space-y-4 mb-40">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <template v-for="(article, articleIndex) in computedArticles" :key="articleIndex">
                    <article-card :title="article.title"
                                  :description="article.description"
                                  :image="article.image"
                                  :id="article.id"
                                  @go-to-article="goToArticle"
                    />
                </template>
            </div>
        </div>

    </div>
</template>
<script setup>
import {computed, ref} from 'vue';
import {router} from '@inertiajs/vue3';
import NavigationMenu from '@/Layouts/NavigationMenu.vue';
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import SecondaryArticle from "@/Components/Article/SecondaryArticle.vue";

const articles = ref([
    {
        id: 1,
        title: "Article 1",
        description: "Content of article 1",
        image: "https://images.unsplash.com/photo-1711343959718-737b664fd4b0?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        id: 2,
        title: "Article 2",
        description: "Content of article 2",
        image: "https://images.unsplash.com/photo-1707343848723-bd87dea7b118?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        id: 3,
        title: "Article 3",
        description: "Content of article 3",
        image: "https://images.unsplash.com/photo-1710692063056-07d0e4c28b4b?q=80&w=3464&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        id: 4,
        title: "Article 4",
        description: "Content of article 4",
        image: "https://images.unsplash.com/photo-1682686578601-e7851641d52c?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        id: 5,
        title: "Article 5",
        description: "Content of article 5",
        image: "https://images.unsplash.com/photo-1711319551829-3fadadf67cd9?q=80&w=2629&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        id: 6,
        title: "Article 6",
        description: "Content of article 6",
        image: "https://images.unsplash.com/photo-1682687982298-c7514a167088?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        id: 7,
        title: "Article 7",
        description: "Content of article 7",
        image: "https://images.unsplash.com/photo-1711313525588-c4b9f3ef4847?q=80&w=3542&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        id: 8,
        title: "Article 8",
        description: "Content of article 8",
        image: "https://images.unsplash.com/photo-1707343846292-0c11438d145f?q=80&w=3687&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        id: 9,
        title: "Article 9",
        description: "Content of article 9",
        image: "https://images.unsplash.com/photo-1711207469465-e17f3c20c5d7?q=80&w=3474&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    }
]);

const search = ref('');


const computedSecondaryArticles = computed(() => {
    // Only keep 2nd to 4th articles
    return articles.value.slice(1, 4);
});


const computedArticles = computed(() => {
    // Remove 4 first articles
    const otherArticles = articles.value.slice(4);

    if (!search.value) {
        return otherArticles;
    }
    // Filter articles by search acording to title or description
    return otherArticles.filter(article => {
        return article.title.toLowerCase().includes(search.value.toLowerCase()) || article.description.toLowerCase().includes(search.value.toLowerCase());
    });
});

const goToArticle = (id) => {
    router.visit(`/blog/${id}`);
};

</script>
<style scoped>

</style>
