<template>
    <div>
        <template v-if="props.disposition === 'horizontal'">
            <div class="min-h-52 space-x-2 flex cursor-pointer items-center">
                <div v-if="props.hasImage" class="w-1/2 object-cover">
                    <div class="animate-image animate-pulse bg-gray-300 h-52 w-full"></div>
                </div>
                <div class="text-white w-1/2 p-2">
                    <div v-for="(row, index) in rows" :key="index" class="animate-row animate-pulse bg-gray-300 h-8"
                         :class="rowClasses[index]">
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="min-h-52 gap-2 flex flex-wrap cursor-pointer items-center">
                <div v-if="props.hasImage" class="p-2 w-full object-cover">
                    <div class="animate-image animate-pulse bg-gray-300 h-52 w-full"></div>
                </div>
                <div class="text-white w-full p-2">
                    <!-- rows depending on number of rows props -->
                    <div v-for="(row, index) in rows" :key="index" class="animate-row animate-pulse bg-gray-300 h-8"
                         :class="rowClasses[index]">
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script setup>
import {defineProps, computed} from 'vue';

const props = defineProps({
    hasImage: {
        type: Boolean,
        default: true
    },
    minRows: {
        type: Number,
        default: 2
    },
    maxRows: {
        type: Number,
        default: 4
    },
    disposition: {
        type: String,
        default: 'horizontal'
    }
})

const rows = Math.floor(Math.random() * (props.maxRows - props.minRows + 1)) + props.minRows;

const generateClass = () => {
    const randomWidth = Math.floor(Math.random() * 4) + 1;
    return {
        'mb-2': Math.random() >= 0.5,
        [`w-${randomWidth}/4`]: true
    };
}


const rowClasses = computed(() => Array.from({length: rows}, generateClass));

</script>

<style scoped>

.animate-pulse {
    animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}


</style>
