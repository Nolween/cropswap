<template>
    <div>
        <navigation-menu></navigation-menu>
        <div class="flex flex-wrap justify-around items-center">
            <div class="w-full md:w-1/2 p-6 font-title text-gray-700 space-y-4">
                <h2 class="text-4xl font-extrabold ">{{ props.title }}</h2>
                <!-- SEPARATOR -->
                <div class="w-1/4 h-0.5 bg-gray-200"></div>

                <div class="w-full flex flex-wrap gap-3">
                    <div class="flex" v-for="(tag, tagIndex) in props.tags" :key="tagIndex">
                    <span @click="goToArticlesTag(tag)"
                          class="hover:text-blue-500 hover:bg-white hover:border-blue-500 border-2 border-transparent bg-blue-500 text-white font-medium p-2 rounded-md cursor-pointer">
                        {{ tag }}
                    </span>
                    </div>
                </div>
                <div class="flex justify-between">
                    <div>
                        <div class="font-bold">{{ props.author }}</div>
                        <div class="font-medium">Le {{ dayjs(props.created_at).format('DD/MM/YYYY') }}</div>
                    </div>
                    <div class="space-x-2">
                        <div class="text-sm font-medium">Partager l'article</div>
                        <div class="flex flex-wrap justify-around">
                            <img class="w-6 h-6" src="https://img.icons8.com/ios/50/000000/facebook-new.png"
                                 alt="facebook"/>
                            <img class="w-6 h-6" src="https://img.icons8.com/ios/50/000000/twitter.png" alt="twitter"/>
                            <img class="w-6 h-6" src="https://img.icons8.com/ios/50/000000/linkedin.png"
                                 alt="linkedin"/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="w-full md:w-1/2 relative">
                <div class="absolute inset-0 bg-gradient-to-r from-white to-transparent"></div>
                <img class="w-full h-full object-cover"
                     :src="computedImage"
                     alt="image">
            </div>
        </div>
        <!-- SEPARATOR -->
        <div class="w-full h-0.5 bg-gray-200"></div>

        <!-- ARTICLE RESUME -->
        <div class="flex flex-wrap">
            <div class="p-6 w-full xl:w-3/4 space-y-4 text-justify">
                <div v-html="props.content"></div>
            </div>
            <!--RELATED POST COLUMN -->
            <div class="w-full xl:w-1/4 p-5 bg-orange-500">
                <div class="font-bold text-2xl mb-3">Articles similaire</div>
                <!--  RELATED POST  -->
                <div class="space-y-4 flex flex-wrap">
                    <related-article v-for="(relatedArticle, relatedArticleIndex) in props.related_articles"
                                     :key="relatedArticleIndex"
                                     :title="relatedArticle.title"
                                     :author="relatedArticle.author"
                                     :date="relatedArticle.date"
                                     :image="relatedArticle.image"
                                     :id="relatedArticle.id"
                                     @goToArticle="goToArticle(relatedArticle.id)"
                    />
                </div>
            </div>
            <!-- COMMENTS -->
            <div class="w-full p-6 space-y-4">
                <div class="font-bold text-2xl">Commentaires</div>
                <div class="flex flex-wrap">
                    <div class="w-full">
                        <textarea v-model="comment" class="w-full p-2 border-2 border-gray-200 rounded-md"
                                  placeholder="Votre commentaire"
                                  rows="5"></textarea>
                    </div>
                    <div class="w-full">
                        <button
                            @click="sendComment"
                            class="w-full p-2 rounded-lg text-md font-medium border-2 cursor-pointer text-white bg-orange-500 hover:bg-orange-600">
                            Commenter
                        </button>
                    </div>
                </div>
                <div class="flex flex-wrap space-y-3">
                    <div v-for="(comment, commentIndex) in props.comments" :key="commentIndex" class="w-full">
                        <div class="flex flex-wrap justify-between p-2 border-b-2 border-gray-200">
                            <div class="flex flex-wrap">
                                <img class="w-10 h-10 object-cover rounded-md mr-3"
                                     :src="comment.avatar"
                                     alt="user image"/>
                                <span class="text-quizzlab-quinary text-xl font-medium pt-1">{{ comment.user }}</span>
                            </div>
                            <div class="flex flex-wrap pt-1">
                                <svg-icon path="mdiTimerOutline" class="text-quizzlab-ternary w-7 h-7 mr-1"
                                          type="mdi"></svg-icon>
                                <span class="text-quizzlab-ternary text-xl font-medium">{{
                                        dayjs(comment.created_at).fromNow()
                                    }}</span>
                            </div>
                        </div>
                        <div class="text-md text-quizzlab-primary font-medium p-2">
                            {{ comment.content }}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>
<script setup>
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import RelatedArticle from "@/Components/Article/RelatedArticle.vue";
import {router} from '@inertiajs/vue3';
import {computed, defineProps, onMounted, ref} from 'vue';
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import 'dayjs/locale/fr';

dayjs.extend(relativeTime);
dayjs.locale('fr')

const props = defineProps({
    title: String,
    content: String,
    image: String,
    id: Number,
    author: String,
    created_at: String,
    updated_at: String,
    tags: Array,
    related_articles: Array,
    comments: Array
});

const comment = ref('');

const goToArticle = (id) => {
    router.visit(`/blog/article/${id}`);
};


const computedImage = computed(() => {
    // If image begins with http, it's an url
    if (props.image.startsWith('http')) {
        return props.image;
    } else if (props.image) {
        // If image is a file, add the public image blog path
        return `/images/blog/${props.image}`;
    }
    return '/images/blog/default.jpg';
});

const goToArticlesTag = (tag) => {
    router.visit(`/blog/${tag}`);
};

const sendComment = async () => {
    axios.post(`/blog/article/comment`, {
        content: comment.value,
        blog_article_id: props.id
    }).then(response => {
        if (response.data.success) {
            props.comments.unshift(response.data.comment);
            comment.value = '';
        }
    }).catch((error) => {
        console.log(error)
    });
};

onMounted(() => {
    // If article is not null, set the image to the computed image
    if (props?.image) {
        props.image = computedImage.value;
    }
});

</script>

<style scoped>


</style>
