<template>
    <div class="lg:h-screen lg:overflow-hidden">
        <navigation-menu/>
        <!-- FILTERS -->
        <div class="flex flex-wrap h-full">

            <!-- FILTER PART -->
            <div class="w-full flex flex-wrap lg:w-1/3 overflow-auto items-center bg-orange-500">
                <div class="w-full py-8 px-4">
                    <div class="w-full p-3">
                        <button @click="filterCrops()"
                                class="w-full mx-auto bg-lime-500 p-3 rounded-xl cursor-pointer text-white text-2xl font-bold">
                            FILTRER
                        </button>
                    </div>
                    <div class="w-full p-4">
                        <input v-model="userSearch" type="text"
                               placeholder="Rechercher un utilisateur"
                               class="w-full p-2 border-2 border-gray-200 rounded-md"/>
                    </div>
                    <div class="w-full p-4">
                        <!-- An autocomplete input with list of swaps -->
                        <autocomplete v-model="swapSearch" :values="swapList"
                                      placeholder="Selectionner des swaps"
                                      :selected-values="selectedSwaps"
                                      :is-multiple="true"
                                      @updateSelectedValues="updateSelectedSwaps"/>
                        <!-- List of all swaps options -->
                    </div>

                    <!-- SELECTED SWPAS -->
                    <div class="w-full p-5" v-if="selectedSwaps.length > 0">
                        <div class="text-2xl font-bold mb-3">SWAPS SELECTIONNES</div>
                        <div class="flex flex-wrap gap-2">
                            <div v-for="(swap, swapIndex) in selectedSwaps" :key="swapIndex"
                                 class="bg-blue-500 text-white p-2 rounded-md font-bold">
                                {{ swap.name }} <span @click="updateSelectedSwaps(selectedSwaps.filter(selectedSwap => selectedSwap !== swap))"
                                                      class="cursor-pointer">X</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- MAPS PART-->
            <div class="w-full lg:w-2/3 text-5xl font-title font-extrabold text-center">
                <div class="w-full h-screen lg:h-full">
                    <leaflet-map :markers="filteredMarkers"></leaflet-map>
                </div>
            </div>
        </div>
    </div>


</template>

<script setup>

import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import LeafletMap from "@/Components/Maps/LeafletMap.vue";
import Autocomplete from "@/Components/Form/Autocomplete.vue";
import {ref, computed} from "vue";

const userSearch = ref('');
const swapSearch = ref('');
const selectedSwaps = ref([]);

const swapList = ref([
    {
        id: 1,
        name: "Pommes",
    },
    {
        id: 2,
        name: "Poires",
    },
    {
        id: 3,
        name: "Carottes",
    },
    {
        id: 4,
        name: "Tomates",
    },
]);

const markers = ref([
    {
        id: 1,
        icon: 'leaf-green',
        position: [47.2184, -1.5536],
        swaps: [1],
        name: "User 1",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed blandit libero volutpat sed cras ornare arcu.",
    },
    {
        id: 2,
        icon: 'leaf-green',
        position: [48.8566, 2.3522],
        swaps: [2, 3],
        name: "User 2",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
    },
    {
        id: 3,
        icon: 'leaf-orange',
        position: [43.7102, 7.2620],
        swaps: [4],
        name: "User 3",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Fusce id velit ut tortor.",
    },
    {
        id: 4,
        icon: 'leaf-orange',
        position: [45.7102, 5.2620],
        swaps: [1, 3],
        name: "User 4",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Fusce id velit ut tortor.",
    }
]);

let filteredMarkers = ref(markers.value);

const computedSelectedSwapsIds = computed(() => {
    return selectedSwaps.value.map(swap => swap.id);
});

const filterCrops = () => {
    // Filter by user search
    if (userSearch.value.length > 0) {
        filteredMarkers.value = markers.value.filter(marker => {
            return marker.name.toLowerCase().includes(userSearch.value.toLowerCase());
        });
    } else {
        filteredMarkers.value = markers.value;
    }
    if (selectedSwaps.value.length > 0) {
        filteredMarkers.value = filteredMarkers.value.filter(marker => {
            return marker.swaps.some(swap => computedSelectedSwapsIds.value.includes(swap));
        });
    }
};

const updateSelectedSwaps = (swaps) => {
    selectedSwaps.value = swaps;
};

</script>

<style scoped>

</style>
