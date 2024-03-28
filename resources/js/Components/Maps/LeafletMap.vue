<template>
    <div id="mapid" class=" mt-4 w-full h-full"></div>
</template>

<script setup>

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import {onMounted, watch} from "vue";
import {router} from "@inertiajs/vue3"

const props = defineProps({
    zoomLevel: {
        type: Number,
        default: 6
    },
    center: {
        type: Array,
        default: () => [46.605, 1.09]
    },
    markers: {
        //     Array with position as array, icon, name and description properties
        type: Array,
        default: () => []
    }
});

// Map Declaratin
let map;

// Functions
const goToCrop = (id) => {
    router.visit(`/crop/${id}`);
};

const renderMap = () => {

    if (!document.getElementById('mapid')) {
        // If the element does not exist, return early to avoid creating the map.
        return;
    }
    // Destroy map container
    if (map) {
        map.remove();
    }
    map = L.map('mapid', {scrollWheelZoom: false}).setView(props.center, props.zoomLevel);

    let LeafIcon = L.Icon.extend({
        options: {
            // shadowUrl: 'leaf-shadow.png',
            iconSize: [38, 95],
            shadowSize: [50, 64],
            iconAnchor: [22, 94],
            shadowAnchor: [4, 62],
            popupAnchor: [-3, -76]
        }
    });

    // Foreach markers to add them to the map
    props.markers.forEach(marker => {
        let oneIcon
        switch (marker.icon) {
            case 'leaf-green':
                oneIcon = new LeafIcon({iconUrl: '/images/icons/leaf-green.png'});
                break;
            case 'leaf-orange':
                oneIcon = new LeafIcon({iconUrl: '/images/icons/leaf-orange.png'});
                break;
            case 'leaf-red':
                oneIcon = new LeafIcon({iconUrl: '/images/icons/leaf-red.png'});
                break;
            default:
                oneIcon = new LeafIcon({iconUrl: '/images/icons/leaf-green.png'});
        }
        let mark = L.marker(marker.position, {icon: oneIcon}).addTo(map);
        // Add Name of crop and its description
        mark.bindPopup(`<b>${marker.name}</b>
        <br>${marker.description}
        <br><p id="crop-${marker.id}" class="cursor-pointer""><b>Voir le crop</b></p>`);


        mark.on('popupopen', () => {
            let cropElement = document.getElementById(`crop-${marker.id}`);
            cropElement.addEventListener('click', () => goToCrop(marker.id));
        });
    });


    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);


    // Listen for 'keyup' event on the document.
    document.addEventListener('keydown', function (event) {
        if (event.key === "Control") {
            // If the 'Control' key is released, disable scroll wheel zoom.
            map.scrollWheelZoom.enable();
        }
    });
    // Listen for 'keyup' event on the document.
    document.addEventListener('keyup', function (event) {
        if (event.key === "Control") {
            // If the 'Control' key is released, disable scroll wheel zoom.
            map.scrollWheelZoom.disable();
        }
    });
};



onMounted(() => {
    renderMap();
});

watch(
    () => props.markers,
    () => {
        renderMap();
    },
    { deep: true }
);

</script>

<style scoped>

</style>
