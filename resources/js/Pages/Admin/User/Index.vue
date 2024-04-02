<template>
    <div class="md:h-screen md:overflow-hidden">
        <navigation-menu/>
        <div class="h-full flex flex-wrap">
            <!-- ADMIN NAVIGATION -->
            <admin-side-bar></admin-side-bar>
            <!-- CONTENT PART -->
            <div class="w-full md:w-2/3 bg-gray-50">
                <div class="w-full text-xl md:text-5xl font-mono text-orange-500 border-b-2 p-3">
                    UTILISATEURS
                </div>
                <!-- ACTION PART -->
                <div class="w-full flex justify-center items-center p-2 space-x-2">
                    <div class="">
                        <context-menu-button>
                            <template v-slot:content>
                                <div class="w-60 space-y-2">
                                    <!--  An select input with 3 options -->
                                    <select @change="updateFilters($event, 'role')"
                                            class="w-full p-2 border-2 border-gray-200 rounded-md">
                                        <option value="null">Tous les utilisateurs</option>
                                        <option value="User">Utilisateurs</option>
                                        <option value="Admin">Administrateurs</option>
                                    </select>
                                    <!-- A number input option with label indicating minimum report wanted -->
                                    <div class="flex flex-wrap justify-between items-center">
                                        <input v-model="filters.minReport" type="number" id="min-report"
                                               placeholder="Singnalements minimum"
                                               class="w-full border-2 border-gray-200 rounded-md"/>
                                    </div>
                                </div>
                            </template>
                        </context-menu-button>
                    </div>
                    <div class="w-1/2">
                        <input type="text" placeholder="Rechercher un utilisateur"
                               class="w-full p-2 border-2 border-gray-200 rounded-md"
                               v-model="filters.userSearch"/>
                    </div>
                    <Link :href="route('admin.user.create')" type="button" title="Ajouter un utilisateur"
                          class="p-2 rounded-lg text-lime-500 text-md font-medium border-2 border-lime-500 hover:text-white hover:bg-lime-500 hover:border-transparent">
                        <plus-icon :size="24"/>
                    </Link>
                </div>
                <!-- TABLE -->
                <div class="w-full p-2 h-screen overflow-auto md:pb-80">
                    <back-office-table @action="activate"
                                       :headers="headers"
                                       :rows="filteredRows"
                                       :actions="actions"
                                       @show="showUser($event)"/>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, computed, reactive} from 'vue';
import {Link, router} from "@inertiajs/vue3";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";
import AdminSideBar from "@/Layouts/AdminSideBar.vue";
import PlusIcon from "vue-material-design-icons/Plus.vue";
import BackOfficeTable from "@/Components/Table/BackOfficeTable.vue";
import ContextMenuButton from "@/Components/Buttons/ContextMenuButton.vue";
//  Verify if the user is authenticated from session
const authenticated = ref(false);
const userSearch = ref('');

const filters = reactive({
    userSearch: '',
    role: null,
    minReport: 0
});

const headers = [
    {name: 'ID', type: 'string'},
    {name: 'Name', type: 'string'},
    {name: 'Email', type: 'string'},
    {name: 'Role', type: 'string'},
    {name: 'Sign.', type: 'number'},
];

