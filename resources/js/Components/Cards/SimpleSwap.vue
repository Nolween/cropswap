<template>
    <div
        class="w-20 min-h-24 md:w-32 md:min-h-40 xl:w-60 xl:min-h-60 p-1 md:p-4 justify-center border-b-gray-200 border-2 rounded-lg bg-white hover:bg-lime-50 cursor-pointer">
        <div class="text-xs md:text-md xl:text-xl font-bold text-center">{{ props.swap.name }}</div>
        <img :src="`/images/food/${props.swap.image}`"
             :alt="props.swap.name"
             class="w-16 min-h-16 md:w-28 md:min-h-28 xl:w-40 xl:min-h-40  md:p-4 mx-auto"/>
    </div>
</template>

<script setup>
import {defineProps} from 'vue';

const props = defineProps({
    swap: Object,
});

</script>

<style scoped>

</style>
