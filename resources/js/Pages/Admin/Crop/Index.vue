<template>
    <div class="md:h-screen md:overflow-hidden">
        <navigation-menu/>
        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    CROPS
                </div>
                <!-- ACTION PART -->
                <div class="w-full flex justify-center items-center p-2 space-x-2">
                    <div class="">
                        <context-menu-button>
                            <template v-slot:content>
                                <div class="text-gray-500">FILTRES</div>
                                <div class="w-60 space-y-2">
                                    <!--  An select input with options -->
                                    <select @change="updateFilters($event, 'userId')"
                                            class="w-full p-2 border-2 border-gray-200 rounded-md">
                                        <option value="null">Tous les utilisateurs</option>
                                        <option v-for="(user, userIndex) in computedUsersList"
                                                :key="userIndex"
                                                :value="user.userId" :selected="user.userId === parseInt(filters.userId)">
                                            {{ user.name }}
                                        </option>
                                    </select>
                                    <!-- A number input option with label indicating minimum report wanted -->
                                    <div class="flex flex-wrap justify-between items-center">
                                        <input v-model="filters.minReport" type="number" id="min-report"
                                               placeholder="Singnalements minimum"
                                               class="w-full border-2 border-gray-200 rounded-md"/>
                                    </div>
                                </div>
                            </template>
                        </context-menu-button>
                    </div>
                    <div class="w-1/2">
                        <input type="text" placeholder="Rechercher un CROP"
                               class="w-full p-2 border-2 border-gray-200 rounded-md"
                               v-model="filters.cropSearch"/>
                    </div>
                </div>
                <!-- TABLE -->
                <div class="w-full p-2 h-screen overflow-auto md:pb-80">
                    <back-office-table @action="activate"
                                       :headers="headers"
                                       :rows="filteredRows"
                                       :actions="actions"
                                       @show="showSwap($event)"/>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed, reactive} from 'vue';
import {router} from "@inertiajs/vue3";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";
import ContextMenuButton from "@/Components/Buttons/ContextMenuButton.vue";
//  Verify if the user is authenticated from session
const authenticated = ref(false);
const cropSearch = ref('');

const filters = reactive({
    cropSearch: '',
    userId: null,
    minReport: null,
});


const headers = [
    {column: 'id', name: 'ID', type: 'string'},
    {column: 'name', name: 'Nom', type: 'string'},
    {column: 'image', name: 'Image', type: 'image'},
    {column: 'user', name: 'Utilisateur', type: 'string'},
    {column: 'reports', name: 'Sign.', type: 'number'},
    {column: 'userId', name: 'Utilisateur', type: 'string', hidden: true},
];

const rows = [
    {id: 1, name: 'Jardin 1 de User 10', image: 'https://via.placeholder.com/150', user: 'User 10', reports: 7, userId: 10},
    {id: 2, name: 'Jardin 1 de User 11', image: 'https://via.placeholder.com/150', user: 'User 11', reports: 17, userId: 11},
    {id: 3, name: 'Jardin 1 de User 12', image: 'https://via.placeholder.com/150', user: 'User 12', reports: 27, userId: 12},
    {id: 4, name: 'Jardin 1 de User 13', image: 'https://via.placeholder.com/150', user: 'User 13', reports: 37, userId: 13},
    {id: 5, name: 'Jardin 2 de User 13', image: 'https://via.placeholder.com/150', user: 'User 13', reports: 47, userId: 13},
    {id: 6, name: 'Jardin 1 de User 15', image: 'https://via.placeholder.com/150', user: 'User 15', reports: 57, userId: 15},
];

const computedUsersList = computed(() => {
//     Get the list of users from the rows and do not duplicate if the user is already in the list
    return rows.reduce((acc, row) => {
        if (!acc.find(user => user.userId === row.userId)) {
            acc.push({userId: row.userId, name: row.user});
        }
        return acc;
    }, []);
});

const actions = [
    {
        icon: 'PencilOutline',
        color: 'blue',
        method: 'editUser'
    },
    {
        icon: 'Cancel',
        color: 'red',
        method: 'banUser'
    }
];

const filteredRows = computed(() => {
    return rows.filter(row => {
        let returnRow = true;
        if (filters.cropSearch.trim().length > 0) {

            returnRow = row.name.toLowerCase().includes(filters.cropSearch.toLowerCase());
            if (!returnRow) {
                return false;
            }
        }
        if (filters.userId) {
            returnRow = row.userId === parseInt(filters.userId);
            if (!returnRow) {
                return false;
            }
        }
        if (filters.minReport) {
            returnRow = row.reports >= parseInt(filters.minReport);
            if (!returnRow) {
                return false;
            }
        }
        return returnRow;
    });
});

const activate = (action) => {
    if (action?.method === 'editUser') {
        editUser(action.rowIndex);
    } else if (action?.method === 'banUser') {
        banUser(action.rowIndex);
    }
};

const editUser = (rowIndex) => {
    console.log('Edit user', rowIndex);
};

const banUser = (rowIndex) => {
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
