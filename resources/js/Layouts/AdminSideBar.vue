<template>
    <div
        class="w-full md:h-full md:w-1/3 flex flex-wrap md:block border-r-2 border-gray-100 md:space-y-4 pt-8 items-start justify-around">
        <Link :href="route('admin.crop.index')" class="p-3 flex flex-nowrap md:w-full hover:bg-blue-100 cursor-pointer">
            <div class="flex flex-nowrap items-center text-xl space-x-2">
                <!-- CROP ICON -->
                <land-plots-icon :size="40" class="text-orange-500"/>
                <span class="font-bold text-sm md:text-2xl text-gray-600">CROPS</span>
            </div>
        </Link>
        <Link :href="route('admin.swap.index')" class="p-3 flex flex-nowrap md:w-full hover:bg-blue-100 cursor-pointer">
            <div class="flex flex-nowrap items-center text-xl space-x-2">
                <!-- SWAPS ICON -->
                <barley-icon :size="40" class="text-orange-500"/>
                <span class="font-bold text-sm md:text-2xl text-gray-600">SWAPS</span>
            </div>
        </Link>
        <Link :href="route('admin.user.index')" class="p-3 flex flex-nowrap md:w-full hover:bg-blue-100 cursor-pointer">
            <div class="flex flex-nowrap items-center text-xl space-x-2">
                <!-- USERS ICON -->
                <account-icon :size="40" class="text-orange-500"/>
                <span class="font-bold text-sm md:text-2xl text-gray-600">UTILISATEURS</span>
            </div>
        </Link>
        <Link :href="route('admin.blog-article.index')"
              class="p-3 flex flex-nowrap md:w-full hover:bg-blue-100 cursor-pointer">
            <div class="flex flex-nowrap items-center text-xl space-x-2">
                <!-- USERS ICON -->
                <newspaper-icon :size="40" class="text-orange-500"/>
                <span class="font-bold text-sm md:text-2xl text-gray-600">ARTICLES BLOG</span>
            </div>
        </Link>
    </div>
</template>

<script setup>
import LandPlotsIcon from "vue-material-design-icons/LandPlots.vue";
import {Link} from "@inertiajs/vue3";
import BarleyIcon from "vue-material-design-icons/Barley.vue";
import AccountIcon from "vue-material-design-icons/Account.vue";
import NewspaperIcon from "vue-material-design-icons/Newspaper.vue";
</script>

<style scoped>

</style>
