<template>
    <div class="md:h-screen md:overflow-hidden">
        <navigation-menu/>
        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    ARTICLES BLOG
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
                                        <option value="null">Tous les articles</option>
                                        <option v-for="(user, userIndex) in computedArticlesList"
                                                :key="userIndex"
                                                :value="user.userId" :selected="user.userId === parseInt(filters.userId)">
                                            {{ user.name }}
                                        </option>
                                    </select>
                                    <!-- A number input option with label indicating minimum report wanted -->
                                    <div class="flex flex-wrap justify-between items-center">
                                        <input v-model="filters.minComments" type="number" id="min-report"
                                               placeholder="Signalements minimum"
                                               class="w-full border-2 border-gray-200 rounded-md"/>
                                    </div>
                                </div>
                            </template>
                        </context-menu-button>
                    </div>
                    <div class="w-1/2">
                        <input type="text" placeholder="Rechercher un article"
                               class="w-full p-2 border-2 border-gray-200 rounded-md"
                               v-model="filters.ArticleSearch"/>
                    </div>
                    <Link :href="route('admin.swap.create')" type="button" title="Créer un article"
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
                                       @show="showArticle($event)"/>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed, reactive} from 'vue';
import {Link, router} from "@inertiajs/vue3";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";
import ContextMenuButton from "@/Components/Buttons/ContextMenuButton.vue";
import PlusIcon from "vue-material-design-icons/Plus.vue";
//  Verify if the user is authenticated from session
const authenticated = ref(false);
const ArticleSearch = ref('');

const filters = reactive({
    ArticleSearch: '',
    userId: null,
    minComments: null,
});


const headers = [
    {column: 'id', name: 'ID', type: 'string', minWidth: 20},
    {column: 'title', name: 'Titre', type: 'string', minWidth: 120},
    {column: 'image', name: 'Image', type: 'image', minWidth: 20},
    {column: 'user', name: 'Auteur', type: 'string', minWidth: 20},
    {column: 'comments', name: 'Commentaires', type: 'number', minWidth: 20},
    {column: 'date', name: 'Date', type: 'date', minWidth: 20},
    {column: 'userId', name: 'Utilisateur', type: 'string', hidden: true, minWidth: 20},
];

const rows = [
    {id: 1, title: 'Pourquoi les haricots blancs sont blancs et pourquoi les haricots rouges sont rouge?', image: 'https://via.placeholder.com/150', user: 'Cashandrick', comments: 7, date: '2024-03-17 20:09:43' ,userId: 10},
    {id: 2, title: 'Article 2', image: 'https://via.placeholder.com/150', user: 'Cashandrick', comments: 23, date: '2021-02-17 14:39:21' ,userId: 10},
    {id: 2, title: 'Article 3', image: 'https://via.placeholder.com/150', user: 'Cashandrick', comments: 41, date: '2020-06-01 08:12:54' ,userId: 10},
];

const computedArticlesList = computed(() => {
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
        method: 'editArticle'
    },
    {
        icon: 'Cancel',
        color: 'red',
        method: 'deleteArticle'
    }
];

const filteredRows = computed(() => {
    return rows.filter(row => {
        let returnRow = true;
        if (filters.ArticleSearch.trim().length > 0) {

            returnRow = row.title.toLowerCase().includes(filters.ArticleSearch.toLowerCase());
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
        if (filters.minComments) {
            returnRow = row.comments >= parseInt(filters.minComments);
            if (!returnRow) {
                return false;
            }
        }
        return returnRow;
    });
});

const activate = (action) => {
    if (action?.method === 'editArticle') {
        editArticle(action.rowIndex);
    } else if (action?.method === 'deleteArticle') {
        deleteArticle(action.rowIndex);
    }
};

const editArticle = (rowIndex) => {
    console.log('Edit user', rowIndex);
};

const deleteArticle = (rowIndex) => {
    console.log('Ban user', rowIndex);
};

const updateFilters = (event, filter) => {
    if (event.target.value === 'null') {
        filters[filter] = null;
        return;
    }
    filters[filter] = event.target.value;
};

const showArticle = (rowIndex) => {
    router.visit(`/admin/blog-article/${rowIndex}`);
};


</script>

<style scoped>

</style>
