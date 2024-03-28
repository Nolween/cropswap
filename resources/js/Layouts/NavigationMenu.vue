<template>
    <div
        class="bg-lime-500 min-h-16 text-black font-bold flex flex-wrap justify-around items-center gap-y-3 py-5 space-x-2">
        <Link class="text-4xl cursor-pointer" :href="route('home')">
            CROPSWAP
        </Link>
        <div class="space-x-4">
        <span class="text-xl hover:text-white cursor-pointer">
            ADMIN
        </span>
            <Link :href="route('blog')" class="text-xl hover:text-white cursor-pointer">
                LE BLOG
            </Link>

            <Link :href="route('crop.index')" class="text-xl hover:text-white cursor-pointer">
                TROUVER UN CROP
            </Link>
        </div>
        <Link :href="route('login')" class="text-xl bg-black text-white p-3 rounded-xl hover:bg-white hover:text-black">
            CONNEXION
        </Link>
    </div>
</template>
<script setup>
import {Link} from '@inertiajs/vue3';

</script>
<style scoped>

</style>
