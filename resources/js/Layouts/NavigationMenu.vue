<template>
    <div
        class="bg-lime-500 min-h-16 text-black font-bold flex flex-wrap justify-around items-center gap-y-3 py-5 space-x-2">
        <Link class="text-4xl cursor-pointer" :href="route('home')">
            CROPSWAP
        </Link>
        <div class="space-x-4">
            <Link v-if="isAdmin" :href="route('admin.dashboard')" class="text-xl hover:text-white cursor-pointer">
                ADMIN
            </Link>
            <Link :href="route('blog')" class="text-xl hover:text-white cursor-pointer">
                LE BLOG
            </Link>

            <Link :href="route('crop.index')" class="text-xl hover:text-white cursor-pointer">
                TROUVER UN CROP
            </Link>
        </div>
        <Link v-if="!isAuthenticated" :href="route('login')"
              class="text-xl bg-black text-white p-3 rounded-xl hover:bg-white hover:text-black">
            CONNEXION
        </Link>
        <form v-else @submit.prevent="logout"
              class="cursor-pointer text-xl bg-black text-white p-3 rounded-xl hover:bg-white hover:text-black">
            <button type="submit">DECONNEXION</button>
        </form>

    </div>
</template>
<script setup>
import {Link} from '@inertiajs/vue3';
import {useSessionInformations} from "@/Composables/session.js";

const {isAuthenticated, isAdmin} = useSessionInformations();


const logout = async () => {
    try {
        await axios.post('/logout');
        // After logout, redirect to the login page or home page
        window.location.href = '/login';
    } catch (error) {
        console.error(error);
    }
};


</script>
<style scoped>

</style>
