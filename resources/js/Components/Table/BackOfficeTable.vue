<template>
    <table class="w-full text-center">
        <thead>
        <tr class="border-b-2 border-gray-500">
            <template v-for="(header, headerIndex) in props.headers" :key="headerIndex">
                <th
                    @click="sort(header.column)"
                    class="p-2 cursor-pointer"

                    v-if="!header.hidden">
                    <div class="flex flex-nowrap justify-center"
                         :class="sorting.column === header.column ? 'text-blue-400 font-bold' : 'text-gray-500'">
                        <div>{{ header.name }}</div>
                        <arrow-up-thin-icon v-if="sorting.column === header.column && sorting.asc" size="24"/>
                        <arrow-down-thin-icon v-if="sorting.column === header.column && !sorting.asc" size="24"/>
                    </div>
                </th>
            </template>
            <th v-if="props.actions.length > 0" class="p-2">ACTIONS</th>
        </tr>
        </thead>
        <tbody>
        <back-office-row v-for="(row, rowIndex) in computedSortedRows" :key="rowIndex"
                         :columns="props.headers"
                         :values="row" :actions="props.actions"
                         @action="activate($event, rowIndex)"
                         @show="showLine(rowIndex)"/>
        </tbody>
    </table>
</template>

<script setup>
import {defineProps, defineEmits, computed, reactive} from 'vue';
import BackOfficeRow from "@/Components/Table/BackOfficeRow.vue";
import ArrowDownThinIcon from 'vue-material-design-icons/ArrowDownThin.vue';
import ArrowUpThinIcon from 'vue-material-design-icons/ArrowUpThin.vue';

const props = defineProps({
    headers: Array,
    rows: Array,
    actions: Array
});

const sorting = reactive({
    column: null,
    asc: null
});

const emit = defineEmits(['action', 'show']);

const showLine = (rowIndex) => {
    emit('show', rowIndex);
};

const activate = (method, rowIndex) => {
    emit('action', {method, rowIndex});
};

const sort = (column) => {
    if (sorting.column === column) {
        sorting.asc = !sorting.asc;
    } else {
        sorting.column = column;
        sorting.asc = true;
    }
};

const computedSortedRows = computed(() => {
    if (sorting.column) {
        return props.rows.sort((a, b) => {
            if (sorting.asc) {
                if (a[sorting.column].type === 'number') {
                    return parseInt(a[sorting.column]) > parseInt(b[sorting.column]) ? 1 : -1;
                } else {
                    return a[sorting.column] > b[sorting.column] ? 1 : -1;
                }
            } else {
                if (a[sorting.column].type === 'number') {
                    return parseInt(a[sorting.column]) < parseInt(b[sorting.column]) ? 1 : -1;
                } else {
                    return a[sorting.column] < b[sorting.column] ? 1 : -1;
                }
            }
        });
    }
    return props.rows;
});

</script>

<style scoped>

</style>
