<template>
    <div class="md:h-screen md:overflow-hidden">
        <navigation-menu/>
        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    DASHBOARD
                </div>
                <div class="pt-4 text-2xl md:text-5xl font-bold text-center text-orange-500">
                    STATISTIQUES
                </div>
                <div class="flex flex-wrap justify-around w-full">
                    <simple-card :title="props.cropsCount" description="Crops inscrits" icon="LandPlots"/>
                    <simple-card :title="props.swapsCount" description="Swap référencés" icon="Barley"/>
                    <simple-card :title="props.messagesCount" description="Messages envoyés" icon="MessageOutline"/>
                    <simple-card :title="props.articlesCount" description="Articles publiés" icon="PostOutline"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, defineProps} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import SimpleCard from "@/Components/Cards/SimpleCard.vue";
//  Verify if the user is authenticated from session
const authenticated = ref(false);

const props = defineProps({
    cropsCount: {type: Number, required: true},
    swapsCount: {type: Number, required: true},
    messagesCount: {type: Number, required: true},
    articlesCount: {type: Number, required: true},
});


</script>

<style scoped>

</style>
