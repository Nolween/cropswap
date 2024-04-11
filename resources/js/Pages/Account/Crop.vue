<template>
    <div class="md:h-screen relative">
        <navigation-menu/>

        <div class="h-full flex flex-wrap">
            <!-- CONTENT PART -->
            <div class="w-full bg-gray-50 overflow-auto h-screen md:pb-40">
                <div
                    class="w-full flex items-center justify-between text-xl md:text-5xl text-orange-500 border-b-2 p-3">
                    <div class="font-mono">MON CROP</div>
                    <div class="space-x-4 font-title text-2xl">
                        <button @click="selectedTab = 'informations'"
                                :class="selectedTab === 'informations' ? 'text-lime-500' : 'text-gray-500'">
                            INFORMATIONS
                        </button>
                        <button @click="selectedTab = 'swaps'"
                                :class="selectedTab === 'swaps' ? 'text-lime-500' : 'text-gray-500'">
                            SWAPS
                        </button>
                    </div>
                </div>
                <!-- INFORMATIONS TAB -->
                <div v-if="selectedTab === 'informations'" class="w-full">
                    <!-- INPUT NAME OF THE CROP -->
                    <div class="w-full p-2">
                        <label for="name" class="text-gray-600">Nom du crop</label>
                        <input v-model="form.cropName" type="text" id="name" name="name"
                               class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                    </div>
                    <!-- INPUT DESCRIPTION OF THE CROP -->
                    <div class="w-full p-2">
                        <label for="description" class="text-gray-600">Description</label>
                        <textarea v-model="form.description" id="description" name="description"
                                  rows="8"
                                  class="w-full p-2 border-2 border-gray-200 rounded-md"></textarea>
                    </div>
                    <!-- INPUT IMAGE OF THE CROP -->
                    <div class="w-full p-2">
                        <span class="text-gray-600">Image du swap</span>
                        <input type="file" id="image" name="image" @change="updateImage"
                               class="w-full p-2 border-2 border-gray-200 rounded-md hidden"/>
                        <label for="image" class="text-gray-600">
                            <img :src="form.image" alt="Image du swap"
                                 class="max-w-80 max-h-80 object-cover mx-auto mb-2 cursor-pointer">
                        </label>
                    </div>
                    <!-- BUTTON TO UPDATE THE CROP -->
                    <div class="w-full p-2">
                        <button @click="updateCrop"
                                class="w-full p-2 rounded-lg  text-md font-medium border-2  cursor-pointer"
                                :class="validForm ? 'text-lime-500 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent' : 'bg-white text-gray-500 hover:bg-gray-500 hover:text-white'">
                            Mettre à jour
                        </button>
                    </div>
                </div>
                <div v-else-if="selectedTab === 'swaps'">
                    <div class="w-full">
                        <!-- An search input -->
                        <div class="w-full p-2">
                            <autocomplete :values="swapList" :selected-values="selectedSwaps"
                                          @updateSelectedValues="updateSelectedSwaps" placeholder="Recherchez un swap"/>
                        </div>

                        <!-- List of selected swaps -->
                        <div class="w-full p-4 bg-lime-500 text-3xl" v-if="computedFilteredSwaps.lotSwap.length > 0">
                            <div class="text-2xl font-bold text-white mb-3">MES SWAPS A PROFUSION</div>
                            <div class="flex flex-wrap justify-evenly gap-2">
                                <div v-for="(swap, swapIndex) in computedFilteredSwaps.lotSwap" :key="swapIndex"
                                     class=" p-2 rounded-md font-bold">
                                    <simple-swap :swap="swap" :actions="swapActions"
                                                 @action="actionSwap($event, {id: swap.id})"/>
                                </div>
                            </div>
                        </div>

                        <div class="w-full p-4 bg-orange-500 text-3xl" v-if="computedFilteredSwaps.fewSwap.length > 0">
                            <div class="text-2xl font-bold text-white mb-3">MES SWAPS PEU NOMBREUX</div>
                            <div class="flex flex-wrap justify-evenly gap-2">
                                <div v-for="(swap, swapIndex) in computedFilteredSwaps.fewSwap" :key="swapIndex"
                                     class=" p-2 rounded-md font-bold">
                                    <simple-swap :swap="swap" :actions="swapActions"
                                                 @action="actionSwap($event, {id: swap.id})"/>
                                </div>
                            </div>
                        </div>

                        <div class="w-full p-4 bg-red-500 text-3xl" v-if="computedFilteredSwaps.noSwap.length > 0">
                            <div class="text-2xl font-bold text-white mb-3">CA POUSSE!</div>
                            <div class="flex flex-wrap justify-evenly gap-2">
                                <div v-for="(swap, swapIndex) in computedFilteredSwaps.noSwap" :key="swapIndex"
                                     class=" p-2 rounded-md font-bold">
                                    <simple-swap :swap="swap" :actions="swapActions"
                                                 @action="actionSwap($event, {id: swap.id})"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL TO CHOOSE QUANTITY -->
        <admin-modal v-if="selectedSwaps.length > 0" @close="selectedSwaps = []" title="Quantité à échanger">
            <template #body>
                <div class="w-full">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <div v-for="(swap, swapIndex) in selectedSwaps" :key="swapIndex"
                             class="text-gray-700 p-2 rounded-md font-bold">
                            <div class="text-2xl font-bold mb-3 w-full">
                                Quelle quantité de {{ swap.name }} avez vous à échanger ?
                            </div>
                            <img :src="`/images/food/${swap.image}`" alt="Swap image"
                                 class="w-20 h-20 object-cover mx-auto mb-2"/>
                            <div class="mx-auto w-full text-center text-2xl flex flex-wrap justify-around gap-2">
                                <button
                                    @click="updateSwapQuantity(swap.id, 0)"
                                    class="bg-white text-red-500 border-2 border-red-500 hover:bg-red-500 hover:text-white hover:border-transparent text-lg p-2 rounded-md">
                                    Pas du tout
                                </button>
                                <button
                                    @click="updateSwapQuantity(swap.id, 1)"
                                    class="bg-white text-orange-500 border-2 border-orange-500 hover:bg-orange-500 hover:text-white hover:border-transparent text-lg p-2 rounded-md">
                                    Un peu
                                </button>
                                <button
                                    @click="updateSwapQuantity(swap.id, 2)"
                                    class="bg-white text-lime-500 border-2 border-lime-500 hover:bg-lime-500 hover:text-white hover:border-transparent text-lg p-2 rounded-md">
                                    Beaucoup !
                                </button>
                            </div>
                        </div>
                    </div>
                    <div></div>

                </div>
            </template>
        </admin-modal>
    </div>
