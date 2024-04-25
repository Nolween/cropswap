<template>
    <div
        class="bg-lime-500 text-black font-bold flex flex-wrap justify-around items-center gap-y-3 py-5 space-x-2 navigation-menu">
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
        <div v-else class="relative">
            <button
                class=" text-xl bg-white text-orange-500 p-3 rounded-lg hover:bg-orange-500 hover:text-white border-2"
                ref="accountButton"
                @click="displayAccountActions">
                MON COMPTE

            </button>
            <div v-if="openedAccountActions"
                 class="z-40 bg-orange-500 text-white text-xl font-bold absolute top-16 right-0 rounded-lg p-3 space-y-2 border-2">
                <div><Link :href="route('messages.index')" class="hover:text-lime-500">MESSAGERIE</Link></div>
                <div><Link :href="route('account.informations')" class="hover:text-lime-500">MES INFOS</Link></div>
                <div><Link :href="route('account.crop.show')" class="hover:text-lime-500">MON CROP</Link></div>
                <div @click="logout" class="hover:text-lime-500">DECONNECTER</div>
            </div>
        </div>

    </div>
</template>
<script setup>
import {onMounted, onUnmounted, ref} from 'vue';
import {Link} from '@inertiajs/vue3';
import {useSessionInformations} from "@/Composables/session.js";

const {isAuthenticated, isAdmin} = useSessionInformations();

const openedAccountActions = ref(false);

const displayAccountActions = () => {
    openedAccountActions.value = !openedAccountActions.value;
};


const logout = async () => {
    try {
        await axios.post('/logout');
        // After logout, redirect to the login page or home page
        window.location.href = '/';
    } catch (error) {
        console.error(error);
    }
};

const accountButton = ref(null);

const outsideClickListener = (event) => {
    if (accountButton.value && !accountButton.value.contains(event.target)) {
        openedAccountActions.value = false;
    }
};

onMounted(() => {
//     If openedAccountActions is true, close it when clicking outside the button
    document.addEventListener('click', outsideClickListener);
});

onUnmounted(() => {
    document.removeEventListener('click', outsideClickListener);
});


</script>
<style scoped>

</style>
