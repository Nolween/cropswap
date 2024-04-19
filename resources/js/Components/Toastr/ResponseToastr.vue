<template>
    <div class="toastr cursor-pointer" @click="close">
        <!-- IF MEDIA SCREEN IS MD OR LESS, SMALL TOASTR AT TOP CENTER -->
        <div class="p-3 rounded-sm fixed inset-x-0 z-50 md:hidden" :class="`${props.horizontalPosition}-4`">
            <div class="rounded-md shadow-xl bg-white border-4 text-center py-2"
                 :class="`text-${props.color}-500 border-${props.color}-500`">
                <span>{{ props.message }}</span>
                <!-- A PROGRESS BAR FROM FULL TO 0 ACCORDING TO DURATION -->
                <div class="mt-2 h-2" :class="`bg-${props.color}-500`" :style="`width: ${percentBar}%`">
                </div>
            </div>

        </div>
        <!-- IF MEDIA SCREEN IS LG OR MORE, SMALL TOASTR AT TOP RIGHT -->
        <div class="p-3 rounded-sm fixed z-50 hidden md:block w-80" :class="`${props.horizontalPosition}-4 ${props.verticalPosition}-4 `">
            <div class="rounded-md shadow-xl bg-white border-4 text-center py-2"
                 :class="`text-${props.color}-500 border-${props.color}-500`">
                <span>{{ props.message }}</span>
                <!-- A PROGRESS BAR FROM FULL TO 0 ACCORDING TO DURATION -->
                <div class="mt-2 h-2" :class="`bg-${props.color}-500`" :style="`width: ${percentBar}%`">
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps, onMounted, ref, computed} from 'vue';

const props = defineProps({
    message: {type: String, default: 'OK'},
    color: {type: String, default: 'lime'},
    verticalPosition: {type: String, default: 'right'},
    horizontalPosition: {type: String, default: 'bottom'},
    duration: {type: Number, default: 3000},
});

const timer = ref(props.duration);

const close = () => {
    if (document.querySelector('.toastr')) {
        document.querySelector('.toastr').remove();
    }
};

// A function to reduce timer until 0
const reduceTimer = () => {
    setInterval(() => {
        if (timer.value <= 0) {
            close();
            return;
        }
        timer.value -= 50;
    }, 50);
};

const percentBar = computed(() => {
    return (timer.value / props.duration) * 100;
});

onMounted(() => {
    // launchTimer();
    reduceTimer();
});


</script>

<style scoped>

</style>
