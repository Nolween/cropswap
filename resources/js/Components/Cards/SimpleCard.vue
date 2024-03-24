<template>
    <div class="p-5">
        <div class="bg-white p-5 rounded-lg shadow-lg">
            <div class="flex justify-center">
                <component :is="iconComponent"
                           :title="props.icon"
                           :class="computedColorIcon"
                           :size="60"
                />
            </div>
            <div class="text-center p-5">
                <h2 class="text-2xl font-bold">{{ props.title }}</h2>
                <p class="text-lg">{{ props.description }}</p>
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref, onMounted, defineAsyncComponent} from 'vue';

// Props
const props = defineProps({
    title: String,
    description: String,
    icon: String,
    iconColor: {
        type: String,
        default: 'black'
    },
});

// Dynamic import according to the icon props
const iconComponent = ref(null);
const loadIcon = async () => {
    iconComponent.value = defineAsyncComponent(() => import(`../../../../node_modules/vue-material-design-icons/${props.icon}.vue`));
};

const computedColorIcon = ref(`text-${props.iconColor}-500`);

// Load the icon onMount
onMounted(() => {
    loadIcon();
});

</script>
<style scoped>

</style>
