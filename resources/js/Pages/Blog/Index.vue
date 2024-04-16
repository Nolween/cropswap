<template>
    <div>
        <navigation-menu></navigation-menu>
        <div class="bg-orange-500 w-full">
            <h1 class="text-9xl text-center text-white font-extrabold font-title py-8">LE BLOG</h1>
        </div>
        <div class="flex flex-wrap w-full bg-orange-500">
            <div class="w-full">
            </div>
            <!-- LAST ARTICLE -->
            <div
                class="my-auto w-full lg:w-1/2 p-3 lg:p-6 space-y-4 cursor-pointer"
                @click="goToArticle(articles[0].id)">
                <template v-if="props.articlesCount > 0 && !isLoading">
                    <img
                        :src="articles[0].image"
                        alt="image" class="w-full"/>
                    <div class="text-white">
                        <h2 class="text-3xl font-bold">{{ articles[0].title }}</h2>
                        <p class="text-xl">{{
                                truncateText(articles[0].content, 500)
                            }}</p>
                    </div>
                </template>
                <template v-else-if="isLoading">
                    <skeleton disposition="vertical" :max-rows="8"></skeleton>
                </template>
            </div>
            <!-- 3 OTHER ARTICLES -->
            <div class="w-full lg:w-1/2 flex flex-wrap p-3 lg:p-6 space-y-2" v-if="articles.length > 1">
                <template v-for="(secondaryArticle, secondaryArticleIndex) in computedSecondaryArticles"
                          :key="secondaryArticleIndex">
                    <secondary-article :title="secondaryArticle.title"
                                       :content="truncateText(secondaryArticle.content, 200)"
                                       :image="secondaryArticle.image"
                                       :id="secondaryArticle.id"
                                       :is-loading="isLoading"
                                       @go-to-article="goToArticle(secondaryArticle.id)"
                    />
                </template>
            </div>
        </div>

        <!-- OTHER ARTICLES AND SEARCH -->
        <div class=" w-full flex flex-wrap p-6">
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
                                  :content="truncateText(article.content, 300)"
                                  :image="article.image"
                                  :id="article.id"
                                  @go-to-article="goToArticle"
                                  :is-loading="isLoading"
                    />
                </template>
            </div>
        </div>

    </div>
</template>
<script setup>
import {computed, onBeforeMount, ref, defineProps} from 'vue';
import {router} from '@inertiajs/vue3';
import NavigationMenu from '@/Layouts/NavigationMenu.vue';
import ArticleCard from "@/Components/Article/ArticleCard.vue";
import SecondaryArticle from "@/Components/Article/SecondaryArticle.vue";
import Skeleton from "@/Components/Loader/Skeleton.vue";
// Import de composables
import {useTextTools} from "@/Composables/textTools";
import {useLoading} from "@/Composables/loading";

// Déclaration des éléments composables
const {truncateText} = useTextTools();
const {isLoading, setLoading} = useLoading();

const props = defineProps({
    articlesCount: Number,
});


const articles = ref([]);

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
    // Filter articles by search acording to title or content
    return otherArticles.filter(article => {
        return article.title.toLowerCase().includes(search.value.toLowerCase()) || article.content.toLowerCase().includes(search.value.toLowerCase());
    });
});

const goToArticle = (id) => {
    router.visit(`/blog/${id}`);
};


// Fetch blog article data to /blog route
const fetchBlogArticles = async () => {
    setLoading(true);
    try {
        const response = await fetch('/blog/index');
        articles.value = await response.json();
        setLoading(false);
    } catch (error) {
        console.error(error);
    }
};

onBeforeMount(() => {
    fetchBlogArticles();
});

</script>
<style scoped>

</style>
