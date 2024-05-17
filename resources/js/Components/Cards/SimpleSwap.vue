<template>
    <div
        class="relative w-20 min-h-24 md:w-32 md:min-h-40 xl:w-60 xl:min-h-60 p-1 md:p-4 justify-center border-b-gray-200 border-2 rounded-lg bg-white hover:bg-lime-50 cursor-pointer"
        @click="openContext($event)" ref="swapCard">
        <div class="text-xs md:text-md xl:text-xl font-bold text-center">{{ props.swap.name }}</div>
        <img :src="`/images/food/${props.swap.image}`"
             :alt="props.swap.name"
             class="w-16 min-h-16 md:w-28 md:min-h-28 xl:w-40 xl:min-h-40  md:p-4 mx-auto"/>
        <!-- OPTIONNAL CONTEXT MENU -->
        <div v-if="openedContext" class="z-40 w-40 lg:w-80 absolute border-2 border-gray-300 bg-white rounded-md lg:p-2 text-gray-800"
             :style="{ top: `${contextMenuY}px`, left: `${contextMenuX}px` }">
            <div v-for="(action, actionIndex) in props.actions" :key="actionIndex">
                <button @click="emitAction(actionIndex)"
                        class="lg:p-2 align-middle w-full rounded-md text-gray-800 hover:bg-gray-200 hover:text-gray-900 text-sm">
                    {{ action }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {defineProps, onMounted, onUnmounted, ref, defineEmits} from 'vue';

const props = defineProps({
    swap: Object,
    actions: Object
});

const emit = defineEmits(['action']);

const openedContext = ref(false);
const swapCard = ref(null);
const contextMenuX = ref(0);
const contextMenuY = ref(0);

const openContext = (event) => {
    if (props.actions && swapCard?.value) {
        const rect = swapCard.value.getBoundingClientRect();
        contextMenuX.value = event.pageX - rect.left;
        contextMenuY.value = event.pageY - rect.top;
        openedContext.value = true;
    }
}

const emitAction = (actionIndex) => {
    emit('action', actionIndex);
    openedContext.value = false;
}


onMounted(() => {
    document.addEventListener('click', outsideClickListener);
});

onUnmounted(() => {
    document.removeEventListener('click', outsideClickListener);
});

const outsideClickListener = (event) => {
    if (!swapCard.value.contains(event.target)) {
        openedContext.value = false;
    }
};

</script>

<style scoped>

</style>