const rows = [
    [1,"Aggy Baylis","abaylis0@adobe.com","user",7],
    [2,"Smitty Banasevich","sbanasevich1@java.com","user",51],
    [3,"Cindy Gasker","cgasker2@columbia.edu","admin",84],
    [4,"Reeba Eatock","reatock3@mlb.com","admin",90],
    [5,"Adelbert Banbrick","abanbrick4@huffingtonpost.com","admin",92],
    [6,"Dewie Hugenin","dhugenin5@shutterfly.com","admin",48],
    [7,"Eimile Emmet","eemmet6@virginia.edu","admin",68],
    [8,"Patton Bensusan","pbensusan7@cdc.gov","admin",61],
    [9,"Alanna Swatridge","aswatridge8@xinhuanet.com","user",98],
    [10,"Morse Eymer","meymer9@earthlink.net","user",21],
    [11,"Gaspard Barten","gbartena@howstuffworks.com","user",33],
    [12,"Collie Jirus","cjirusb@elegantthemes.com","user",81],
    [13,"Aubree Domelow","adomelowc@g.co","user",31],
    [14,"Gabi Netti","gnettid@wp.com","user",4],
    [15,"Ham Happs","hhappse@google.fr","admin",23],
    [16,"Kacie Poundford","kpoundfordf@icq.com","admin",32],
    [17,"Maryjane Tunno","mtunnog@chronoengine.com","admin",55],
    [18,"Filip Hungerford","fhungerfordh@linkedin.com","admin",31],
    [19,"Clayborne Stubbeley","cstubbeleyi@wikispaces.com","admin",93],
    [20,"Gilli Kurtis","gkurtisj@imgur.com","user",60],
    [21,"Maxim Monteaux","mmonteauxk@chron.com","user",38],
    [22,"Sargent Gaylor","sgaylorl@uol.com.br","admin",98],
    [23,"Sheela Drover","sdroverm@i2i.jp","user",40],
    [24,"Elwin Jaime","ejaimen@paypal.com","admin",97],
    [25,"Cathrin Gokes","cgokeso@ifeng.com","admin",2],
    [26,"Thomasin Bountiff","tbountiffp@utexas.edu","user",85],
    [27,"Darwin Graundisson","dgraundissonq@free.fr","admin",16],
    [28,"Randal Glaisner","rglaisnerr@hc360.com","user",13],
    [29,"Edna Dragon","edragons@ameblo.jp","user",40],
    [30,"Nicko Reinhard","nreinhardt@weather.com","user",29],
    [31,"Mariam Huccaby","mhuccabyu@cornell.edu","admin",33],
    [32,"Tracee Atte-Stone","tattestonev@mashable.com","user",56],
    [33,"Marjy Garrood","mgarroodw@va.gov","admin",3],
    [34,"Johnny Custance","jcustancex@jugem.jp","user",13],
    [35,"Lauree Challace","lchallacey@behance.net","admin",43],
    [36,"Sharon Aves","savesz@exblog.jp","admin",29],
    [37,"Redford Merigeau","rmerigeau10@fda.gov","admin",55],
    [38,"Tamara Jeacock","tjeacock11@sohu.com","user",12],
    [39,"Weber Swindells","wswindells12@rambler.ru","admin",41],
    [40,"Izabel Netley","inetley13@amazon.co.jp","user",45],
    [41,"Craig Grzeszczak","cgrzeszczak14@twitter.com","admin",78],
    [42,"Kirby Stout","kstout15@hao123.com","admin",41],
    [43,"Mariann Arkcoll","markcoll16@abc.net.au","user",29],
    [44,"Odie Foyster","ofoyster17@stumbleupon.com","admin",20],
    [45,"Sutton Penhalurick","spenhalurick18@linkedin.com","admin",83],
    [46,"Arlie Waugh","awaugh19@bigcartel.com","user",98],
    [47,"Xever Strooband","xstrooband1a@friendfeed.com","user",25],
    [48,"Phaedra Jelf","pjelf1b@amazonaws.com","admin",10],
    [49,"Filmore Handscomb","fhandscomb1c@merriam-webster.com","user",9],
    [50,"Merill Simakov","msimakov1d@un.org","user",11],
    [51,"Wolfie Fatkin","wfatkin1e@dedecms.com","admin",46],
    [52,"Gilligan Jansens","gjansens1f@tumblr.com","admin",85],
    [53,"Stephine Allgood","sallgood1g@cyberchimps.com","admin",88],
    [54,"Rafaela Neillans","rneillans1h@netvibes.com","admin",19],
    [55,"Eamon Shields","eshields1i@census.gov","user",90],
    [56,"Howie Rankcom","hrankcom1j@blogs.com","user",42],
    [57,"Herbert Fearick","hfearick1k@cocolog-nifty.com","user",85],
    [58,"Elspeth Berns","eberns1l@pcworld.com","user",76],
    [59,"Ari Loughrey","aloughrey1m@goo.ne.jp","admin",76],
    [60,"Finn Francesconi","ffrancesconi1n@elpais.com","admin",41],
    [61,"Arlen Switland","aswitland1o@privacy.gov.au","admin,72"],
    [62,"Sherill Berford","sberford1p@tripadvisor.com","admin",2],
    [63,"Jarid Treadgold","jtreadgold1q@ca.gov","user",80],
    [64,"Cristabel Cluff","ccluff1r@squidoo.com","user",18],
    [65,"Mirilla Skipp","mskipp1s@nasa.gov","user",47],
    [66,"Jammal Finding","jfinding1t@fc2.com","admin",63],
    [67,"Trula Onslow","tonslow1u@wordpress.com","user",61],
    [68,"Nani Golde","ngolde1v@reddit.com","admin",7],
    [69,"Henrietta Kurtis","hkurtis1w@deviantart.com","admin",23],
    [70,"Ahmed Sollis","asollis1x@lycos.com","admin",90],
    [71,"Heinrik Reyner","hreyner1y@over-blog.com","admin",29],
    [72,"Tad Gettins","tgettins1z@devhub.com","admin",17],
    [73,"Nealy Beardon","nbeardon20@woothemes.com","user",68],
    [74,"Baxy Moors","bmoors21@techcrunch.com","user",38],
    [75,"Bail Dawber","bdawber22@xrea.com","admin",30],
    [76,"Annis Osipenko","aosipenko23@springer.com","admin",49],
    [77,"Lynda Bedder","lbedder24@hc360.com","admin",4],
    [78,"Alla Backsal","abacksal25@mtv.com","admin",9],
    [79,"Corinna De Vaar","cde26@cyberchimps.com","user",3],
    [80,"Miran Trayford","mtrayford27@bloglines.com","admin",62],
    [81,"Marielle Dumphrey","mdumphrey28@google.nl","user",88],
    [82,"Rebekkah Server","rserver29@seattletimes.com","admin",41],
    [83,"Carlota Winkell","cwinkell2a@odnoklassniki.ru","admin",40],
    [84,"Henrieta Mounfield","hmounfield2b@walmart.com","admin",74],
    [85,"Alice Corkill","acorkill2c@cornell.edu","user",54],
    [86,"Flory Letchmore","fletchmore2d@msn.com","admin",46],
    [87,"Lazarus Mc Trusty","lmc2e@delicious.com","user",6],
    [88,"Evaleen Boyles","eboyles2f@paypal.com","admin",64],
    [89,"Alwin Sammons","asammons2g@technorati.com","admin",53],
    [90,"Winnifred Haresnaip","wharesnaip2h@hubpages.com","admin",48],
    [91,"Annnora Abrahamovitz","aabrahamovitz2i@blogger.com","admin",74],
    [92,"Gracia Underwood","gunderwood2j@t.co","admin",33],
    [93,"Woodrow Dellow","wdellow2k@jalbum.net","user",27],
    [94,"Mae Ginman","mginman2l@plala.or.jp","admin",15],
    [95,"Lindsy Akitt","lakitt2m@umn.edu","admin",70],
    [96,"Marybeth Justham","mjustham2n@studiopress.com","user",16],
    [97,"Alfy Gorler","agorler2o@4shared.com","user",18],
    [98,"Jayson Blucher","jblucher2p@ocn.ne.jp","admin",23],
    [99,"Nils Lugton","nlugton2q@fc2.com","user",38],
    [100,"Janifer Gibbons","jgibbons2r@cnbc.com","admin",80],
];

