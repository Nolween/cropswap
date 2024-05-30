<template>
    <div class="relative">
        <navigation-menu/>

        <div class="h-full flex flex-wrap">
            <!-- CONTENT PART -->
            <div class="w-full bg-gray-50 overflow-auto h-screen md:pb-40">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    MON COMPTE
                </div>
                <!-- MAIN INFORMATIONS -->
                <div class="w-full bg-orange-500 flex flex-wrap justify-between items-center">
                    <img :src="imagePathResource(editInformations.image, 'user')" alt="User image" class="w-1/3 object-cover"/>
                    <div class="w-2/3 text-start p-3 space-y-2">
                        <div class="w-full">
                            <div class="text-white font-bold text-3xl">
                                {{ informations.name }}
                            </div>
                            <div class="text-white font-bold text-2xl">{{ informations.email }}</div>
                            <div class="text-gray-200 font-bold text-xl">
                                {{ informations.role === 'user' ? 'Utilisateur' : 'Administrateur' }}
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="text-white">Inscription le {{
                                    informations.inscriptionDate.toLocaleDateString()
                                }}
                            </div>
                            <div class="text-white">Dernière connexion le
                                {{ informations.lastConnection.toLocaleDateString() }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ACTIONS -->
                <div class="w-full flex p-3 justify-center gap-2">
                    <button @click="isOpenedEditionModal = true"
                            class="w-1/3 bg-blue-500 text-white p-2 rounded-lg text-2xl font-bold">Modifier
                    </button>
                    <Link :href="route('crop.show', informations.marker[0].id)"
                          class="w-1/3 bg-lime-500 text-white p-2 rounded-lg text-2xl font-bold text-center">Fiche
                    </Link>
                    <button @click="deleteModalOpened = true"
                            class="w-1/3 bg-red-500 text-white p-2 rounded-lg text-2xl font-bold">Supprimer
                    </button>
                </div>
                <!-- CROP -->
                <div class="p-3 w-full justify-center mb-3">
                    <div class="text-center text-3xl text-lime-500 font-bold w-full mb-4">
                        {{ informations.cropName }}
                    </div>

                    <div class="w-full flex justify-center h-[400px]">
                        <leaflet-map :zoom-level="15" :center="informations.cropPosition"
                                     :markers="informations.marker"></leaflet-map>
                    </div>
                </div>
            </div>
        </div>
        <admin-modal v-if="isOpenedEditionModal"
                     title="Editer les informations"
                     @close="isOpenedEditionModal = false">
            <template #body>
                <div class="w-full">
                    <!-- IMAGE -->
                    <div>
                        <label for="image" :class="formErrors.image ?'text-red-500' : 'text-gray-600'">Image de l'article</label>
                        <input type="file" id="image" name="image" @change="updateImage"
                               class="w-full p-2 border-2 border-gray-200 rounded-md hidden"/>
                        <label for="image" class="text-gray-600">
                            <img :src="imagePathResource(editInformations.image, 'user')" alt="Image principale de l'article"
                                 class="max-w-80 max-h-80 object-cover mx-auto mb-2 cursor-pointer">
                        </label>
                    </div>
                    <!-- NAME INPUT -->
                    <div class="gap-2 flex flex-wrap mb-2">
                        <label for="informationName" class="w-full" :class="formErrors.name ?'text-red-500' : 'text-gray-600'">Nom</label>
                        <input name="informationName" type="text" v-model="editInformations.name"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                    <!-- OLD EMAIL INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" class="text-gray-500">Ancien Email</label>
                        <input disabled name="informationEmail" type="text" v-model="editInformations.oldMail"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 bg-gray-100"/>
                    </div>
                    <!-- NEW EMAIL INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" :class="formErrors.newMail ?'text-red-500' : 'text-gray-600'">Nouvel Email</label>
                        <input name="informationEmail" type="text" v-model="editInformations.newMail"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                    <!-- OLD PASSWORD INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" :class="formErrors.oldPassword ?'text-red-500' : 'text-gray-600'">Ancien mot de passe</label>
                        <input name="informationEmail" type="password" v-model="editInformations.oldPassword"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                    <!-- NEW PASSWORD INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" :class="formErrors.newPassword ?'text-red-500' : 'text-gray-600'">Nouveau mot de passe</label>
                        <input name="informationEmail" type="password" v-model="editInformations.newPassword"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                    <!-- NEW PASSWORD INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" :class="formErrors.confirmPassword ?'text-red-500' : 'text-gray-600'">Confirmation mot de passe</label>
                        <input name="informationEmail" type="password" v-model="editInformations.confirmPassword"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="w-full flex justify-end space-x-2">
                    <button class="p-2 bg-gray-300 text-white rounded-lg text-xl font-bold hover:bg-white hover:text-gray-300 hover:border-gray-300 border-2 border-transparent"
                            @click="[isOpenedEditionModal = false, editInformations.image = props.user.image]">Annuler
                    </button>
                    <button class="p-2 text-white rounded-lg text-xl font-bold border-2 border-transparent"
                            :disabled="unValidForm"
                            :class="unValidForm ? 'bg-gray-300' : 'bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-500'"
                            @click="updateInformations">Envoyer
                    </button>
                </div>
            </template>
        </admin-modal>
        <admin-modal v-if="deleteModalOpened" title="Bannir l'utilisateur" @close="deleteModalOpened = false">
            <template #body>
                <div class="w-full mb-4">
                    <div class="text-red-500 text-xl font-bold">Êtes-vous sûr de vouloir supprimer votre compte?</div>
                </div>
                <!-- CHECKBOX TO CONFIRM DELETING OF ACCOUNT-->
                <div class="w-full flex items-center space-x-2">
                    <input v-model="confirmedDeletion" type="checkbox"
                           class="w-6 h-6 border-2 border-gray-300 rounded-md cursor-pointer" id="confirmDelete"/>
                    <label for="confirmDelete" class="text-gray-500 cursor-pointer">Je confirme la suppression de mon
                        compte</label>
                </div>
            </template>
            <template #footer>
                <div class="w-full flex justify-end space-x-2">
                    <button
                        class="p-2 border-2 border-gray-300 hover:border-transparent text-gray-300 hover:bg-gray-300 hover:text-white bg-white rounded-lg text-xl font-bold"
                        @click="deleteModalOpened = false">
                        Annuler
                    </button>
                    <button
                        :disabled="!confirmedDeletion"
                        :class="confirmedDeletion ? 'border-red-300 bg-red-500 text-white hover:bg-white hover:text-red-500' : 'bg-white text-gray-500 hover:bg-gray-500 hover:text-white border-gray-300'"
                        class="p-2 border-2 rounded-lg text-xl font-bold"
                        @click="confirmUserDelete">
                        Supprimer
                    </button>
                </div>
            </template>
        </admin-modal>
    </div>
</template>

<script setup>
import {defineProps, ref, reactive, computed} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import LeafletMap from "@/Components/Maps/LeafletMap.vue";
import {Link} from "@inertiajs/vue3";
import AdminModal from "@/Components/Modal/AdminModal.vue";
import {useTextTools} from "@/Composables/textTools.js";

const {validateEmail, imagePathResource} = useTextTools();

const props = defineProps({
    user: {
        type: Object, default: () => {
        }
    },
    crops: {
        type: Object, default: () => {
        }
    },
});

const isOpenedEditionModal = ref(false);
const deleteModalOpened = ref(false);

const contactMessage = ref('');

const confirmedDeletion = ref(false);

const informations = ref({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    role: props.user.role.charAt(0).toUpperCase() + props.user.role.slice(1),
    inscriptionDate: new Date(props.user.created_at),
    lastConnection: new Date(props.user.last_connection_date),
    cropName: props.crops[0].name,
    image: props.user.image,
    cropPosition: [props.crops[0].latitude, props.crops[0].longitude],
    marker:
        [{
            id: props.crops[0].id,
            icon: 'leaf-green',
            position: [props.crops[0].latitude, props.crops[0].longitude],
            name: props.user.name,
            description: props.crops[0].description,
        }],
});

const editInformations = reactive({
    image: props.user.image,
    imageFile: null,
    name: props.user.name,
    oldMail: props.user.email,
    newMail: null,
    oldPassword: null,
    newPassword: null,
    confirmPassword: null,
})

const formErrors = computed(() => {
    let errors = {
        name: false,
        newMail: false,
        oldPassword: false,
        newPassword: false,
        confirmPassword: false,
        image: false,
    };
    if(!editInformations.image || editInformations.imageFile?.size > 2000000) {
        errors.image = true;
    }
    if (!editInformations.name) {
        errors.name = true;
    }
    // If newMail is not an email
    if (editInformations.newMail && !validateEmail(editInformations.newMail)) {
        errors.newMail = true;
    }
    if (editInformations.newPassword && editInformations.confirmPassword && !editInformations.oldPassword) {
        errors.oldPassword = true;
    }
    if(editInformations.oldPassword && !editInformations.newPassword) {
        errors.newPassword = true;
    }
    if (editInformations.newPassword !== editInformations.confirmPassword) {
        errors.confirmPassword = true;
    }
    return errors;
})

const unValidForm = computed(() => {
    // if  formErrors has at least one true value, return true
    return Object.values(formErrors.value).some(error => error);
})

const updateInformations = async () => {

    const formData = new FormData();
    if(editInformations.name !== props.user.name) {
        formData.append('name', editInformations.name);
    }
    if(editInformations.newMail) {
        formData.append('newMail', editInformations.newMail);
    }
    if(editInformations.oldPassword && editInformations.newPassword && editInformations.confirmPassword) {
        formData.append('oldPassword', editInformations.oldPassword);
        formData.append('newPassword', editInformations.newPassword);
        formData.append('confirmPassword', editInformations.confirmPassword);
    }
    if(editInformations.imageFile && editInformations.image !== props.user.image) {
        formData.append('imageFile', editInformations.imageFile);
        formData.append('image', editInformations.image);
    }
    formData.append('userId', informations.value.id);
    formData.append('_method', 'PUT');

    axios.post(`/account/informations`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(response => {
        if (response.data.success) {
            window.location.href = route('account.informations');
        }
    }).catch(error => {
        console.log(error.response.data);
    });
}

const confirmUserDelete = async () => {
    await axios.delete(`/account/${informations.value.id}`).then(response => {
        if (response.data.success) {
            window.location.href = route('home');
        }
    }).catch(error => {
        console.log(error.response.data);
    });
}

const updateImage = (event) => {
    if (event.target.files && event.target.files[0]) {
        editInformations.image = URL.createObjectURL(event.target.files[0]);
        editInformations.imageFile = event.target.files[0];
    }
}

</script>

<style scoped>

</style>
