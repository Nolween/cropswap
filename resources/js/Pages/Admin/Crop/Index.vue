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
                                                :value="user.userId"
                                                :selected="user.userId === parseInt(filters.userId)">
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
                                       :per-page="10"
                                       :actions="actions"/>
                </div>

            </div>
        </div>
        <admin-modal v-if="openBanUserModal && userToBan" title="Bannissement du l'utilisateur">
            <template v-slot:body>
                <div class="text-center">
                    <p>Êtes-vous sûr de vouloir bannir {{ userToBan.user }} ?</p>
                </div>
            </template>
            <template v-slot:footer>
                <div class="flex justify-center space-x-2">
                    <button @click="banUser" type="button"
                            class="p-2 rounded-lg text-md font-medium border-2 border-red-500 text-red-500 hover:text-white hover:bg-red-500 hover:border-transparent">
                        Oui
                    </button>
                    <button @click="[openBanUserModal = false, userToBan = null]" type="button"
                            class="p-2 rounded-lg text-md font-medium border-2 border-lime-500 text-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent">
                        Non
                    </button>
                </div>
            </template>
        </admin-modal>
    </div>
</template>

<script setup>
import {defineProps, ref, computed, reactive} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";
import ContextMenuButton from "@/Components/Buttons/ContextMenuButton.vue";
import AdminModal from "@/Components/Modal/AdminModal.vue";

const props = defineProps({
    crops: Array,
});

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

const rows = ref(props.crops);

const openBanUserModal = ref(false);
const userToBan = ref(null);

const computedUsersList = computed(() => {
//     Get the list of users from the rows and do not duplicate if the user is already in the list
    return rows.value.reduce((acc, row) => {
        if (!acc.find(user => user.userId === row.userId)) {
            acc.push({userId: row.userId, name: row.user});
        }
        return acc;
    }, []);
});

const actions = [
    {
        icon: 'Magnify',
        color: 'blue',
        method: 'seeCrop'
    },
    {
        icon: 'Cancel',
        color: 'red',
        method: 'openBanModal',
    }
];

const filteredRows = computed(() => {
    return rows.value.filter(row => {
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
    if (action?.method === 'seeCrop') {
        seeCrop(action.rowIndex);
    } else if (action?.method === 'openBanModal') {
        openBanModal(action.rowIndex);
    }
};

const seeCrop = (rowIndex) => {
    // Get the crop from the rows
    const crop = filteredRows.value[rowIndex];
    // Visit the crop page in a new tab
    window.open(`/crop/${crop.id}`, '_blank');
};

const openBanModal = (rowIndex) => {
    userToBan.value = filteredRows.value[rowIndex];
    openBanUserModal.value = true;
};

const banUser = async () => {
    if (userToBan.value) {
        await axios.delete(`/account/${userToBan.value.userId}`).then(response => {
            if (response.data.success) {
                rows.value = rows.value.filter(row => row.userId !== userToBan.value.userId);
                openBanUserModal.value = false;
            }
        }).catch(error => {
            console.log(error);
        });
    }
};

const updateFilters = (event, filter) => {
    if (event.target.value === 'null') {
        filters[filter] = null;
        return;
    }
    filters[filter] = event.target.value;
};


</script>

<style scoped>

</style>
