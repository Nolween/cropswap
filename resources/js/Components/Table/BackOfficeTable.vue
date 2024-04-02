<template>
    <table class="w-full text-center">
        <thead>
        <tr class="border-b-2 border-gray-500">
            <th v-for="(header, headerIndex) in props.headers" :key="headerIndex"
                class="p-2">{{ header.name }}
            </th>
            <th v-if="props.actions.length > 0" class="p-2">ACTIONS</th>
        </tr>
        </thead>
        <tbody>
        <back-office-row v-for="(row, rowIndex) in props.rows" :key="rowIndex"
                         :columns="props.headers"
                         :values="row" :actions="props.actions"
                         @action="activate($event, rowIndex)"
                         @show="showLine(rowIndex)"/>
        </tbody>
    </table>
</template>

<script setup>
import {defineProps, defineEmits} from 'vue';
import BackOfficeRow from "@/Components/Table/BackOfficeRow.vue";

const props = defineProps({
    headers: Array,
    rows: Array,
    actions: Array
});

const emit = defineEmits(['action', 'show']);

const showLine = (rowIndex) => {
    emit('show', rowIndex);
};

const activate = (method, rowIndex) => {
    emit('action', {method, rowIndex});
};

</script>

<style scoped>

</style>