const actions = [
    {
        icon: 'PencilOutline',
        color: 'blue',
        method: 'editUser'
    },
    {
        icon: 'Cancel',
        color: 'red',
        method: 'banUser'
    }
];

const filteredRows = computed(() => {
    return rows.filter(row => {
        let returnRow = true;
        if (filters.userSearch.trim().length > 0) {

            returnRow = row[1].toLowerCase().includes(filters.userSearch.toLowerCase()) ||
                row[2].toLowerCase().includes(filters.userSearch.toLowerCase());
            if (!returnRow) {
                return false;
            }
        }
        if (filters.role) {
            returnRow = row[3] === filters.role;
            if (!returnRow) {
                return false;
            }
        }
        if (filters.minReport > 0) {
            returnRow = row[4] >= filters.minReport;
            if (!returnRow) {
                return false;
            }
        }
        return returnRow;
    });
});

const activate = (action) => {
    if (action?.method === 'editUser') {
        editUser(action.rowIndex);
    } else if (action?.method === 'banUser') {
        banUser(action.rowIndex);
    }
};

const editUser = (rowIndex) => {
    console.log('Edit user', rowIndex);
};

const banUser = (rowIndex) => {
    console.log('Ban user', rowIndex);
};

const updateFilters = (event, filter) => {
    filters[filter] = filter !== 'minReport' ? event.target.value : event.target.value.parseInt;
};

const showUser = (rowIndex) => {
    router.visit(`/admin/users/${rowIndex}`);
};


</script>

<style scoped>

</style>
