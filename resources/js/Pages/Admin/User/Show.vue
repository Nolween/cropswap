<template>
    <div class="md:h-screen relative" :class="{'overflow-hidden' : isOpenedModal}">
        <navigation-menu/>

        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
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
                    <button @click="isOpenedModal = true"
                            class="w-1/3 bg-blue-500 text-white p-2 rounded-lg text-2xl font-bold">Contacter
                    </button>
                    <Link :href="route('crop.show', informations.id)"
                          class="w-1/3 bg-lime-500 text-white p-2 rounded-lg text-2xl font-bold text-center">Fiche
                    </Link>
                    <button @click="banModalOpened = true" class="w-1/3 bg-red-500 text-white p-2 rounded-lg text-2xl font-bold">Bannir</button>
                </div>
                <!-- REPORTED MESSAGES -->
                <div class="p-3 w-full mb-3 gap-4 items-center">
                    <div v-for="(message, messageIndex) in informations.reportedMessages"
                         class="w-full rounded-md bg-white p-2 mb-3">
                        <div class="text-start text-xl text-red-500 font-mono">{{ message.message }}</div>
                        <div class="text-end">{{ message.date }}</div>
                    </div>
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
        <admin-modal v-if="isOpenedModal"
                     title="Contacter l'utilisateur"
                     @close="isOpenedModal = false">
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
                    <button class="p-2 bg-blue-500 text-white rounded-lg text-xl font-bold" @click="isOpenedModal = false">Envoyer
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
                    <button class="p-2 border-2 border-gray-300 hover:border-transparent text-gray-300 hover:bg-gray-300 hover:text-white bg-white rounded-lg text-xl font-bold"
                            @click="banModalOpened = false">
                        Annuler
                    </button>
                    <button class="p-2 border-2 border-red-300 hover:border-transparent  bg-white hover:bg-red-500 text-red-500 hover:text-white rounded-lg text-xl font-bold"
                            @click="banModalOpened = false">
                        Bannir
                    </button>
                </div>
            </template>
        </admin-modal>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import LeafletMap from "@/Components/Maps/LeafletMap.vue";
import {Link} from "@inertiajs/vue3";
import AdminModal from "@/Components/Modal/AdminModal.vue";

const isOpenedModal = ref(false);
const banModalOpened = ref(false);

const contactMessage = ref('');

const informations = ref({
    id: 1,
    name: 'User 678',
    email: 'bla@bla.com',
    role: 'user',
    inscriptionDate: new Date('2022-02-02'),
    lastConnection: new Date('2023-02-02'),
    cropName: 'Crop JKJKDFJK',
    image: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8cG9ydHJhaXR8ZW58MHx8MHx8fDA%3D',
    cropPosition: [44, 4],
    marker:
        [{
            id: 1,
            icon: 'leaf-green',
            position: [44, 4],
            name: "User 1",
            description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed blandit libero volutpat sed cras ornare arcu.",
        }],
    reportedMessages: [
        {
            id: 1,
            message: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed blandit libero volutpat sed cras ornare arcu.',
            reportedBy: 'User 1',
            date: '2022-02-02 12:13:40'
        },
        {
            id: 2,
            message: 'Message 2',
            reportedBy: 'User 2',
            date: '2022-06-14 18:21:52'
        },
        {
            id: 3,
            message: 'Message 3',
            reportedBy: 'User 3',
            date: '2022-06-14 18:21:52'
        },
        {
            id: 4,
            message: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed blandit libero volutpat sed cras ornare arcu.',
            reportedBy: 'User 4',
            date: '2022-02-02 12:13:40'
        },
    ]
});

</script>

<style scoped>

</style>
