<template>
    <div class="col-span-9 lg:col-span-9 xxl:col-span-9">
        <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto"> Moje oferty</h2>
        </div>
        <div class="grid grid-cols-12 gap-6">

            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-6 xxl:col-span-6" v-for="(offer, index) in offers.list" :key="index">

                <div :class="(offer.rejected === 1) ? 'px-5 py-5 opacity-50' : 'px-5 py-5'">
                    <div id="latest-tasks-new" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                        <div class="flex items-center">
                            <div class="pl-4 my-2">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Rozwiązanie</span>
                                <div class="ark:text-theme-10 text-theme-1 pt-1" style="font-size: 16px;"> {{ offer.solution.name }}</div>
                            </div>
                            <div class="mt-2 pl-9 pb-6" v-if="(user.id === offer.installer_id)">
                                <button class="btn btn-primary shadow-md mr-2" @click="publishOffer(offer)" v-if="offer.status != 1">Opublikuj ofertę</button>
                                <button class="btn btn-primary shadow-md mr-2" @click="editOffer(offer.id)" v-if="offer.status != 1">Edytuj</button>
                                <button class="btn btn-primary shadow-md mr-2" @click="deleteOffer(offer.id)" v-if="offer.status != 1">Usuń</button>
                            </div>
                            <div class="flex items-center justify-center text-theme-9" v-if="offer.selected == 1"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Zaakceptowano </div>
                            <div class="flex items-center justify-center text-theme-6" v-if="offer.rejected == 1"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Odrzucono </div>
                            <div class="flex items-center mr-3" v-if="(offer.rejected != 1) && (offer.selected != 1) && (offer.status == 1)"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Oczekuje na akceptację </div>
                        </div>
                        <div class="flex items-center">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Okres ważności oferty w dniach:</span>
                                <div class="text-gray-600"> {{ offer.offer_expires_in }} dni</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Cena za dostawę oraz uruchomienie stanowiska (netto):</span>
                                <div class="text-gray-600"> {{ offer.price_of_delivery }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Ilość tygodni do uruchomienia, liczona od podpisania umowy:</span>
                                <div class="text-gray-600"> {{ values['weeks'][offer.weeks_to_start] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Czas realizacji uruchomienia u klienta (tygodni):</span>
                                <div class="text-gray-600"> {{ values['weeks-short'][offer.time_to_start] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Czas przywrócenia stanowiska do sprawności po awarii:</span>
                                <div class="text-gray-600"> {{ values['hours'][offer.time_to_fix] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Wysokość zaliczki (%) płatnej po podpisaniu umowy:</span>
                                <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_agreement] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Wyskość zaliczki (%) płatnej przy odbiorze wstępnym dokonywanym u Integratora:</span>
                                <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_delivery] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Wysokość zaliczki płatnej po uruchomieniu i finalnym odbiorze stanowiska:</span>
                                <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_start] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Okres gwarancji w latach:</span>
                                <div class="text-gray-600"> {{ values['years-short'][offer.years_of_guarantee] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Częstotliwość przeglądów gwarancyjnych w roku:</span>
                                <div class="text-gray-600"> {{ offer.maintenance_frequency }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Koszt roczny przeglądu gwaranycjnego:</span>
                                <div class="text-gray-600"> {{ offer.price_of_maintenance }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Czas reakcji na zgłoszenie awarii w godzinach:</span>
                                <div class="text-gray-600"> {{ values['hours'][offer.reaction_time] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Koszt interwencji w wypadku awarii nie podlegającej gwarancji:</span>
                                <div class="text-gray-600"> {{ offer.intervention_price }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Koszt roboczo godziny pracy wsparcia / prac rozwojowych:</span>
                                <div class="text-gray-600"> {{ offer.work_hour_price }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Okres wsparcia technicznego poza zakresem gwarancji w latach:</span>
                                <div class="text-gray-600"> {{ offer.period_of_support }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Announcement -->
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import GetOffers from "../../../compositions/GetOffers";
import GetChallengeOffers from "../../../compositions/GetChallengeOffers";
import {useToast} from "vue-toastification";
import OfferAdd from "./OfferAdd";

const toast = useToast();

export default {
    name: "Offers",
    components :{
      OfferAdd
    },
    props: {
        activeTab: String,
        id: Number,
    },
    emits: ["update:activeTab"],
    setup(props, context) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const offers = ref([]);
        const user = window.Laravel.user;
        const values = require('../../../json/offer_values.json');
        const offer_id = ref();

        const switchTab = () => {
            context.emit("update:activeTab", 'addingoffer');
        }

        const editOffer = async(edit_offer_id) => {
            emitter.emit('changeToEditOffer', {edit_offer_id: edit_offer_id});
        }

        const getOffersRepositories = async () => {
            offers.value = GetOffers(props.id);
        }

        const publishOffer = async(offer) => {
            axios.post('/api/offer/publish', {id: offer.id})
                .then(response => {
                    if (response.data.success) {
                        offer.status = 1;
                        toast.success('Oferta zostało opublikowane');
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const deleteOffer = async(id) => {
            axios.post('/api/offer/delete', {id: id})
                .then(response => {
                    console.log(id + '-> id offer delete')
                    console.log(response.data + '->response.data');
                    if (response.data.success) {
                        toast.success(response.data.message);
                    } else {
                    }
                })
           await getOffersRepositories('');

        }

        // const getOffers = () => {
        //     axios.post('/api/offer/get/all', {})
        //         .then(response => {
        //             if (response.data.success) {
        //                 offers.value = response.data.payload;
        //                 console.log(response.data.payload + ' -> OFFERS VALUE')
        //             } else {
        //                 // toast.error(response.data.message);
        //             }
        //         })
        // };

        onMounted(() => {
            // getOffers();
            getOffersRepositories('');
        });

        return {
            deleteOffer,
            offer_id,
            editOffer,
            publishOffer,
            switchTab,
            offers,
            user,
            values
        }
    }
}
</script>

<style scoped>

</style>
