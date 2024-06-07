<template>
    <tr @click="showLine" class="border-b-2 border-gray-200 cursor-pointer hover:bg-lime-50">
        <template v-for="(value, valueIndex) in values" :key="valueIndex">
            <td v-if="column(valueIndex).type === 'image' && !column(valueIndex).hidden"
                class="p-2 flex justify-center items-center">
                <img alt="" :src="value" class="object-cover h-11 w-11"/>
            </td>
            <td v-else-if="column(valueIndex).type === 'date' && !column(valueIndex).hidden" class="p-2 text-center">
                {{ dayjs(value).format('DD/MM/YYYY HH:mm:ss') }}
            </td>
            <td v-else-if="column(valueIndex).type === 'stringArray'"
                class="flex flex-wrap gap-2 justify-center items-center">
                <template v-for="(arrayValue, arrayValueIndex) in value" :key="arrayValueIndex">
                    <span class="bg-blue-500 text-white p-2 rounded-md">{{ arrayValue }}</span>
                </template>
            </td>
            <td v-else-if="!column(valueIndex).hidden" class="p-2 text-center">{{ value }}</td>
        </template>
        <td class="p-2 flex flex-wrap gap-2 justify-center">
            <button v-for="(action, actionIndex) in iconComponents" :key="actionIndex"
                    class="action-row-button cursor-pointer p-2 bg-white rounded-lg text-md font-medium border-2 hover:text-white hover:border-transparent"
                    :class="`border-${action.color}-500 hover:bg-${action.color}-500 text-${action.color}-500 action-${action.method}`"
                    @click.stop="emitAction(action.method)">
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
import dayjs from "dayjs";

const props = defineProps({
    values: Object,
    actions: Array,
    columns: Array
});

const emit = defineEmits(['action', 'show']);

const emitAction = (method) => {
    emit('action', method);
};

// Function to find the value type according to props columns
const column = (index) => {
    // Find in props columns the type of the value
    return props.columns.find((column) => column.column === index);
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
