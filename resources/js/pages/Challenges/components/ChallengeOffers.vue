<template>
    <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9" v-if="guard === true">
        <div class="flex box items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
           <h2 class="intro-y font-medium text-base mr-auto"> Moje oferty </h2>
       </div>
        <div class="flex items-center px-5 py-7 border-b border-gray-200 dark:border-dark-5 mt-2" v-if="offers.length > 0 || (technologyType !== null || filterType !== null)">
            <label for="input-wizard-5" class="form-label pr-5 font-medium dark:text-theme-10 text-theme-1" style="position: absolute; margin-bottom: 90px;">Filtr</label>
            <Multiselect
                @select="StartFilterOffer"
                :disabled="technologyType !== null"
                class="form-control"
                v-model="filterType"
                mode="single"
                label="name"
                max="1"
                :placeholder="filterType === null ? 'Wybierz...' : filterType"
                :close-on-select="false"
                :clear-on-select="false"
                :preserve-search="true"
                :preselect-first="true"
                valueProp="value"
                :options="filters['options']"
            />
        </div>
        <div class="flex items-center px-5 py-7 border-b border-gray-200 dark:border-dark-5 pb-10" v-if="offers.length > 0 || (technologyType !== null || filterType !== null)">
            <label for="input-wizard-5" class="form-label font-medium dark:text-theme-10 text-theme-1" style="position: absolute; margin-bottom: 90px;">Dostawca głównej technologii</label>
            <Multiselect
                @select="StartFilterOffer"
                :disabled="filterType !== null"
                class="form-control"
                v-model="technologyType"
                mode="single"
                label="name"
                max="1"
                :placeholder="technologyType === null ? 'Wybierz...' : technologyType"
                :show-labels="false"
                :preselect-first="true"
                valueProp="value"
                :options="technology['options']"
                :option-height="104"
            />
        </div>
        <div v-if="offers.length < 1 && (technologyType !== null && filterType !== null)" class="intro-y box w-full text-theme-1 dark:text-theme-10 font-medium pl-5 py-3" style="font-size: 16px;">
            Nie ma ofert spełniających podane kryteria.
        </div>
        <div v-if="offers.length < 1 && (technologyType === null || filterType === null)" class="intro-y box w-full text-theme-1 dark:text-theme-10 font-medium pl-5 py-3" style="font-size: 16px;">
            Nie masz jeszcze żadnych ofert.
        </div>
        <div class="grid grid-cols-12 gap-6" v-if="offers.length > 0">
            <!-- BEGIN: Announcement -->
            <div  v-for="(offer, index) in offers" :key="index" class="col-span-12 col-span-12 xxl:col-span-6">
                <div :class="(offer.id === theBestOffer.id && (filterType === 'Ranking' || filterType === null) && technologyType === null) ? 'best-offer': ''">
                <div class="intro-y box"  v-if="challenge.selected_offer_id < 1 || offer.selected == 1">
                    <div class="px-5 py-5" >
                        <div id="latest-tasks-new" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                            <div class="flex items-center">
                                <div class="pb-2">
                                <span class="numberCircle clrGreen" v-if="filterType !== null || technologyType !== null"><span>{{ index + 1}}
                            </span></span>
                                </div>
                                <div class="flex items-center justify-left text-theme-20 font-black text-2xl" v-if="offer.id === theBestOffer.id && (filterType === 'Ranking' || filterType === null) && technologyType ===null"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>Najlepsza oferta</div>
                            </div>
                            <div class="flex items-center">
                                <div class="pl-4 my-2">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">Rozwiązanie</span>
                                    <div class="ark:text-theme-10 text-theme-1 pt-1" style="font-size: 16px; word-break: break-all; max-height: 100px; max-width: 200px;"> {{ offer.solution.name }}</div>
                                </div>
                                <div class="mt-2 pl-9 pb-6 md:flex" v-if="inTeam">
                                    <Tippy
                                        tag="a"
                                        href=""
                                        class="dark:text-gray-300 text-gray-600"
                                        content="Po zaakceptowaniu oferty staje się ona wiążąca dla obu stron.">
                                    <button class="btn btn-primary shadow-md mr-2" @click.prevent="acceptOffer(offer)" v-if="offer.status === 1 && challenge.selected_offer_id < 1 && acceptChallengeOffers">Akceptuj ofertę</button>
                                    </Tippy>
                                    <button class="btn shadow-md mr-2 bg-gray-400" @click.prevent="showModalRejectOffer(offer,index)" v-if="offer.status === 1 && challenge.selected_offer_id < 1 && acceptChallengeOffers" >Odrzuć ofertę</button>
                                    <button class="btn btn-outline-secondary" @click="showDetails[offer.id] = !showDetails[offer.id]">{{$t('teams.details')}}</button>
                                </div>
                                <div class="flex items-center justify-center text-theme-9" v-if="offer.status === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Zaakceptowano </div>
                            </div>
                            <div class="flex items-center mt-5" v-if="showDetails[offer.id] !== true && (filterType === 'Cene malejąco' || filterType === 'Cena rosnąco')">
                                <div class="border-2 border-theme-1 p-2">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceDelivery')}}:</span>
                                    <div class="text-gray-600"> {{ offer.price_of_delivery }}</div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5" v-if="showDetails[offer.id] !== true && filterType === 'Czas realizacji uruchomienia u klienta'">
                                <div class="border-2 border-theme-1 p-2">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToStart')}}:</span>
                                    <div class="text-gray-600"> {{ values['weeks-short'][offer.time_to_start] }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5" v-if="showDetails[offer.id] !== true && filterType === 'Okres gwarancji stanowiska od integratora'">
                                <div class="border-2 border-theme-1 p-2'">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.yearsGuarantee')}}:</span>
                                    <div class="text-gray-600"> {{ values['years-short'][offer.years_of_guarantee] }} </div>
                                </div>
                            </div>
                            <div class="intro-y" v-if="showDetails[offer.id] === true">
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.offerExpires')}}:</span>
                                    <div class="text-gray-600"> {{ offer.offer_expires_in }} dni</div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div :class="(filterType === 'Cene malejąco' || filterType === 'Cena rosnąco') ? 'border-2 border-theme-1 p-2' : 'border-l-2 border-theme-1 pl-4'">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceDelivery')}}:</span>
                                    <div class="text-gray-600"> {{ offer.price_of_delivery }}</div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.weeksToStart')}}:</span>
                                    <div class="text-gray-600"> {{ values['weeks'][offer.weeks_to_start] }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div :class="(filterType === 'Czas realizacji uruchomienia u klienta') ? 'border-2 border-theme-1 p-2' : 'border-l-2 border-theme-1 pl-4'">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToStart')}}:</span>
                                    <div class="text-gray-600"> {{ values['weeks-short'][offer.time_to_start] }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToFix')}}:</span>
                                    <div class="text-gray-600"> {{ values['hours'][offer.time_to_fix] }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponStart')}}:</span>
                                    <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_start] }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponDelivery')}}:</span>
                                    <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_delivery] }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponAgreement')}}:</span>
                                    <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_agreement] }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div :class="(filterType === 'Okres gwarancji stanowiska od integratora') ? 'border-2 border-theme-1 p-2' : 'border-l-2 border-theme-1 pl-4'">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.yearsGuarantee')}}:</span>
                                    <div class="text-gray-600"> {{ values['years-short'][offer.years_of_guarantee] }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesNew.numberSupported')}}:</span>
                                    <div class="text-gray-600"> {{offer.service_support_scope }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.maintenanceFrequency')}}:</span>
                                    <div class="text-gray-600"> {{ offer.maintenance_frequency }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceMaintenance')}}:</span>
                                    <div class="text-gray-600"> {{ offer.price_of_maintenance }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.reactionTime')}}:</span>
                                    <div class="text-gray-600"> {{ values['hours'][offer.reaction_time] }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.interventionPrice')}}:</span>
                                    <div class="text-gray-600"> {{ offer.intervention_price }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.workHourPrice')}}:</span>
                                    <div class="text-gray-600"> {{ offer.work_hour_price }} </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-5">
                                <div class="border-l-2 border-theme-1 pl-4">
                                    <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.periodSupport')}}:</span>
                                    <div class="text-gray-600"> {{ offer.period_of_support }} </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <ModalRejectOffer :show="show" @closed="modalClosed">
        <h3 class="intro-y text-lg font-medium mt-5">Dodaj komentarz dlaczego odrzucasz ofertę!</h3>
        <div class="intro-y box p-5 mt-12 sm:mt-5" style="text-align: center;">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                <textarea
                    maxlength = "1000"
                    class="w-full px-3 py-2 text-gray-700 border rounded-lg border border-transparent outline-none ring-2 ring-pink-700 border-transparent"
                    style="width: 600px; height: 100px; position: relative;"
                    v-model="feedback"/>
                <div class="flex pt-2" style="margin-left: 210px;">
                    <button class="btn btn-primary shadow-md mr-2" @click.prevent="rejectChallengeOffer">Odrzuć</button>
                    <button class="btn btn-primary shadow-md mr-2" @click.prevent="modalClosed">Anuluj</button>
                </div>
            </div>
        </div>
    </ModalRejectOffer>
</template>

<script>
import {getCurrentInstance, onMounted, ref, watch} from "vue";
import {useToast} from "vue-toastification";
import router from "../../../router";
import Multiselect from '@vueform/multiselect';
import DarkModeSwitcher from "../../../components/dark-mode-switcher/Main";
import RequestHandler from "../../../compositions/RequestHandler";
import ModalRejectOffer from "../../../components/ModalRejectOffer";


export default {
    components: {
        ModalRejectOffer,
        Multiselect
    },
    name: "ChallengeOffers",
    props: {
        challenge: Object,
        activeTab: String,
        inTeam: Boolean,
        acceptChallengeOffers: Boolean
    },
    emits: ["update:activeTab"],
    setup(props, context) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        let offers = ref([]);
        const user = window.Laravel.user;
        const values = require('../../../json/offer_values.json');
        const filters = require('../../../json/offer_filters.json');
        const technology = require('../../../json/technology_filters.json');
        const solution = ref();
        const check = ref(false);
        const filterType = ref(null);
        const technologyType = ref(null);
        const theBestOffer = ref('');
        const guard = ref(false);
        const show = ref(false);
        const temporary_offer_id = ref(null);
        const showDetails = ref([]);
        const isShow = ref(false);
        const feedback = ref('');
        const isOffers = ref(false);
        const currentOffer = ref({});

        const showModalRejectOffer = async(offer,index) =>{
            show.value = true;
            currentOffer.value = offer;
        }

        const modalClosed = () => {
            show.value = !show.value
        }

        watch(()=> offers.value, ()=>{
            console.log('offers.value.length')
            console.log(offers.value.length)
        })

        watch(()=> technologyType.value, ()=>{
            if(technologyType.value === null && filterType.value === null){
                getChallengeOffersRepositories();
            }
        },{})

        watch(()=> filterType.value, ()=>{
            if(filterType.value === null && technologyType.value === null){
                getChallengeOffersRepositories();
            }
        },{})

        const switchTab = () => {
            context.emit("update:activeTab", 'addingoffer');
        }

        const getChallengeOffersRepositories = async (callback) => {
            RequestHandler('offer/' + props.challenge.id + '/offers', 'get', {}, (response) => {
                offers.value = response.data.offers;
                callback();
            });
        }


        const StartFilterOffer = async () => {
            axios.post('/api/offer/user/filter', {option: filterType.value , id: props.challenge.id, technologyType: technologyType.value})
                .then(response => {
                    if (response.data.success) {
                            setTimeout(offers.value = response.data.payload,500)
                    } else {
                        toast.error('Error');
                    }
                })
        }

        const GetTheBestOffer = async () => {
            axios.post('/api/offer/get/best', {id: props.challenge.id})
                .then(response => {
                    if (response.data.success) {
                        theBestOffer.value = response.data.payload;
                    } else {

                    }
                })
        }

        const goTo = () => {
                router.push({ path: '/projects' })
            }

        const acceptOffer = async(offer) => {
            axios.post('/api/offer/accept', {id: offer.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Oferta została zaakceptowane');
                        offer.selected = 1;
                        offer.rejected = 0;
                        offer.solution.selected_offer_id = offer.id;
                        props.challenge.selected_offer_id = offer.id;
                        goTo();
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const rejectChallengeOffer = async () => {
            RequestHandler('offer/' + props.challenge.id + '/reject', 'post', {offer_id: currentOffer.value.id, comment: feedback.value}, (response) => {
                offers.value.splice(offers.value.indexOf(currentOffer),1);
                modalClosed();
                feedback.value = '';
            });
        }

        // const rejectChallengeOffer = async() => {
        //     axios.post('/api/offer/reject', {id: currentOffer.value.id})
        //         .then(response => {
        //             if (response.data.success) {
        //                 toast.success('Oferta została odrzucona');
        //                 currentOffer.value.rejected = 1;
        //                 currentOffer.value.selected = 0;
        //                 currentOffer.value.solution.selected_offer_id = 0;
        //                 if(currentOffer.value.id === props.challenge.selected_offer_id){
        //                     props.challenge.selected_offer_id = 0;
        //                 }
        //                 offers.value.splice(offers.value.indexOf(currentOffer),1);
        //             } else {
        //             }
        //         })
        // }
        const filter = async() => {
            await StartFilterOffer();
        }

        const Initialize = async() =>{
            await  getChallengeOffersRepositories(()=>{
                guard.value = true;
            });
            await  GetTheBestOffer();
        }

        onMounted(() => {
            Initialize();
        });

        return {
            currentOffer,
            showModalRejectOffer,
            isOffers,
            GetTheBestOffer,
            getChallengeOffersRepositories,
            feedback,
            modalClosed,
            goTo,
            isShow,
            temporary_offer_id,
            showDetails,
            show,
            guard,
            theBestOffer,
            StartFilterOffer,
            filterType,
            check,
            rejectChallengeOffer,
            acceptOffer,
            switchTab,
            offers,
            user,
            values,
            filters,
            solution,
            technology,
            technologyType
        }
    }
}
</script>

<style scoped>

</style>