</template>
<script setup>
import {ref, reactive, computed} from 'vue';
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import Autocomplete from "@/Components/Form/Autocomplete.vue";
import AdminModal from "@/Components/Modal/AdminModal.vue";
import SimpleSwap from "@/Components/Cards/SimpleSwap.vue";

const selectedTab = ref('informations');

const form = reactive({
    cropName: '',
    description: '',
    image: '/images/crop/empty.svg'
});


const updateCrop = () => {
    console.log(form);
};

const validForm = computed(() => {
    return form.cropName.length > 0 && form.description.length > 0 && form.image !== '/images/crop/empty.svg';
});

const updateImage = (event) => {
    if (event.target.files && event.target.files[0]) {
        form.image = URL.createObjectURL(event.target.files[0]);
    }
};

const swapActions = {
    updateLot: "A profusion",
    updateFew: "Peu Nombreux",
    updateNone: "Ca pousse!",
    delete: 'Supprimer'
};

const swapList = ref([
    {id: 1, name: 'Tomate', image: 'tomate.svg'},
    {id: 2, name: 'Carotte', image: 'carotte.svg'},
    {id: 3, name: 'Pomme', image: 'pomme.svg'},
    {id: 4, name: 'Poire', image: 'poire.svg'},
    {id: 5, name: 'Banane', image: 'banane.svg'},
    {id: 6, name: 'Fraise', image: 'fraise.svg'},
    {id: 7, name: 'Orange', image: 'orange.svg'},
    {id: 8, name: 'Pomme de terre', image: 'pomme_de_terre.svg'},
    {id: 9, name: 'Salade', image: 'salade.svg'},
    {id: 10, name: 'Concombre', image: 'concombre.svg'},
    {id: 11, name: 'Aubergine', image: 'aubergine.svg'},
    {id: 12, name: 'Poivron', image: 'poivron.svg'},
    {id: 13, name: 'Courgette', image: 'courgette.svg'},
    {id: 14, name: 'Oignon', image: 'oignon.svg'},
    {id: 15, name: 'Ail', image: 'ail.svg'},
    {id: 16, name: 'Chou', image: 'chou.svg'},
    {id: 17, name: 'Brocoli', image: 'brocoli.svg'},
    {id: 18, name: 'Haricot', image: 'haricot.svg'},
    {id: 19, name: 'Pois', image: 'pois.svg'},
    {id: 20, name: 'Fève', image: 'feve.svg'},
    {id: 21, name: 'Radis', image: 'radis.svg'},
    {id: 22, name: 'Betterave', image: 'betterave.svg'},
    {id: 23, name: 'Céleri', image: 'celeri.svg'},
    {id: 24, name: 'Chou-fleur', image: 'chou_fleur.svg'},
    {id: 25, name: 'Courge', image: 'courge.svg'},
    {id: 26, name: 'Potiron', image: 'potiron.svg'},
]);

