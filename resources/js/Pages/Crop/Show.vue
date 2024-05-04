<template>
    <div>
        <navigation-menu/>
        <div class="flex flex-wrap justify-around items-center">
            <div class="w-full md:w-1/2 p-6 font-title text-gray-700 space-y-4">
                <h2 class="text-4xl font-extrabold ">Nom du Crop</h2>
                <p class="text-xl font-medium">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Sed
                    non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras
                    elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin
                    porttitor,
                    orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper.
                    Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus
                    volutpat libero pharetra tempor.</p>
                <!-- SEPARATOR -->
                <div class="w-1/4 h-0.5 bg-gray-200"></div>
                <div class="flex justify-between">
                    <div>
                        <div class="font-bold">Nom du propriétaire</div>
                        <div class="font-medium">Membre depuis le 16/03/2024</div>
                    </div>
                    <div class="space-x-2">
                        <div class="text-sm font-medium">Partager le crop</div>
                        <div class="flex flex-wrap justify-around">
                            <img class="w-6 h-6" src="https://img.icons8.com/ios/50/000000/facebook-new.png"
                                 alt="facebook"/>
                            <img class="w-6 h-6" src="https://img.icons8.com/ios/50/000000/twitter.png" alt="twitter"/>
                            <img class="w-6 h-6" src="https://img.icons8.com/ios/50/000000/linkedin.png"
                                 alt="linkedin"/>
                        </div>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="flex justify-end gap-2">
                    <button
                        class="bg-red-500 text-white hover:bg-white hover:text-red-500 p-2 rounded-md border-2 border-transparent hover:border-2 hover:border-red-500">
                        Signaler
                    </button>
                    <button
                        class="bg-blue-500 text-white hover:bg-white hover:text-blue-500 p-2 rounded-md border-2 border-transparent hover:border-2 hover:border-blue-500">
                        Notifier
                    </button>
                    <button
                        class="bg-lime-500 text-white hover:bg-white hover:text-lime-500 p-2 rounded-md border-2 border-transparent hover:border-2 hover:border-lime-500">
                        Contacter
                    </button>
                </div>

            </div>
            <div class="w-full md:w-1/2 relative">
                <div class="absolute inset-0 bg-gradient-to-r from-white to-transparent"></div>
                <img class="w-full h-full object-cover"
                     src="https://images.unsplash.com/photo-1710587385309-f264b4d503cd?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                     alt="image">
            </div>
        </div>
        <!-- SEPARATOR -->
        <div class="w-full h-0.5 bg-gray-200"></div>

        <!-- DISPONIBLE FOOD -->
        <div class="bg-lime-500 w-full p-8">
            <div class="w-full text-2xl lg:text-5xl font-title text-center text-white font-bold">
                MES SWAPS A PROFUSION
            </div>
            <div class="flex flex-wrap justify-center items-center gap-4 p-5">
                <!-- SWAP MINI CARD -->
                <simple-swap v-for="(lotSwap, lotSwapIndex) in swaps.lot"
                             :key="lotSwapIndex"
                             :swap="lotSwap">
                </simple-swap>
            </div>
        </div>
        <!-- IN PROGRESS FOOD -->
        <div class="bg-orange-500 w-full p-8">
            <div class="w-full text-2xl lg:text-5xl font-title text-center text-white font-bold">
                MES SWAPS BIENTOT DISPONIBLES
            </div>
            <div class="flex flex-wrap justify-center items-center gap-4 p-5">
                <!-- SWAP MINI CARD -->
                <simple-swap v-for="(fewSwap, fewSwapIndex) in swaps.few"
                             :key="fewSwapIndex"
                             :swap="fewSwap">
                </simple-swap>
            </div>
        </div>
        <!-- UNVAILABLE FOOD -->
        <div class="bg-red-500 w-full p-8">
            <div class="w-full text-2xl lg:text-5xl font-title text-center text-white font-bold">
                MES SWAPS EPUISES
            </div>
            <div class="flex flex-wrap justify-center items-center gap-4 p-5">
                <!-- SWAP MINI CARD -->
                <simple-swap v-for="(DoneSwap, DoneSwapIndex) in swaps.done"
                             :key="DoneSwapIndex"
                             :swap="DoneSwap">
                </simple-swap>
            </div>
        </div>
        <!--  MAP WITH NEAR CROPS -->
        <div class="w-full flex justify-center h-[600px]">
            <leaflet-map :zoom-level="15" :center="cropPosition" height="400" :markers="markers"></leaflet-map>
        </div>
    </div>
</template>

<script setup>
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import SimpleSwap from "@/Components/Cards/SimpleSwap.vue";
import {reactive, ref} from 'vue';
import LeafletMap from "@/Components/Maps/LeafletMap.vue";

const swaps = reactive({
    lot: [
        {
            name: "Poires",
            image: "poire.svg"
        },
        {
            name: "Pommes",
            image: "pomme.svg"
        },
        {
            name: "Tomates",
            image: "tomate.svg"
        },
        {
            name: "Carottes",
            image: "carotte.svg"
        },
    ],
    few: [
        {
            name: "Radis Long",
            image: "radis_long.svg"
        },
        {
            name: "Romarin",
            image: "romarin.svg"
        },
        {
            name: "Pastèque",
            image: "pasteque.svg"
        },
        {
            name: "Goyave",
            image: "goyave.svg"
        },
    ],
    done: [
        {
            name: "Cresson",
            image: "cresson.svg"
        },
        {
            name: "Cranberries",
            image: "cranberries.svg"
        },
        {
            name: "Concombre",
            image: "concombre.svg"
        },
        {
            name: "Cidre",
            image: "cidre.svg"
        },
    ]
})

const cropPosition = [44, 4];

const markers = ref([
    {
        id:1,
        icon: 'leaf-green',
        position: [44, 4],
        name: "User 1",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sed blandit libero volutpat sed cras ornare arcu.",
    },
    {
        id:2,
        icon: 'leaf-green',
        position: [44.002, 4.005],
        name: "User 2",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
    },
    {
        id:3,
        icon: 'leaf-orange',
        position: [44.005, 4.001],
        name: "User 3",
        description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Fusce id velit ut tortor.",
    }
]);

</script>

<style scoped>

</style>
