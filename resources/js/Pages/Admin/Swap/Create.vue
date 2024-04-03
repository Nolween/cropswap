<template>
    <div class="md:h-screen md:overflow-hidden">
        <navigation-menu/>

        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    NOUVEAU SWAP
                </div>

                <!-- FORM -->
                <div class="w-full p-2">
                    <form @submit.prevent="submitForm">
                        <div class="w-full flex flex-wrap">
                            <div class="w-full p-2">
                                <label for="name" class="text-gray-600">Nom</label>
                                <input v-model="form.name" type="text" id="name" name="name"
                                       class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                            </div>
                            <!-- CATEGORY SELECT -->
                            <div class="w-full p-2">
                                <label for="category" class="text-gray-600">Catégorie</label>
                                <select v-model="form.category" id="category" name="category"
                                        class="w-full p-2 border-2 border-gray-200 rounded-md">
                                    <option value="null">Toutes les catégories</option>
                                    <option v-for="(category, categoryIndex) in categories"
                                            :key="categoryIndex"
                                            :value="category.value" :selected="category.value === form.category">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>
                            <!-- INPUT LOAD IMAGE -->
                            <div class="w-full p-2">
                                <span class="text-gray-600">Image du swap</span>
                                <input type="file" id="image" name="image"
                                       class="w-full p-2 border-2 border-gray-200 rounded-md hidden"/>
                                <label for="image" class="text-gray-600">
                                    <img :src="form.image" alt="Image du swap"
                                         class="max-w-80 max-h-80 object-cover mx-auto mb-2 cursor-pointer">
                                </label>
                            </div>
                            <div class="w-full p-2">
                                <button type="submit"
                                        class="w-full p-2 rounded-lg  text-md font-medium border-2  cursor-pointer"
                                        :disabled="!validForm"
                                        :class="validForm ? 'text-lime-500 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent' : 'bg-white text-gray-500 hover:bg-gray-500 hover:text-white'">
                                    Créer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>


    </div>
</template>

<script setup>
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import {computed, ref} from "vue";

const categories = [
    {name: 'Céréale', value: 'cereal'},
    {name: 'Légume', value: 'vegetable'},
    {name: 'Fruit', value: 'fruit'},
];

const form = ref({
    name: '',
    image: 'https://images.unsplash.com/photo-1711924847907-498771a92bde?q=80&w=473&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    category: 'fruit'
});


const validForm = computed(() => {
    return form.value.name.length > 0 && form.value.category.length > 0 && form.value.image.length > 0;
});

const submitForm = () => {
    console.log(form.value);
}
</script>

<style scoped></style>
