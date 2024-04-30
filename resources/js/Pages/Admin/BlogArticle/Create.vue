<template>
    <div>
        <div class="">
            <navigation-menu/>
            <div class="h-full flex flex-wrap">
                <!-- ADMIN NAVIGATION -->
                <admin-side-bar></admin-side-bar>
                <!-- CONTENT PART -->
                <div class="w-full md:w-2/3 bg-gray-50">
                    <div v-if="article?.id > 0"
                         class="w-full flex items-center justify-between text-xl lg:text-3xl text-orange-500 border-b-2 p-3">
                        <div class="font-mono">ARTICLES BLOG</div>
                        <div class="space-x-4 font-title text-xl">
                            <button @click="selectedTab = 'general'"
                                    :class="selectedTab === 'general' ? 'text-lime-500' : 'text-gray-500'">
                                GENERAL
                            </button>
                            <button @click="selectedTab = 'comments'"
                                    :class="selectedTab === 'comments' ? 'text-lime-500' : 'text-gray-500'">
                                COMMENTAIRES
                            </button>
                        </div>
                    </div>

                    <!-- GENERAL TAB -->
                    <div v-if="selectedTab === 'general'">
                        <div class="w-full p-2">
                            <!-- TITLE INPUT -->
                            <div class="w-full p-2">
                                <label for="title" class="text-gray-600">Titre de l'article</label>
                                <input v-model="article.title" id="title" type="text" placeholder="Titre de l'article"
                                       class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                            </div>


                            <!-- TAGS PART -->
                            <div class="w-full p-2">
                                <label for="tags" class="text-gray-600">Tags de l'article</label>
                                <div class="flex gap-2">
                                    <input id="tags" v-model="tagToAdd" type="text"
                                           placeholder="Saisissez un nouveau tag"
                                           class="w-full p-2 border-2 border-gray-200 rounded-md"
                                           @keydown.enter="[article.tags.push(tagToAdd), tagToAdd = '']"/>
                                    <button @click="[article.tags.push(tagToAdd), tagToAdd = '']"
                                            class="p-2 rounded-lg text-md text-lime-500 font-medium border-2 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent">
                                        Ajouter
                                    </button>
                                </div>
                                <div class="flex flex-wrap">
                                    <div v-for="(tag, tagIndex) in article.tags" :key="tagIndex"
                                         class="p-2 m-2 bg-gray-200 rounded-lg cursor-pointer hover:bg-red-500 hover:text-white"
                                         @click="article.tags.splice(tagIndex, 1)">
                                        {{ tag }}
                                    </div>
                                </div>
                            </div>


                            <!-- INPUT LOAD IMAGE -->
                            <div class="w-full p-2">
                                <label for="image" class="text-gray-600">Image de l'article</label>
                                <input type="file" id="image" name="image" @change="updateImage"
                                       class="w-full p-2 border-2 border-gray-200 rounded-md hidden"/>
                                <label for="image" class="text-gray-600">
                                    <img :src="article.image" alt="Image principale de l'article"
                                         class="max-w-80 max-h-80 object-cover mx-auto mb-2 cursor-pointer">
                                </label>
                            </div>

                            <div>
                                <complete-editor v-model="article.content"/>
                            </div>

                            <!-- SUBMIT BUTTON -->
                            <div class="w-full p-2">
                                <button type="submit"
                                        @click="submitForm"
                                        class="w-full p-2 rounded-lg  text-md font-medium border-2  cursor-pointer"
                                        :disabled="!validForm"
                                        :class="validForm ? 'text-lime-500 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent' : 'bg-white text-gray-500 hover:bg-gray-500 hover:text-white'">
                                    {{ article?.id ? 'Modifier' : 'Créer' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- COMMENTS TAB -->

                    <div v-else-if="selectedTab === 'comments'">
                        <div class="w-full p-2">

                            <!-- COMMENTS OF THE ARTICLE -->
                            <div class="w-full p-2">
                                <div v-for="(comment, commentIndex) in article.comments" :key="commentIndex"
                                     class="p-2 m-2 bg-gray-200 rounded-lg cursor-pointer hover:bg-red-500 hover:text-white"
                                     @click="openDeleteCommentModal(comment)">
                                    <div class="">{{ comment.content }}</div>
                                    <div class="text-end">Ecrit par {{ comment.user.name }}</div>
                                    <div class="text-end">Le {{ dayjs(comment.created_at).format('DD/MM/YYYY') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL TO DELETE COMMENT -->
        <admin-modal title="Suppression de commentaire" v-if="openedDeleteCommentModal"
                     @close="openedDeleteCommentModal = false">
            <template v-slot:body>
                <div class="text-gray-600 mb-3">Voulez-vous vraiment supprimer ce commentaire ?</div>
                <div class="text-gray-600 mb-3">{{ commentToDelete.content }}</div>
                <div class="flex justify-between">
                    <button @click="openedDeleteCommentModal = false"
                            class="p-2 rounded-lg text-md text-lime-500 font-medium border-2 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent">
                        Annuler
                    </button>
                    <button @click="deleteComment"
                            class="p-2 rounded-lg text-md text-red-500 font-medium border-2 border-red-500 hover:text-white hover:bg-red-500 hover:border-transparent">
                        Supprimer
                    </button>
                </div>
            </template>
        </admin-modal>

        <!-- TOASTR -->
        <response-toastr v-if="updateResponse"/>

    </div>

</template>
<script setup>
import CompleteEditor from "@/Components/Editors/CompleteEditor.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import {defineProps, ref, reactive, computed, onMounted} from "vue";
import dayjs from "dayjs";
import AdminModal from "@/Components/Modal/AdminModal.vue";
import ResponseToastr from "@/Components/Toastr/ResponseToastr.vue";

const props = defineProps({
    article: {
        type: Object,
        nullable: true,
        default: () => ({title: '', content: 'Votre contenu', image: '', tags: [], id: 0, comments: []})
    },
    title: String,
});


const selectedTab = ref('general');

const tagToAdd = ref('');

const article = reactive(props.article);

article.tags = JSON.parse(article.tags);

const openedDeleteCommentModal = ref(false);
const commentToDelete = ref(null);

const updateResponse = ref(false);

const image = ref(null);

const updateImage = (event) => {
    if (event.target.files && event.target.files[0]) {
        article.image = URL.createObjectURL(event.target.files[0]);
        article.imageFile = event.target.files[0];
    }
};

const validForm = computed(() => {
    return article.title && article.content && article.image && article.tags.length > 0;
});

const computedImage = computed(() => {
    // If image begins with http, it's an url
    if (article.image.startsWith('http')) {
        return article.image;
    } else if (article.image) {
        // If image is a file, add the public image blog path
        return `/images/blog/${article.image}`;
    }
    return '/images/blog/default.jpg';
});

const submitForm = () => {
    // Submit article to the server
    const formData = new FormData();
    formData.append('title', article.title);
    formData.append('content', article.content);
    formData.append('image', article.image);
    formData.append('user_id', article.user_id);
    formData.append('imageFile', article.imageFile);
    article.tags.forEach((tag, index) => {
        formData.append(`tags[${index}]`, tag);
    });
    formData.append('id', article.id);

    // Submit to the server
    if (article?.id > 0) {
        formData.append('_method', 'PUT');
        axios.post(`/admin/blog-articles/${article.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
            .then(() => {
                // Launch toastr
                updateResponse.value = true;
            })
            .catch(error => {
                console.log(error);
            });
    } else {
        axios.post('/admin/blog-articles', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
            .then(response => {
                article.id = response.data.articleId;
                console.log(response.data);
                // Launch toastr
                updateResponse.value = true;
            })
            .catch(error => {
                console.log(error);
            });
    }
};

const openDeleteCommentModal = (comment) => {
    // Open the modal to delete the comment
    openedDeleteCommentModal.value = true;
    commentToDelete.value = comment;
};

const deleteComment = () => {
    // Send to the server the comment to delete
    axios.delete(`/admin/comment/${commentToDelete.value.id}`)
        .then(response => {
            if (response.data.success) {
                //     Delete the comment
                article.comments.splice(article.comments.indexOf(commentToDelete.value), 1);
                openedDeleteCommentModal.value = false;
                commentToDelete.value = null;
            }
        })
        .catch(error => {
            console.log(error);
        });
};

onMounted(() => {
    // If article is not null, set the image to the computed image
    if (article?.image) {
        article.image = computedImage.value;
    }
});


</script>
<style scoped>

</style>
