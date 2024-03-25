<template>
    <div class="h-52 space-x-2 flex">
        <img
            :src="props.image"
            alt="image" class="w-1/2 object-cover"/>
        <div class="text-white w-1/2 p-2">
            <h2 class="text-3xl font-bold">{{ props.title }}</h2>
            <p class="text-md">{{
                    props.description
                }}</p>
        </div>
    </div>
</template>
<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    title: String,
    description: String,
    image: String,
});

</script>

<style scoped>

</style>
