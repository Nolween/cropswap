<template>
    <div>
        <navigation-menu/>
        <!-- TITLE -->
        <div class="flex flex-wrap bg-lime-500 p-5 justify-around items-center">
            <div class="sm:w-full md:w-1/2">
                <p class="text-6xl lg:text-8xl font-extrabold text-black text-center p-3">
                    Des choses à partager?
                </p>
            </div>
            <div class="py-8 sm:w-full md:w-1/2">
                <img
                    src="https://images.unsplash.com/photo-1647275621308-f715bee42fe7?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="image" class="rounded-lg "/>
            </div>
        </div>
        <!-- 4 CARDS AT CENTER EXPLAINING PROS OF USING THE APP -->
        <div>
            <div class="flex flex-wrap justify-center items-center p-5">
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

        <!-- MAP OF FRANCE SHOWING DIFFERETN LOCATIONS -->


        <!-- HISTORIC DESCRIPTION -->
        <div class="bg-orange-500 p-5 mb-4">
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

        <!-- BLOG CAROUSEL ARTICLES  -->
        <div class="flex w-full md:w-2/3 justify-center mx-auto mb-4">
            <blog-article :articles="articles"/>
        </div>


    </div>
</template>
<script setup>
import BlogArticle from "@/Components/Carousel/BlogArticle.vue";
import NavigationMenu from '@/Layouts/NavigationMenu.vue';
import SimpleCard from "@/Components/Cards/SimpleCard.vue";

const articles = [
    {
        title: "Article 1",
        content: "Content of article 1",
        image: "https://images.unsplash.com/photo-1560493676-04071c5f467b?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8YWdyaWN1bHR1cmV8ZW58MHx8MHx8fDI%3D"
    },
    {
        title: "Article 2",
        content: "Content of article 2",
        image: "https://images.unsplash.com/photo-1499529112087-3cb3b73cec95?q=80&w=3474&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        title: "Article 3",
        content: "Content of article 3",
        image: "https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
    {
        title: "Article 4",
        content: "Content of article 4",
        image: "https://images.unsplash.com/photo-1559884743-74a57598c6c7?q=80&w=3552&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    },
];


</script>
<style scoped>

</style>
