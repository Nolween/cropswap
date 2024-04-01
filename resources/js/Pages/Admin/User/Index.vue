<template>
    <div class="md:h-screen md:overflow-hidden">
        <navigation-menu/>
        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    UTILISATEURS
                </div>
                <!-- ACTION PART -->
                <div class="w-full flex justify-center items-center p-2 space-x-2">
                    <div class="">
                        <context-menu-button>
                            <template v-slot:content>
                                <div class="w-60 space-y-2">
                                    <!--  An select input with 3 options -->
                                    <select @change="updateFilters($event, 'role')"
                                            class="w-full p-2 border-2 border-gray-200 rounded-md">
                                        <option value="null">Tous les utilisateurs</option>
                                        <option value="User">Utilisateurs</option>
                                        <option value="Admin">Administrateurs</option>
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
                        <input type="text" placeholder="Rechercher un utilisateur"
                               class="w-full p-2 border-2 border-gray-200 rounded-md"
                               v-model="filters.userSearch"/>
                    </div>
                    <Link :href="route('admin.user.create')" type="button" title="Ajouter un utilisateur"
                          class="p-2 rounded-lg text-lime-500 text-md font-medium border-2 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent">
                        <plus-icon :size="24"/>
                    </Link>
                </div>
                <!-- TABLE -->
                <div class="w-full p-2">
                    <back-office-table @action="activate" :headers="headers" :rows="filteredRows" :actions="actions"/>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed, reactive} from 'vue';
import {Link} from "@inertiajs/vue3";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import PlusIcon from "vue-material-design-icons/Plus.vue";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";
import ContextMenuButton from "@/Components/Buttons/ContextMenuButton.vue";
//  Verify if the user is authenticated from session
const authenticated = ref(false);
const userSearch = ref('');

const filters = reactive({
    userSearch: '',
    role: null,
    minReport: 0
});

const headers = [
    {name: 'ID', type: 'string'},
    {name: 'Name', type: 'string'},
    {name: 'Email', type: 'string'},
    {name: 'Role', type: 'string'},
    {name: 'Sign.', type: 'number'},
];

const rows = [
    [1, 'John Doe', 'test@test.com', 'Admin', 70],
    [2, 'Jane Doe', 'jane@doe.com', 'User', 9],
    [3, 'John Smith', 'john@smith.com', 'User', 20],
    [4, 'Jane Smith', 'jane@smith.com', 'User', 65],
    [5, 'Bla Bla', 'bla@bla.com', 'Admin', 44]
];

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
        if (filters.userSearch.trim().length > 0) {

            returnRow = row[1].toLowerCase().includes(filters.userSearch.toLowerCase()) ||
                row[2].toLowerCase().includes(filters.userSearch.toLowerCase());
            if (!returnRow) {
                return false;
            }
        }
        if (filters.role) {
            returnRow = row[3] === filters.role;
            if (!returnRow) {
                return false;
            }
        }
        if (filters.minReport > 0) {
            returnRow = row[4] >= filters.minReport;
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
    filters[filter] = filter !== 'minReport' ? event.target.value : event.target.value.parseInt;
};

</script>

<style scoped>

</style>
