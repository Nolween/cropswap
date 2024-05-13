<template>
    <div class="lg:h-screen lg:overflow-hidden">
        <navigation-menu/>
        <!-- FILTERS -->
        <div class="flex flex-wrap h-full">

            <!-- FILTER PART -->
            <div class="w-full flex flex-wrap lg:w-1/3 overflow-auto bg-orange-500">
                <div class="w-full py-8 px-4">
                    <div class="w-full p-4" :class="{'min-h-52 lg:min-h-auto': selectedSwaps.length === 0}">
                        <!-- An autocomplete input with list of swaps -->
                        <autocomplete v-model="swapSearch" :values="swapList"
                                      placeholder="Sélectionner des swaps"
                                      :selected-values="selectedSwaps"
                                      :is-multiple="true"
                                      @updateSelectedValues="updateSelectedSwaps"/>
                    </div>

                    <!-- SELECTED SWAPS -->
                    <div class="w-full p-5" v-if="selectedSwaps.length > 0">
                        <div class="text-2xl font-bold mb-3">SWAPS SELECTIONNES</div>
                        <div class="flex flex-wrap gap-2">
                            <div v-for="(swap, swapIndex) in selectedSwaps" :key="swapIndex"
                                 class="bg-blue-500 text-white p-2 rounded-md font-bold">
                                {{ swap.name }} <span
                                @click="updateSelectedSwaps(selectedSwaps.filter(selectedSwap => selectedSwap !== swap))"
                                class="cursor-pointer">X</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- MAPS PART-->
            <div class="w-full lg:w-2/3 text-5xl font-title font-extrabold text-center">
                <div class="w-full h-screen lg:h-full">
                    <leaflet-map :center="center" :zoom-level="zoomLevel" :markers="filteredMarkers"></leaflet-map>
                </div>
            </div>
        </div>
    </div>


</template>

<script setup>

import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import LeafletMap from "@/Components/Maps/LeafletMap.vue";
import Autocomplete from "@/Components/Form/Autocomplete.vue";
import {ref, defineProps, computed, onBeforeMount} from "vue";

const props = defineProps({
    markers: {type: Array, default: () => []},
    zoomLevel: {type: Number, default: 10},
    swaps: {type: Array, default: () => []},
});


const center = ref([46.605, 1.09]);
const zoomLevel = ref(props.zoomLevel);


const swapSearch = ref('');
const selectedSwaps = ref([]);

const swapList = ref(props.swaps);

const markers = ref(props.markers);

const filteredMarkers = computed(() => {

    if (selectedSwaps.value.length > 0) {
        return markers.value.filter(marker => {
            return marker.swaps.some(swap => selectedSwaps.value.map(selectedSwap => selectedSwap.id).includes(swap.id));
        });
    }
    else {
        return markers.value;
    }
});

const computedSelectedSwapsIds = computed(() => {
    return selectedSwaps.value.map(swap => swap.id);
});

const filterCrops = () => {
    if (selectedSwaps.value.length > 0) {
        filteredMarkers.value = filteredMarkers.value.filter(marker => {
            return marker.swaps.some(swap => computedSelectedSwapsIds.value.includes(swap));
        });
    }
};

const updateSelectedSwaps = (swaps) => {
    selectedSwaps.value = swaps;
};

const getPosition = () => {
    return new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject);
    });
};

onBeforeMount(async () => {
    if (!props.center && localStorage.getItem('userPosition')) {
        center.value = JSON.parse(localStorage.getItem('userPosition'));
    }
    // Try to get geolocation of the user
    else if (navigator.geolocation) {
        try {
            const position = await getPosition();
            localStorage.setItem('userPosition', JSON.stringify([position.coords.latitude, position.coords.longitude]));
            center.value = [position.coords.latitude, position.coords.longitude];
        } catch (error) {
            center.value = [46.605, 1.09];
            zoomLevel.value = 6.4;
        }
    } else {
        center.value = [46.605, 1.09];
        zoomLevel.value = 6.4;
    }
});

</script>

<style scoped>

</style>
