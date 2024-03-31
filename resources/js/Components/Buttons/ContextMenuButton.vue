<template>
    <div ref="divMenu" class="relative">
        <button
            @click="isOpenedMenu = !isOpenedMenu"
            class="p-2 rounded-lg text-blue-500 text-md font-medium border-2 border-blue-500 hover:text-white hover:bg-blue-500 hover:border-transparent">
            <filter-outline-icon size="24"/>
        </button>

        <!-- Slot -->
        <div v-if="isOpenedMenu"
             class="absolute rounded-lg top-12 left-0 p-3 border-2 border-gray-500 bg-gray-100">
            <slot name="content">
            </slot>

        </div>
    </div>
</template>

<script setup>

import {defineProps, ref, onMounted, onUnmounted} from 'vue';
import FilterOutlineIcon from "vue-material-design-icons/FilterOutline.vue";

const props = defineProps({
    description: String,
    icon: String,
    color: {
        type: String,
        default: 'black'
    },
    iconColor: {
        type: String,
        default: 'black'
    },
});


let divMenu = ref(null);
const isOpenedMenu = ref(false);

onMounted(() => {
    document.addEventListener('click', outsideClickListener);
});

onUnmounted(() => {
    document.removeEventListener('click', outsideClickListener);
});

const outsideClickListener = (event) => {
    if (!divMenu.value.contains(event.target)) {
        isOpenedMenu.value = false;
    }
};

</script>

<style scoped>

</style>
