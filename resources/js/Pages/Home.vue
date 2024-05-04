<template>
    <div>
        <navigation-menu/>
        <!-- TITLE -->
        <div class="flex flex-wrap bg-lime-500 p-5 justify-around items-center">
            <div class="sm:w-full md:w-1/2 space-y-6">
                <p class="text-6xl lg:text-8xl font-extrabold text-black text-center p-3">
                    Des choses à partager?
                </p>
                <div class="text-center" v-if="!isAuthenticated">
                    <Link :href="route('register')"
                          class="text-xl bg-orange-500 text-white p-3 rounded-xl hover:bg-white hover:text-orange-500 font-bold">
                        INSCRIPTION
                    </Link>
                </div>
            </div>
            <div class="py-8 sm:w-full md:w-1/2">
                <img
                    src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="image" class="rounded-lg "/>
            </div>

        </div>
        <!-- 4 CARDS AT CENTER EXPLAINING PROS OF USING THE APP -->
        <div>
            <div class="flex flex-wrap justify-center items-center px-5 lg:px-8">
                <simple-card title="Partagez"
                             description="Partagez vos produits avec la communauté"
                             icon="Barley"
                             class="w-1/2 xl:w-1/4"/>
                <simple-card title="Partagez"
                             description="Partagez vos produits avec la communauté"
                             icon="Barley"
                             class="w-1/2 xl:w-1/4"/>
                <simple-card title="Partagez"
                             description="Partagez vos produits avec la communauté"
                             icon="Barley"
                             class="w-1/2 xl:w-1/4"/>
                <simple-card title="Partagez"
                             description="Partagez vos produits avec la communauté"
                             icon="Barley"
                             class="w-1/2 xl:w-1/4"/>
            </div>
        </div>

        <!-- MAP OF FRANCE SHOWING DIFFERENT LOCATIONS -->
        <div class="flex justify-center h-[600px]">
            <leaflet-map :markers="markers"></leaflet-map>
        </div>
        <!-- HISTORIC DESCRIPTION -->
        <div class="bg-orange-500 p-5">
            <div class="flex flex-wrap justify-around items-center">
                <div class="sm:w-full md:w-1/2">
                    <img
                        src="https://images.unsplash.com/photo-1597362925123-77861d3fbac7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="image" class="rounded-lg "/>
                </div>
                <div class="sm:w-full md:w-1/2">
                    <div class="text-xl lg:text-2xl font-extrabold text-black text-center p-3">
                        Regardez près de chez vous les différents crops et swaps pour varier votre alimentation sans
                        rien payer.
                    </div>
                    <div class="text-xl lg:text-2xl font-extrabold text-black text-center p-3">
                        Rencontrez des personnes qui partagent les mêmes valeurs que vous et qui souhaitent partager
                        leurs produits.
                    </div>
                </div>
            </div>
        </div>


        <!-- BLOG ARTICLES SAMPLES -->
        <div>
            <div class="text-6xl lg:text-8xl font-extrabold text-lime-500 text-center p-3">
                Articles du Blog
            </div>
            <div class="bg-gray-200 p-3 flex flex-nowrap overflow-x-auto gap-3">
                <article-card v-for="(article, articleIndex) in articles"
                              :key="articleIndex" @click="goToArticle(article.id)"
                              :content="article.content"
                              :image="article.image"
                              :title="article.title"
                              :date="article.created_at"
                              :tags="article.tags"
                              :user="article.user"
                              :id="article.id"
                              @go-to-article="goToArticle"
                              @go-to-tag="goToTag"
                >
                </article-card>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps, ref} from 'vue';
import NavigationMenu from '@/Layouts/NavigationMenu.vue';
import SimpleCard from "@/Components/Cards/SimpleCard.vue";
import ArticleCard from "@/Components/Cards/ArticleCard.vue";
import LeafletMap from "@/Components/Maps/LeafletMap.vue";
import {Link} from "@inertiajs/vue3";
import {useSessionInformations} from "@/Composables/session.js";
import {router} from "@inertiajs/vue3";

const {isAuthenticated, isAdmin} = useSessionInformations();

const props = defineProps({
    articles: Array,
    crops: Array,
});

const articles = props.articles;


const markers = ref(props.crops);

const goToArticle = (id) => {
    router.visit(route('blog.show', {blogArticle: id}));
}

const goToTag = (tag) => {
    router.visit(route('blog.tag', {tag: tag}));
}

</script>
<style scoped>

</style>
