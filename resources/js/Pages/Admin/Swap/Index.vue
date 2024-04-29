<template>
    <div class="md:h-screen md:overflow-hidden">
        <navigation-menu/>
        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    SWAPS
                </div>
                <!-- ACTION PART -->
                <div class="w-full flex justify-center items-center p-2 space-x-2">
                    <div class="">
                        <context-menu-button>
                            <template v-slot:content>
                                <div class="text-gray-500">FILTRES</div>
                                <div class="w-60 space-y-2">
                                    <!--  An select input with options -->
                                    <select @change="updateFilters($event, 'category')"
                                            class="w-full p-2 border-2 border-gray-200 rounded-md">
                                        <option value="null">Toutes les catégories</option>
                                        <option v-for="(category, categoryIndex) in categories"
                                                :key="categoryIndex"
                                                :value="category.value" :selected="category.value === filters.category">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
                            </template>
                        </context-menu-button>
                    </div>
                    <div class="w-1/2">
                        <input type="text" placeholder="Rechercher un SWAP"
                               class="w-full p-2 border-2 border-gray-200 rounded-md"
                               v-model="filters.swapSearch"/>
                    </div>
                    <Link :href="route('admin.swap.create')" type="button" title="Ajouter un swap"
                          class="p-2 rounded-lg text-lime-500 text-md font-medium border-2 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent">
                        <plus-icon :size="24"/>
                    </Link>
                </div>
                <!-- TABLE -->
                <div class="w-full p-2 h-screen overflow-auto md:pb-80">
                    <back-office-table @action="activate"
                                       :headers="headers"
                                       :rows="filteredRows"
                                       :actions="actions"
                                       :perPage="10"
                                       @show="showSwap($event)"/>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import {defineProps,ref, computed, reactive} from 'vue';
import {Link, router} from "@inertiajs/vue3";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import PlusIcon from "vue-material-design-icons/Plus.vue";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";
import ContextMenuButton from "@/Components/Buttons/ContextMenuButton.vue";

const props = defineProps({
    swaps: Object,
    categories: Object,
});

//  Verify if the user is authenticated from session
const authenticated = ref(false);
const swapSearch = ref('');

const filters = reactive({
    swapSearch: '',
    category: null,
});

const categories = props.categories;

const headers = [
    {column: 'id', name: 'ID', type: 'string'},
    {column: 'name', name: 'Nom', type: 'string'},
    {column: 'image', name: 'Image', type: 'image'},
    {column: 'category', name: 'Catégorie', type: 'string'},
];

const rows = ref(props.swaps);

const actions = [
    {
        icon: 'PencilOutline',
        color: 'blue',
        method: 'editSwap'
    },
    {
        icon: 'TrashCanOutline',
        color: 'red',
        method: 'deleteSwap'
    }
];

const filteredRows = computed(() => {
    return rows.value.filter(row => {
        let returnRow = true;
        if (filters.swapSearch.trim().length > 0) {

            returnRow = row.name.toLowerCase().includes(filters.swapSearch.toLowerCase());
            if (!returnRow) {
                return false;
            }
        }
        if (filters.category) {
            returnRow = row.category === filters.category;
            if (!returnRow) {
                return false;
            }
        }
        return returnRow;
    });
});

const activate = (action) => {
    if (action?.method === 'editSwap') {
        editSwap(action.rowIndex);
    } else if (action?.method === 'deleteSwap') {
        deleteSwap(action.rowIndex);
    }
};

const editSwap = (rowIndex) => {
    console.log('Edit user', rowIndex);
};

const deleteSwap = (rowIndex) => {
    console.log('Ban user', rowIndex);
};

const updateFilters = (event, filter) => {
    if (event.target.value === 'null') {
        filters[filter] = null;
        return;
    }
    filters[filter] = event.target.value;
};

const showSwap = (rowIndex) => {
    router.visit(`/admin/swaps/${rowIndex}`);
};


</script>

<style scoped>

</style>
