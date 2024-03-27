<template>
    <div id="mapid" :style="'height:' + props.height +'px;'" class=" mt-4 w-full lg:w-2/3"></div>
</template>

<script setup>

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import {onMounted} from "vue";
import {router} from "@inertiajs/vue3"

const props = defineProps({
    height: {
        type: Number,
        default: 550
    },
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

const goToCrop = (id) => {
    router.visit(`/crop/${id}`);
}


onMounted(() => {
    const map = L.map('mapid').setView(props.center, props.zoomLevel);

    let LeafIcon = L.Icon.extend({
        options: {
            // shadowUrl: 'leaf-shadow.png',
            iconSize:     [38, 95],
            shadowSize:   [50, 64],
            iconAnchor:   [22, 94],
            shadowAnchor: [4, 62],
            popupAnchor:  [-3, -76]
        }
    });

    // Foreach markers to add them to the map
    props.markers.forEach(marker => {
        let oneIcon
        switch(marker.icon) {
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
});
</script>

<style scoped>

</style>
