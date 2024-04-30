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
                                    <option value="null">Pas de catégorie</option>
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
                                <input type="file" id="image" name="image" @change="updateImage"
                                       class="w-full p-2 border-2 border-gray-200 rounded-md hidden"/>
                                <label for="image" class="text-gray-600">
                                    <img :src="computedImage" alt="Image du swap"
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
import {defineProps, computed, ref} from "vue";

const props = defineProps({
    swap: {type: Object, nullable: true},
    categories: Object,
});

const computedImage = computed(() => {
    return form.value.image.startsWith('blob') ? form.value.image : `/images/food/${form.value.image}`;
});

const categories = props.categories;

const form = ref({
    name: props.swap.name,
    image: props.swap.image,
    category: props.swap.category,
    id: props.swap.id,

});


const validForm = computed(() => {
    return form.value.name.length > 0
        && form.value.category && form.value.category.length > 0
        && form.value.image.length > 0 && form.value.imageFile
        && form.value.image !== 'empty.svg';
});


const updateImage = (event) => {
    if (event.target.files && event.target.files[0]) {
        form.value.image = URL.createObjectURL(event.target.files[0]);
        form.value.imageFile = event.target.files[0];
    }
};

const submitForm = async () => {
    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('category', form.value.category);
    formData.append('image', form.value.image);
    formData.append('imageFile', form.value.imageFile);

    if (form.value.id) {
        formData.append('id', form.value.id);
        formData.append('_method', 'PUT');

        await axios.post(`/admin/swap/${form.value.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if (response.data.success) {
                window.location.href = route('admin.swap.index');
            }
        }).catch(error => {
            console.log(error.response.data);
        });

    } else {
        await axios.post(`/admin/swap`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if (response.data.success) {
                window.location.href = route('admin.swap.index');
            }
        }).catch(error => {
            console.log(error.response.data);
        });
    }
}
</script>

<style scoped></style>
