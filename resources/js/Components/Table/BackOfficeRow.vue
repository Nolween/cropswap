<template>
    <tr @click="showLine" class="border-b-2 border-gray-200 cursor-pointer hover:bg-lime-50">
        <td class="p-2" v-for="(value, valueIndex) in values" :key="valueIndex">{{ value }}</td>
        <td class="p-2 space-x-2">
            <button v-for="(action, actionIndex) in iconComponents" :key="actionIndex"
                    class="cursor-pointer p-2 bg-white rounded-lg text-md font-medium border-2 hover:text-white hover:border-transparent"
                    :class="`border-${action.color}-500 hover:bg-${action.color}-500 text-${action.color}-500`"
                    @click="emitAction(action.method)">
                <component :is="action.icon"
                           :title="action.title"
                           :size="24"
                />
            </button>
        </td>
    </tr>
</template>
<script setup>

import {defineAsyncComponent, onMounted, defineEmits, shallowRef} from "vue";

const props = defineProps({
    values: Array,
    actions: Array
});

const emit = defineEmits(['action', 'show']);

const emitAction = (method) => {
    emit('action', method);
};

// Dynamic import according to the icon props
const loadIcon = async (action) => {

    return {
        icon: await defineAsyncComponent(() => import(`../../../../node_modules/vue-material-design-icons/${action.icon}.vue`)),
        color: action.color,
        method: action.method,
        title: action.icon
    };
};

const showLine = () => {
    emit('show');
};

// Icons components
const iconComponents = shallowRef([]);

// Load icons
onMounted(async () => {
    iconComponents.value = await Promise.all(props.actions.map(loadIcon));
});

</script>
<style scoped>

</style>
