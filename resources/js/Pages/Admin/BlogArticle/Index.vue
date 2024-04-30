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
                                    <select @change="updateFilters($event, 'user_id')"
                                            class="w-full p-2 border-2 border-gray-200 rounded-md">
                                        <option value="null">Tous les articles</option>
                                        <option v-for="(user, userIndex) in computedArticlesList"
                                                :key="userIndex"
                                                :value="user.user_id" :selected="user.user_id === parseInt(filters.user_id)">
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
                    <Link :href="route('admin.blog-article.create', 0)" type="button" title="Créer un article"
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
import {defineProps,ref, computed, reactive} from 'vue';
import {Link, router} from "@inertiajs/vue3";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";
import ContextMenuButton from "@/Components/Buttons/ContextMenuButton.vue";
import PlusIcon from "vue-material-design-icons/Plus.vue";
//  Verify if the user is authenticated from session
const authenticated = ref(false);
const ArticleSearch = ref('');

const props = defineProps({
    articles: Array,
});

const filters = reactive({
    ArticleSearch: '',
    user_id: null,
    minComments: null,
});


const headers = [
    {column: 'id', name: 'ID', type: 'string', minWidth: 20},
    {column: 'title', name: 'Titre', type: 'string', minWidth: 120},
    {column: 'image', name: 'Image', type: 'image', minWidth: 20},
    {column: 'author', name: 'Auteur', type: 'string', minWidth: 20},
    {column: 'date', name: 'Date', type: 'date', minWidth: 20},
    {column: 'tags', name: 'Tags', type: 'stringArray', minWidth: 20},
    {column: 'comments', name: 'Commentaires', type: 'number', minWidth: 20},
    {column: 'user_id', name: 'Utilisateur', type: 'string', hidden: true, minWidth: 20},
];

const rows = ref(props.articles);

rows.value.map(row => {
    // If image begin with http, do not add the base url
    row.image = row.image.startsWith('http') ? row.image : `/images/blog/${row.image}`;
    return row;
});

const computedArticlesList = computed(() => {
//     Get the list of users from the rows and do not duplicate if the user is already in the list
    return rows.value.reduce((acc, row) => {
        if (!acc.find(user => user.user_id === row.user_id)) {
            acc.push({user_id: row.user_id, name: row.author});
        }
        return acc;
    }, []);
});

const actions = [
    {
        icon: 'Cancel',
        color: 'red',
        method: 'deleteArticle'
    }
];

const filteredRows = computed(() => {
    return rows.value.filter(row => {
        let returnRow = true;
        if (filters.ArticleSearch.trim().length > 0) {

            returnRow = row.title.toLowerCase().includes(filters.ArticleSearch.toLowerCase());
            if (!returnRow) {
                return false;
            }
        }
        if (filters.user_id) {
            returnRow = row.user_id === parseInt(filters.user_id);
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
    const rowId = rows.value[rowIndex].id;
    router.visit(`/admin/blog-articles/${rowId}`);
};


</script>

<style scoped>

</style>
