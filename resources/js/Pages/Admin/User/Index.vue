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
                        <button
                            class="p-2 rounded-lg text-blue-500 text-md font-medium border-2 border-blue-500 hover:text-white hover:bg-blue-500 hover:border-transparent">
                            <filter-outline-icon size="24"/>
                        </button>
                    </div>
                    <div class="w-1/2">
                        <input type="text" placeholder="Rechercher un utilisateur"
                               class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                    </div>
                    <div class="">
                        <button
                            class="p-2 rounded-lg text-lime-500 text-md font-medium border-2 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent">
                            <plus-icon size="24"/>
                        </button>
                    </div>
                </div>
                <!-- TABLE -->
                <div class="w-full p-2">
                    <back-office-table @action="activate" :headers="headers" :rows="rows" :actions="actions"/>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import FilterOutlineIcon from "vue-material-design-icons/FilterOutline.vue";
import PlusIcon from "vue-material-design-icons/Plus.vue";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";
//  Verify if the user is authenticated from session
const authenticated = ref(false);

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

</script>

<style scoped>

</style>
