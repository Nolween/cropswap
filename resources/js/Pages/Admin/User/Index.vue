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
                                <div class="text-gray-500">FILTRES</div>
                                <div class="w-60 space-y-2">
                                    <!--  An select input with 3 options -->
                                    <select @change="updateFilters($event, 'role')"
                                            class="w-full p-2 border-2 border-gray-200 rounded-md">
                                        <option value="null">Tous les utilisateurs</option>
                                        <option value="user">Utilisateurs</option>
                                        <option value="admin">Administrateurs</option>
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
    {column: 'id', name: 'ID', type: 'string'},
    {column: 'name', name: 'Name', type: 'string'},
    {column: 'email', name: 'Email', type: 'string'},
    {column: 'role', name: 'Role', type: 'string'},
    {column: 'report', name: 'Sign.', type: 'number'},
];

const rows = [
    {id: 1, name: "Clay Castellucci", email: "ccastellucci0@adobe.com", role: "user", report: 5},
    {id: 2, name: "Allistir Gaspar", email: "agaspar1@naver.com", role: "user", report: 57},
    {id: 3, name: "Tammie Smalecombe", email: "tsmalecombe2@theatlantic.com", role: "admin", report: 52},
    {id: 4, name: "Augustina Gethyn", email: "agethyn3@bloglines.com", role: "user", report: 63},
    {id: 5, name: "Daffy Ogbourne", email: "dogbourne4@acquirethisname.com", role: "admin", report: 38},
    {id: 6, name: "Grenville Boeck", email: "gboeck5@addtoany.com", role: "user", report: 37},
    {id: 7, name: "Rufe Spick", email: "rspick6@fema.gov", role: "user", report: 67},
    {id: 8, name: "Jaine Worvill", email: "jworvill7@indiatimes.com", role: "admin", report: 83},
    {id: 9, name: "Amalee Bryce", email: "abryce8@sakura.ne.jp", role: "user", report: 95},
    {id: 10, name: "Jemimah Pentelow", email: "jpentelow9@abc.net.au", role: "admin", report: 28},
    {id: 11, name: "Koressa Frend", email: "kfrenda@creativecommons.org", role: "admin", report: 5},
    {id: 12, name: "Dickie Beyne", email: "dbeyneb@sciencedaily.com", role: "user", report: 20},
    {id: 13, name: "Serge MacSharry", email: "smacsharryc@jimdo.com", role: "admin", report: 96},
    {id: 14, name: "Delmer Drewson", email: "ddrewsond@homestead.com", role: "admin", report: 10},
    {id: 15, name: "Trumann Vlach", email: "tvlache@tinyurl.com", role: "user", report: 24},
    {id: 16, name: "Celine Metterick", email: "cmetterickf@nps.gov", role: "admin", report: 59},
    {id: 17, name: "Issi Chipping", email: "ichippingg@printfriendly.com", role: "admin", report: 7},
    {id: 18, name: "Egan Wordsworth", email: "ewordsworthh@booking.com", role: "user", report: 91},
    {id: 19, name: "Marya Pinckstone", email: "mpinckstonei@netlog.com", role: "user", report: 6},
    {id: 20, name: "Tanner McMonies", email: "tmcmoniesj@purevolume.com", role: "admin", report: 58},
    {id: 21, name: "Alyosha Aysh", email: "aayshk@rakuten.co.jp", role: "admin", report: 28},
    {id: 22, name: "Hughie Brightie", email: "hbrightiel@dyndns.org", role: "user", report: 24},
    {id: 23, name: "Morie Fellowes", email: "mfellowesm@washington.edu", role: "user", report: 34},
    {id: 24, name: "Janene Worthington", email: "jworthingtonn@abc.net.au", role: "user", report: 96},
    {id: 25, name: "Carmelia Smallpeace", email: "csmallpeaceo@mapy.cz", role: "admin", report: 7},
    {id: 26, name: "Sharyl Goulbourn", email: "sgoulbournp@ed.gov", role: "admin", report: 95},
    {id: 27, name: "Coraline Lob", email: "clobq@fotki.com", role: "admin", report: 64},
    {id: 28, name: "Kat Chelam", email: "kchelamr@xrea.com", role: "admin", report: 98},
    {id: 29, name: "Georas Overnell", email: "governells@hostgator.com", role: "admin", report: 56},
    {id: 30, name: "Vernor Joss", email: "vjosst@nationalgeographic.com", role: "admin", report: 29},
    {id: 31, name: "Walker Cattel", email: "wcattelu@storify.com", role: "user", report: 24},
    {id: 32, name: "Yvon Ivatts", email: "yivattsv@bluehost.com", role: "user", report: 98},
    {id: 33, name: "Hubie Jerzycowski", email: "hjerzycowskiw@squidoo.com", role: "user", report: 74},
    {id: 34, name: "Bentley Witsey", email: "bwitseyx@weebly.com", role: "user", report: 3},
    {id: 35, name: "Matilda Lowdiane", email: "mlowdianey@pbs.org", role: "user", report: 11},
    {id: 36, name: "Florinda Solloway", email: "fsollowayz@slashdot.org", role: "user", report: 1},
    {id: 37, name: "Kathleen Puckrin", email: "kpuckrin10@mayoclinic.com", role: "admin", report: 28},
    {id: 38, name: "Gregor Brik", email: "gbrik11@unesco.org", role: "admin", report: 60},
    {id: 39, name: "Josefa Slogrove", email: "jslogrove12@baidu.com", role: "admin", report: 45},
    {id: 40, name: "Jobey Casellas", email: "jcasellas13@wp.com", role: "admin", report: 42},
    {id: 41, name: "Ottilie Oslar", email: "ooslar14@nba.com", role: "admin", report: 12},
    {id: 42, name: "Jacqui Luipold", email: "jluipold15@pbs.org", role: "admin", report: 46},
    {id: 43, name: "Buddy Jerosch", email: "bjerosch16@whitehouse.gov", role: "admin", report: 73},
    {id: 44, name: "Dominique Drogan", email: "ddrogan17@symantec.com", role: "admin", report: 12},
    {id: 45, name: "Louis Sylvaine", email: "lsylvaine18@vistaprint.com", role: "user", report: 66},
    {id: 46, name: "Christophe Danielski", email: "cdanielski19@wordpress.org", role: "admin", report: 6},
    {id: 47, name: "Levon Robben", email: "lrobben1a@ibm.com", role: "admin", report: 78},
    {id: 48, name: "Kearney Totaro", email: "ktotaro1b@imdb.com", role: "user", report: 10},
    {id: 49, name: "Sena Meriton", email: "smeriton1c@hc360.com", role: "user", report: 2},
    {id: 50, name: "Dixie Eirwin", email: "deirwin1d@eepurl.com", role: "admin", report: 25},
    {id: 51, name: "Odessa Laborda", email: "olaborda1e@vistaprint.com", role: "user", report: 10},
    {id: 52, name: "Allis Cranston", email: "acranston1f@odnoklassniki.ru", role: "user", report: 74},
    {id: 53, name: "Travers Ivens", email: "tivens1g@privacy.gov.au", role: "user", report: 47},
    {id: 54, name: "Winni Splain", email: "wsplain1h@amazon.de", role: "admin", report: 31},
    {id: 55, name: "Morie Jevon", email: "mjevon1i@businessinsider.com", role: "admin", report: 43},
    {id: 56, name: "Yoshiko Garrood", email: "ygarrood1j@guardian.co.uk", role: "user", report: 2},
    {id: 57, name: "Heriberto Cordon", email: "hcordon1k@phpbb.com", role: "user", report: 49},
    {id: 58, name: "Rock Cheine", email: "rcheine1l@gnu.org", role: "user", report: 35},
    {id: 59, name: "Geoffry Dhennin", email: "gdhennin1m@cornell.edu", role: "user", report: 53},
    {id: 60, name: "Devy Inkster", email: "dinkster1n@tinyurl.com", role: "user", report: 84},
    {id: 61, name: "Alene Bartram", email: "abartram1o@xrea.com", role: "admin", report: 66},
    {id: 62, name: "Skyler Bolsover", email: "sbolsover1p@craigslist.org", role: "user", report: 90},
    {id: 63, name: "Gael Detloff", email: "gdetloff1q@fc2.com", role: "admin", report: 83},
    {id: 64, name: "Bernette Gledhill", email: "bgledhill1r@cafepress.com", role: "admin", report: 59},
    {id: 65, name: "Demeter Durek", email: "ddurek1s@intel.com", role: "user", report: 63},
    {id: 66, name: "Deloria Cartner", email: "dcartner1t@wp.com", role: "user", report: 15},
    {id: 67, name: "Jena Lung", email: "jlung1u@istockphoto.com", role: "user", report: 83},
    {id: 68, name: "Sumner Daugherty", email: "sdaugherty1v@twitpic.com", role: "admin", report: 100},
    {id: 69, name: "Valida Posen", email: "vposen1w@is.gd", role: "user", report: 65},
    {id: 70, name: "Daveen Maplestone", email: "dmaplestone1x@biblegateway.com", role: "user", report: 42},
    {id: 71, name: "Estele Douch", email: "edouch1y@nyu.edu", role: "user", report: 59},
    {id: 72, name: "Isidore Foord", email: "ifoord1z@redcross.org", role: "admin", report: 23},
    {id: 73, name: "Arabella Hassey", email: "ahassey20@phpbb.com", role: "user", report: 26},
    {id: 74, name: "Filbert Edworthie", email: "fedworthie21@facebook.com", role: "user", report: 69},
    {id: 75, name: "Carma Stegell", email: "cstegell22@telegraph.co.uk", role: "user", report: 10},
    {id: 76, name: "Buffy Buddell", email: "bbuddell23@ucla.edu", role: "admin", report: 33},
    {id: 77, name: "Dunc Stiff", email: "dstiff24@taobao.com", role: "admin", report: 74},
    {id: 78, name: "Ainslee Huett", email: "ahuett25@ezinearticles.com", role: "admin", report: 97},
    {id: 79, name: "Anastasie Gerald", email: "agerald26@umn.edu", role: "user", report: 78},
    {id: 80, name: "Merle Gavriel", email: "mgavriel27@printfriendly.com", role: "admin", report: 81},
    {id: 81, name: "Fee Gumn", email: "fgumn28@scientificamerican.com", role: "admin", report: 90},
    {id: 82, name: "Menard Greschke", email: "mgreschke29@blinklist.com", role: "admin", report: 90},
    {id: 83, name: "Stacy Josskoviz", email: "sjosskoviz2a@istockphoto.com", role: "admin", report: 85},
    {id: 84, name: "Kristoforo Kern", email: "kkern2b@seattletimes.com", role: "user", report: 32},
    {id: 85, name: "Marget Poor", email: "mpoor2c@netscape.com", role: "user", report: 43},
    {id: 86, name: "Radcliffe Bensley", email: "rbensley2d@mayoclinic.com", role: "admin", report: 19},
    {id: 87, name: "Ignacius Weatherhead", email: "iweatherhead2e@un.org", role: "admin", report: 88},
    {id: 88, name: "Ursula Rawll", email: "urawll2f@is.gd", role: "admin", report: 82},
    {id: 89, name: "Selena Yurlov", email: "syurlov2g@apache.org", role: "user", report: 61},
    {id: 90, name: "Rosemary Hartly", email: "rhartly2h@columbia.edu", role: "admin", report: 20},
    {id: 91, name: "Belicia Dupre", email: "bdupre2i@umich.edu", role: "user", report: 39},
    {id: 92, name: "Sid Oxtarby", email: "soxtarby2j@samsung.com", role: "admin", report: 34},
    {id: 93, name: "Taylor Gerbl", email: "tgerbl2k@friendfeed.com", role: "user", report: 38},
    {id: 94, name: "Basil Nurden", email: "bnurden2l@chronoengine.com", role: "admin", report: 72},
    {id: 95, name: "Paulie Lenox", email: "plenox2m@infoseek.co.jp", role: "admin", report: 68},
    {id: 96, name: "Donella Leverett", email: "dleverett2n@ning.com", role: "user", report: 41},
    {id: 97, name: "Alexander Boyde", email: "aboyde2o@nationalgeographic.com", role: "admin", report: 1},
    {id: 98, name: "Clo Pettigree", email: "cpettigree2p@etsy.com", role: "admin", report: 36},
    {id: 99, name: "Judi Flatt", email: "jflatt2q@blogger.com", role: "admin", report: 52},
    {id: 100, name: "Ben Wallenger", email: "bwallenger2r@indiatimes.com", role: "admin", report: 21}];

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

            returnRow = row.name.toLowerCase().includes(filters.userSearch.toLowerCase()) ||
                row.email.toLowerCase().includes(filters.userSearch.toLowerCase());
            if (!returnRow) {
                return false;
            }
        }
        if (filters.role) {
            returnRow = row.role === filters.role;
            if (!returnRow) {
                return false;
            }
        }
        if (filters.minReport > 0) {
            returnRow = row.report >= filters.minReport;
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
    if (event.target.value === 'null') {
        filters[filter] = null;
        return;
    }
    filters[filter] = filter !== 'minReport' ? event.target.value : event.target.value.parseInt;
};

const showUser = (rowIndex) => {
    router.visit(`/admin/users/${rowIndex}`);
};


</script>

<style scoped>

</style>
