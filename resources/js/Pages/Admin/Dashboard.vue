<template>
    <div>
        <navigation-menu/>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";


//  Verify if the user is authenticated from session
const authenticated = ref(false);

</script>

<style scoped>

</style>
