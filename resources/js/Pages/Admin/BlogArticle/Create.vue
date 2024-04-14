<template>
    <div>
        <div class="">
            <navigation-menu/>
            <div class="h-full flex flex-wrap">
                <!-- ADMIN NAVIGATION -->
                <admin-side-bar></admin-side-bar>
                <!-- CONTENT PART -->
                <div class="w-full md:w-2/3 bg-gray-50">
                    <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                        ARTICLES BLOG
                    </div>
                    <!-- TITLE INPUT -->
                    <div class="w-full p-2">
                        <input v-model="title" type="text" placeholder="Titre de l'article"
                               class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                    </div>


                    <!-- INPUT LOAD IMAGE -->
                    <div class="w-full p-2">
                        <span class="text-gray-600">Image principale</span>
                        <input type="file" id="image" name="image" @change="updateImage"
                               class="w-full p-2 border-2 border-gray-200 rounded-md hidden"/>
                        <label for="image" class="text-gray-600">
                            <img :src="image" alt="Image principale de l'article"
                                 class="max-w-80 max-h-80 object-cover mx-auto mb-2 cursor-pointer">
                        </label>
                    </div>

                    <div>
                        <complete-editor v-model="content"/>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <div class="w-full p-2">
                        <button type="submit"
                                class="w-full p-2 rounded-lg  text-md font-medium border-2  cursor-pointer"
                                :disabled="!validForm"
                                :class="validForm ? 'text-lime-500 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent' : 'bg-white text-gray-500 hover:bg-gray-500 hover:text-white'">
                            Créer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
import CompleteEditor from "@/Components/Editors/CompleteEditor.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import {ref} from "vue";

const title = ref('');
const image = ref('/images/crop/empty.svg');
const content = ref('BLA BLA BLA');

const updateImage = (event) => {
    if (event.target.files && event.target.files[0]) {
        image.value = URL.createObjectURL(event.target.files[0]);
    }
};

const validForm = title.value.length > 0 && content.value.length > 0;

const submitForm = () => {
    console.log('submit');
};

</script>
<style scoped>

</style>
