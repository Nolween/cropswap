<template>
    <div class="md:h-screen relative overflow-hidden">
        <navigation-menu/>

        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50 overflow-auto h-screen md:pb-40">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    UTILISATEUR
                </div>
                <!-- MAIN INFORMATIONS -->
                <div class="w-full bg-orange-500 flex flex-wrap justify-between items-center">
                    <img :src="informations.image" alt="User image" class="w-1/3 object-cover"/>
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
                    <button @click="isOpenedContactModal = true"
                            class="w-1/3 bg-blue-500 text-white p-2 rounded-lg text-2xl font-bold">Contacter
                    </button>
                    <Link :href="route('crop.show', informations.id)"
                          class="w-1/3 bg-lime-500 text-white p-2 rounded-lg text-2xl font-bold text-center">Crop
                    </Link>
                    <button @click="banModalOpened = true"
                            class="w-1/3 bg-red-500 text-white p-2 rounded-lg text-2xl font-bold">Bannir
                    </button>
                </div>
                <!-- REPORTED MESSAGES -->
                <div class="p-3 w-full mb-3 gap-4 items-center">
                    <div v-for="(message) in informations.reportedMessages"
                         class="w-full rounded-md bg-white p-2 mb-3">
                        <div class="text-start text-xl text-red-500 font-mono">{{ message.content }}</div>
                        <div class="text-end">{{ dayjs(message.created_at).format('DD/MM/YYYY à HH:mm') }}</div>
                    </div>
                </div>
                <!-- CROP -->
                <div v-if="informations?.cropName" class="p-3 w-full justify-center mb-3">
                    <div class="text-center text-3xl text-lime-500 font-bold w-full mb-4">
                        {{ informations.cropName }}
                    </div>

                    <div class="w-full flex justify-center h-[400px]">
                        <leaflet-map :zoom-level="15" :center="informations.cropPosition"
                                     :markers="informations.marker"></leaflet-map>
                    </div>
                </div>
                <div v-else class="text-3xl text-center text-red-500">PAS DE CROP</div>
            </div>
        </div>
        <admin-modal v-if="isOpenedContactModal"
                     title="Contacter l'utilisateur"
                     @close="isOpenedContactModal = false">
            <template #body>
                <div class="w-full">
                    <textarea class="w-full p-2 border-2 border-gray-200 rounded-md" rows="5"
                              placeholder="Votre message"
                              v-model="contactMessage">

                    </textarea>
                </div>
            </template>
            <template #footer>
                <div class="w-full flex justify-end">
                    <button class="p-2 bg-blue-500 text-white rounded-lg text-xl font-bold" @click="sendMessage">Envoyer
                    </button>
                </div>
            </template>
        </admin-modal>
        <admin-modal v-if="banModalOpened" title="Bannir l'utilisateur" @close="banModalOpened = false">
            <template #body>
                <div class="w-full">
                    <div class="text-red-500 text-xl font-bold">Êtes-vous sûr de vouloir bannir cet utilisateur ?</div>
                </div>
            </template>
            <template #footer>
                <div class="w-full flex justify-end space-x-2">
                    <button
                        class="p-2 border-2 border-gray-300 hover:border-transparent text-gray-300 hover:bg-gray-300 hover:text-white bg-white rounded-lg text-xl font-bold"
                        @click="banModalOpened = false">
                        Annuler
                    </button>
                    <button
                        class="p-2 border-2 border-red-300 hover:border-transparent  bg-white hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-xl font-bold"
                        @click="banUser()">
                        Bannir
                    </button>
                </div>
            </template>
        </admin-modal>

        <response-toastr v-if="toaster.delete" :message="toaster.message"/>

    </div>
</template>

<script setup>
import {defineProps, ref, reactive} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import LeafletMap from "@/Components/Maps/LeafletMap.vue";
import {Link} from "@inertiajs/vue3";
import AdminModal from "@/Components/Modal/AdminModal.vue";
import dayjs from "dayjs";
import ResponseToastr from "@/Components/Toastr/ResponseToastr.vue";

const props = defineProps({
    user: Object,
    admin_id: Number
});


const isOpenedContactModal = ref(false);
const banModalOpened = ref(false);

const contactMessage = ref('');

const toaster = reactive({
    delete: false,
    message: null
});


const informations = ref({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
    inscriptionDate: new Date(props.user.created_at),
    lastConnection: new Date(props.user.updated_at),
    cropName: props.user?.crop[0]?.name,
    image: props.user.image.startsWith('http') ? props.user.image : '/images/user/' + props.user.image,
    cropPosition: [parseFloat(props.user.crop[0]?.latitude), parseFloat(props.user.crop[0]?.longitude)],
    marker:
        [{
            id: props.user.crop[0]?.id,
            icon: 'leaf-green',
            position: [parseFloat(props.user.crop[0]?.latitude), parseFloat(props.user.crop[0]?.longitude)],
            name: props.user.crop[0]?.name,
            description: props.user.crop[0]?.description,
        }],
    reportedMessages: props.user.reported_messages,
});

const banUser = async () => {
    banModalOpened.value = false;
    // Send userId to the server to ban the user
    axios.delete(`/account/${props.user.id}`)
        .then(response => {
            if (response.data.success) {
                // Redirect to the user index page
                window.location.href = '/admin/users/index';
            }
        })
        .catch(error => {
            console.log(error);
        });
};

const sendMessage = async () => {
    // Send the message to the server
    axios.post(`/messages`, {
        sender_id: props.admin_id,
        receiver_id: props.user.id,
        content: contactMessage.value
    })
        .then(response => {
            if (response.data.success) {
                toaster.message = response.data.message;
                toaster.delete = true;
                isOpenedContactModal.value = false;
            }
        })
        .catch(error => {
            console.log(error);
        });
};

</script>

<style scoped>

</style>
