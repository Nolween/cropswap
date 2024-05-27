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
                                <div class="text-gray-500">FILTRES</div>
                                <div class="w-60 space-y-2">
                                    <!--  An select input with 3 options -->
                                    <select @change="updateFilters($event, 'role')" v-model="filters.role"
                                            class="w-full p-2 border-2 border-gray-200 rounded-md">
                                        <option value="null">Tous les utilisateurs</option>
                                        <option value="user">Utilisateurs</option>
                                        <option value="admin">Administrateurs</option>
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
                <div class="w-full p-2 h-screen overflow-auto md:pb-80">
                    <back-office-table @action="activate"
                                       :headers="headers"
                                       :rows="filteredRows"
                                       :actions="actions"
                                       @show="showUser($event)"/>
                </div>

            </div>
        </div>
        <!-- BAN MODAL -->
        <admin-modal v-if="banModalOpened" title="Bannir l'utilisateur" @close="banModalOpened = false">
            <template #body>
                <div class="w-full">
                    <div class="text-red-500 text-xl font-bold">Êtes-vous sûr de vouloir bannir cet utilisateur ?</div>
                </div>
            </template>
            <template #footer>
                <div class="w-full flex justify-end space-x-2">
                    <button
                        class="p-2 border-2 border-gray-300 hover:border-transparent text-gray-300 hover:bg-gray-300 hover:text-white bg-white rounded-lg text-xl font-bold"
                        @click="[banModalOpened = false, userIdToBan = null]">
                        Annuler
                    </button>
                    <button
                        class="p-2 border-2 border-red-300 hover:border-transparent  bg-white hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-xl font-bold"
                        @click="banUser()">
                        Bannir
                    </button>
                </div>
            </template>
        </admin-modal>

        <response-toastr v-if="toaster.delete"/>
    </div>
</template>

<script setup>
import {defineProps, ref, computed, reactive} from 'vue';
import {Link, router} from "@inertiajs/vue3";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import PlusIcon from "vue-material-design-icons/Plus.vue";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";
import ContextMenuButton from "@/Components/Buttons/ContextMenuButton.vue";
import ResponseToastr from "@/Components/Toastr/ResponseToastr.vue";
import AdminModal from "@/Components/Modal/AdminModal.vue";
//  Verify if the user is authenticated from session
const authenticated = ref(false);
const userSearch = ref('');

const props = defineProps({
    users: Array
});

const filters = reactive({
    userSearch: '',
    role: null,
    minReport: 0
});

const banModalOpened = ref(false);

const toaster = reactive({
    delete: false
});

const headers = [
    {column: 'id', name: 'ID', type: 'string'},
    {column: 'image', name: 'Image', type: 'image'},
    {column: 'name', name: 'Name', type: 'string'},
    {column: 'email', name: 'Email', type: 'string'},
    {column: 'role', name: 'Role', type: 'string'},
];

const rows = ref(props.users);

const userIdToBan = ref(null);

const actions = [
    {
        icon: 'Cancel',
        color: 'red',
        method: 'banUser'
    }
];

const filteredRows = computed(() => {
    return rows.value.filter(row => {
        let returnRow = true;
        if (filters.userSearch.trim().length > 0) {

            returnRow = row.name.toLowerCase().includes(filters.userSearch.toLowerCase()) ||
                row.email.toLowerCase().includes(filters.userSearch.toLowerCase());
            if (!returnRow) {
                return false;
            }
        }
        if (filters.role) {
            returnRow = row.role === filters.role;
            if (!returnRow) {
                return false;
            }
        }
        if (filters.minReport > 0) {
            returnRow = row.report >= filters.minReport;
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
        // Find the user id
        userIdToBan.value = filteredRows.value[action.rowIndex].id;
        // Open the modal
        banModalOpened.value = true;
    }
};

const editUser = (rowIndex) => {
    console.log('Edit user', rowIndex);
};


const banUser = async () => {
    // Send the user id to the server to ban the user
    axios.delete(`/account/${userIdToBan.value}`)
        .then(response => {
            if (response.data.success) {
                toaster.delete = true;
                // Remove the user from the rows
                rows.value = rows.value.filter(row => row.id !== userIdToBan.value);
                banModalOpened.value = false;
                userIdToBan.value = null;
            }
        })
        .catch(error => {
            console.log(error);
        });
};

const updateFilters = (event, filter) => {
    if (event.target.value === 'null') {
        filters[filter] = null;
        return;
    }
    filters[filter] = filter !== 'minReport' ? event.target.value : event.target.value.parseInt;
};

const showUser = (rowIndex) => {
    // Get the id
    const id = filteredRows.value[rowIndex].id;
    router.visit(`/admin/users/${id}`);
};


</script>

<style scoped>

</style>
