<template>
    <div class="md:h-screen md:overflow-hidden">
        <navigation-menu/>
        <div class="h-full flex flex-wrap">
            <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                DASHBOARD
            </div>
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
                <div class="pt-4 text-2xl md:text-5xl font-bold text-center text-orange-500">
                    STATISTIQUES
                </div>
                <div class="flex flex-wrap justify-center w-full">
                    <simple-card title="64" description="Crops inscrits" icon="LandPlots"/>
                    <simple-card title="128" description="Swap effectués" icon="Barley"/>
                    <simple-card title="31" description="Crops inscrits" icon="Account"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import SimpleCard from "@/Components/Cards/SimpleCard.vue";
//  Verify if the user is authenticated from session
const authenticated = ref(false);

</script>

<style scoped>

</style>