const selectedSwaps = ref([]);
const userSwaps = ref([
    {id: 1, name: 'Tomate', image: 'tomate.svg', quantity: 0},
    {id: 24, name: 'Chou-fleur', image: 'chou_fleur.svg', quantity: 2},
    {id: 21, name: 'Radis', image: 'radis.svg', quantity: 1},

]);

const updateSelectedSwaps = (values) => {
    selectedSwaps.value = values;
};

const updateSwapQuantity = (swapId, quantity) => {
    const swap = swapList.value.find(swap => swap.id === swapId);
    userSwaps.value.push({...swap, quantity});
    selectedSwaps.value = [];

};

const computedFilteredSwaps = computed(() => {
// 3 arrays of swaps according to quantity
    const noSwap = userSwaps.value.filter(swap => swap.quantity === 0);
    const fewSwap = userSwaps.value.filter(swap => swap.quantity === 1);
    const lotSwap = userSwaps.value.filter(swap => swap.quantity === 2);

    // Sorting the arrays by name
    noSwap.sort((a, b) => a.name.localeCompare(b.name));
    fewSwap.sort((a, b) => a.name.localeCompare(b.name));
    lotSwap.sort((a, b) => a.name.localeCompare(b.name));

    return {
        noSwap,
        fewSwap,
        lotSwap
    };
});


const actionSwap = (action, params) => {
    switch (action) {
        case 'delete':
            userSwaps.value.findIndex((swap, index) => {
                if (swap.id === params.id) {
                    userSwaps.value.splice(index, 1);
                }
            });
            break;
        case 'updateNone':
            userSwaps.value.findIndex((swap, index) => {
                if (swap.id === params.id) {
                    userSwaps.value[index].quantity = 0;
                }
            });
            break;
        case 'updateFew':
            userSwaps.value.findIndex((swap, index) => {
                if (swap.id === params.id) {
                    userSwaps.value[index].quantity = 1;
                }
            });
            break;
        case 'updateLot':
            userSwaps.value.findIndex((swap, index) => {
                if (swap.id === params.id) {
                    userSwaps.value[index].quantity = 2;
                }
            });
            break;
    }
};

</script>

<style scoped>

</style>
