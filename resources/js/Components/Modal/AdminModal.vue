<template>
    <div
        class="flex modal-container h-full w-full z-50 top-0 left-0 fixed items-center justify-center bg-gray-700 bg-opacity-70 backdrop-blur-sm">
        <div class="flex flex-wrap rounded-lg w-full md:w-1/2 z-50 border-4 border-orange-500 p-3 bg-white">
            <div class="flex justify-between w-full mb-4">
                <div class="text-black text-xl font-bold">
                    {{ title }}
                </div>
                <div class="cursor-pointer">
                    <close-icon class="close-icon" @click="close" size="26"></close-icon>
                </div>
            </div>
            <div class="w-full mb-4">
                <slot name="body"></slot>
            </div>
            <div class="w-full">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import {defineProps, defineEmits, onMounted} from 'vue';
import CloseIcon from 'vue-material-design-icons/Close.vue';

const props = defineProps({
    title: String
});

const emit = defineEmits(['close']);

const close = () => {
    emit('close');
}

// Add the close event on the escape key
const closeOnEscape = (e) => {
    if (e.key === 'Escape') {
        close();
    }
};
onMounted(() => document.addEventListener('keydown', closeOnEscape));

</script>
<style scoped>
</style>
