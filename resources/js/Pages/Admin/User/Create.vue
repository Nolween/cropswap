<template>
    <div class="md:h-screen md:overflow-hidden">
        <navigation-menu/>
        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    NOUVEL UTILISATEUR
                </div>

                <!-- USER CREATE FORM -->
                <div class="w-full p-2">
                    <form @submit.prevent="submitForm">
                        <div class="w-full flex flex-wrap">
                            <div class="w-full p-2">
                                <label for="name" class="text-gray-600">Nom</label>
                                <input v-model="form.name" type="text" id="name" name="name"
                                       class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                            </div>
                            <div class="w-full md:w-1/2 p-2">
                                <label for="email" class="text-gray-600">Email</label>
                                <input v-model="form.email" type="email" id="email" name="email"
                                       class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                            </div>
                            <div class="w-full md:w-1/2 p-2">
                                <label for="role" class="text-gray-600">Rôle</label>
                                <select v-model="form.role" id="role" name="role"
                                        class="w-full p-2 border-2 border-gray-200 rounded-md">
                                    <option value="User">Utilisateur</option>
                                    <option value="Admin">Administrateur</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/2 p-2">
                                <label for="password" class="text-gray-600">Mot de passe</label>
                                <input v-model="form.password" type="password" id="password" name="password"
                                       class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                            </div>
                            <div class="w-full md:w-1/2 p-2">
                                <label for="password_confirmation" class="text-gray-600">Confirmer le mot de
                                    passe</label>
                                <input v-model="form.password_confirmation" type="password" id="password_confirmation"
                                       name="password_confirmation"
                                       class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                            </div>
                            <div class="w-full p-2">
                                <button type="submit"
                                        class="w-full p-2 rounded-lg  text-md font-medium border-2  cursor-pointer"
                                        :disabled="!validForm" :class="validForm ? 'text-lime-500 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent' : 'bg-white text-gray-500 hover:bg-gray-500 hover:text-white'">
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
import {ref, computed} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'User'
});

const validForm = computed(() => {
    return form.value.name.length > 0 && form.value.email.length > 0 && form.value.password.length > 0 && form.value.password === form.value.password_confirmation;
});

const submitForm = () => {
    console.log(form.value);
}
</script>

<style scoped>

</style>
