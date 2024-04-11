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
                    <button @click="isOpenedEditionModal = true"
                            class="w-1/3 bg-blue-500 text-white p-2 rounded-lg text-2xl font-bold">Modifier
                    </button>
                    <Link :href="route('crop.show', informations.id)"
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
                    <!-- NAME INPUT -->
                    <div class="gap-2 flex flex-wrap mb-2">
                        <label for="informationName" class="w-full text-gray-500">Nom</label>
                        <input name="informationName" type="text" :value="editInformations.name"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                    <!-- OLD EMAIL INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" class="text-gray-500">Ancien Email</label>
                        <input name="informationEmail" type="text" :value="editInformations.oldMail"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                    <!-- NEW EMAIL INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" class="text-gray-500">Nouvel Email</label>
                        <input name="informationEmail" type="text" :value="editInformations.newMail"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                    <!-- OLD PASSWORD INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" class="text-gray-500">Ancien mot de passe</label>
                        <input name="informationEmail" type="text" :value="editInformations.oldPassword"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                    <!-- NEW PASSWORD INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" class="text-gray-500">Nouveau mot de passe</label>
                        <input name="informationEmail" type="text" :value="editInformations.newPassword"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                    <!-- NEW PASSWORD INPUT -->
                    <div class="gap-2 flex flex-wrap">
                        <label for="informationEmail" class="text-gray-500">Confirmation mot de passe</label>
                        <input name="informationEmail" type="text" :value="editInformations.confirmPassword"
                               class="w-full p-2 border-2 text-gray-500 rounded-md border-gray-200 "/>
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="w-full flex justify-end space-x-2">
                    <button class="p-2 bg-gray-300 text-white rounded-lg text-xl font-bold"
                            @click="isOpenedEditionModal = false">Annuler
                    </button>
                    <button class="p-2 bg-blue-500 text-white rounded-lg text-xl font-bold"
                            @click="isOpenedEditionModal = false">Envoyer
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
                    <input v-model="confirmedDeletion" type="checkbox" class="w-6 h-6 border-2 border-gray-300 rounded-md cursor-pointer" id="confirmDelete"/>
                    <label for="confirmDelete" class="text-gray-500 cursor-pointer">Je confirme la suppression de mon compte</label>
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
                        @click="deleteModalOpened = false">
                        Supprimer
                    </button>
                </div>
            </template>
        </admin-modal>
    </div>
</template>

<script setup>
import {ref, reactive} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import LeafletMap from "@/Components/Maps/LeafletMap.vue";
import {Link} from "@inertiajs/vue3";
import AdminModal from "@/Components/Modal/AdminModal.vue";

const isOpenedEditionModal = ref(false);
const deleteModalOpened = ref(false);

const contactMessage = ref('');

const confirmedDeletion = ref(false);

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

const editInformations = reactive({
    name: null,
    oldMail: null,
    newMail: null,
    oldPassword: null,
    newPassword: null,
    confirmPassword: null,
})

</script>

<style scoped>

</style>
