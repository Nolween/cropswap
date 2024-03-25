<template>
    <div class="space-y-2 p-2">
        <img
            :src="props.image"
            alt="image" class="w-full object-cover max-h-40"/>
        <div class="text-black">
            <h2 class="text-3xl font-bold">{{ props.title }}</h2>
            <p class="text-xl">{{
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
