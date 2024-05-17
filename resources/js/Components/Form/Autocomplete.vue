<template>
    <div class="relative z-30" ref="autocomplete">
        <input type="text" class="w-full p-2 border-2 border-gray-200 rounded-lg" :placeholder="props.placeholder"
               v-model="search" @input="searchValues" @click="isOpenedList = true">
        <div class="absolute right-3 top-3 cursor-pointer" @click="clearSearch" v-if="search.length > 0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
        <div v-if="isOpenedList" class="h-40 overflow-auto z-40 absolute t-6 w-full bg-white border-2 border-gray-200 rounded-lg">
            <div v-for="value in filteredValues" :key="value.id" class="p-2 cursor-pointer hover:bg-gray-100"
                 :class="{ 'bg-blue-100': selectedValues.includes(value) }"
                 @click="selectValue(value)">
                {{ value.name }}
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref, defineProps, onMounted, onUnmounted, computed} from 'vue';

const props = defineProps({
    values: Array,
    selectedValues: Array,
    placeholder: {
        type: String,
        default: 'Rechercher une valeur',
    },
    isMultiple: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['updateSelectedValues']);

const isOpenedList = ref(false);
const search = ref('');
const searchValues = () => {
    if (search.length > 0) {
        values.value = values.value.filter(value => value.name.toLowerCase().includes(search.toLowerCase()));
    }
};

const clearSearch = () => {
    search.value = '';
};

const selectValue = (value) => {
    if (props.isMultiple) {
        // Is the value already selected?
        if (props.selectedValues.includes(value)) {
            emit('updateSelectedValues', props.selectedValues.filter(selectedValue => selectedValue !== value));
        } else {
            emit('updateSelectedValues', [...props.selectedValues, value]);
        }
    } else {
        isOpenedList.value = false;
        emit('updateSelectedValues', [value]);
    }
};

const filteredValues = computed(() => {
    return props.values.filter(value => value.name.toLowerCase().includes(search.value.toLowerCase()));
});

let autocomplete = ref(null);

onMounted(() => {
    document.addEventListener('click', outsideClickListener);
});

onUnmounted(() => {
    document.removeEventListener('click', outsideClickListener);
});

const outsideClickListener = (event) => {
    if (!autocomplete.value.contains(event.target)) {
        isOpenedList.value = false;
    }
};

</script>
<style scoped>

</style>
