<template>
<!--    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">-->
<!--        <div class="grid grid-cols-12 gap-6">-->
<!--            &lt;!&ndash; BEGIN: Announcement &ndash;&gt;-->
<!--            <div class="intro-y box col-span-12 xxl:col-span-12">-->
<!--                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">-->
<!--                    <h2 class="font-medium text-base mr-auto"> Wszystkie oferty</h2>-->
<!--                </div>-->
<!--                <div class="px-5 pt-5">-->
<!--                    <div v-if="offers.length == 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">-->
<!--                        <div v-if="user.type == 'integrator'">-->
<!--                            <p>-->
<!--                                W tej chwili nie masz żadnych ofert.-->
<!--                            </p>-->
<!--                        </div>-->

<!--                    </div>-->
<!--                                        <div class="intro-y grid grid-cols-12 gap-6 mt-5">-->
<!--                                            <div v-for="(solution, index) in challenge.solutions" :key="index"-->
<!--                                                 class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box" :class="(solution.selected)? 'solution-selected': ''">-->
<!--                                                <div v-if="!solution.rejected">-->
<!--                                                    <div v-if="user.type == 'integrator'">-->
<!--                                                        <SingleSolutionPost v-if="solution.author_id === user.id" :user="user" :solution="solution" :canAccept="user.id === challenge.author_id" :canEdit="user.id === solution.author_id"></SingleSolutionPost>-->
<!--                                                    </div>-->
<!--                                                    <div v-if="user.type == 'investor'">-->
<!--                                                        <SingleSolutionPost v-if="solution.status === 1" :user="user" :solution="solution" :canAccept="user.id === challenge.author_id" :canEdit="user.id === solution.author_id"></SingleSolutionPost>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
        <h2 class="intro-y font-medium text-base mr-auto"> Moje oferty </h2>
    </div>
        <div class="flex items-center px-5 py-7 border-b border-gray-200 dark:border-dark-5">
            <label for="input-wizard-5" class="form-label pr-5 font-medium dark:text-theme-10 text-theme-1" style="position: absolute; margin-bottom: 90px;">Filtr</label>
            <Multiselect
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
        <div class="flex items-center px-5 py-7 border-b border-gray-200 dark:border-dark-5 pb-10">
            <label for="input-wizard-5" class="form-label font-medium dark:text-theme-10 text-theme-1" style="position: absolute; margin-bottom: 90px;">Dostawca głównej technologii</label>
            <Multiselect
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
        <div v-if="guard && (filterType !== null || technologyType !== null)" class="intro-y w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
            Nie ma ofert spełniających podane kryteria.
        </div>
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div  v-for="(offer, index) in offers.list" :key="index" class="col-span-12 col-span-12 xxl:col-span-6">
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
                                    <button class="btn btn-primary shadow-md mr-2" @click.prevent="acceptOffer(offer)" v-if="offer.selected != 1 && challenge.selected_offer_id < 1 && acceptChallengeOffers">Akceptuj ofertę</button>
                                    </Tippy>
                                    <button class="btn shadow-md mr-2 bg-gray-400" @click.prevent="rejectOffer(offer,index)" v-if="offer.rejected != 1 && challenge.selected_offer_id < 1 && acceptChallengeOffers" >Odrzuć ofertę</button>
                                    <button class="btn btn-outline-secondary" @click="showDetails[offer.id] = !showDetails[offer.id]">{{$t('teams.details')}}</button>
                                </div>
                                <div class="flex items-center justify-center text-theme-9" v-if="offer.selected == 1"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Zaakceptowano </div>
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
</template>

<script>
import {getCurrentInstance, onMounted, ref, watch} from "vue";
import GetChallengeOffers from "../../../compositions/GetChallengeOffers";
import {useToast} from "vue-toastification";
import router from "../../../router";
import Multiselect from '@vueform/multiselect';
import DarkModeSwitcher from "../../../components/dark-mode-switcher/Main";


export default {
    components: {
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
        const offers = ref([]);
        const user = window.Laravel.user;
        const values = require('../../../json/offer_values.json');
        const filters = require('../../../json/offer_filters.json');
        const technology = require('../../../json/technology_filters.json');
        const solution = ref();
        const check = ref(false);
        const filterType = ref(null);
        const technologyType = ref(null);
        const theBestOffer = ref('');
        const guard = ref();
        const show = ref(false);
        const temporary_offer_id = ref(null);
        const showDetails = ref([]);
        const isShow = ref(false);

        watch(() => offers.value.list, (first, second) => {
        }, {})

        watch(() => technologyType.value, (first, second) => {
            console.log(offers.value.list.length + 'length offervs value list technology')
            StartFilterOffer();
            if(technologyType.value !== null){
                if(offers.value.list ===0){
                    guard.value = true;
                }else{
                    guard.value = false;
                }
            }

            if(filterType.value === null && technologyType.value === null){
                getChallengeOffersRepositories();
                GetTheBestOffer();

            }
        }, {})

        watch(() => filterType.value, (first, second) => {
            console.log(offers.value.list.length + 'length offervs value list filterType')
            StartFilterOffer();
            if(offers.value.list ===0){
                guard.value = true;
            }else{
                guard.value = false;
            }
            if(filterType.value === null && technologyType.value === null){
                getChallengeOffersRepositories();
                GetTheBestOffer();
            }
            if(filterType.value==='Cena malejąco' || filterType.value==='Cena rosnąco'
                || filterType.value==='Czas realizacji uruchomienia u klienta' || filterType.value==='Okres gwarancji stanowiska od integratora'){
                isShow.value = true;
            }
        }, {})

        const switchTab = () => {
            context.emit("update:activeTab", 'addingoffer');
        }

        const getChallengeOffersRepositories = async () => {
            offers.value = GetChallengeOffers(props.challenge.id);
            if(offers.value.list.length < 1){
                guard.value = 1;
            }else{
                guard.value = 0;
            }
        }



        const StartFilterOffer = async () => {
            axios.post('/api/offer/user/filter', {option: filterType.value , id: props.challenge.id, technologyType: technologyType.value})
                .then(response => {
                    if (response.data.success) {
                        offers.value.list = response.data.payload;
                        if(offers.value.list.length === 0){
                            guard.value = true;
                        }

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

        const handleCallback = () => {

            router.push( {path : '/projects/card/' + props.challenge.id});
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

        const rejectOffer = async(offer,index) => {
            axios.post('/api/offer/reject', {id: offer.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Oferta została odrzucona');
                        offer.rejected = 1;
                        offer.selected = 0;
                        offer.solution.selected_offer_id = 0;
                        if(offer.id === props.challenge.selected_offer_id){
                            props.challenge.selected_offer_id = 0;
                        }
                        offers.value.list.splice(index,1);
                        // const offerIndex = offers.value.list.findIndex(a => a.id === offer.id);
                        // if (offerIndex !== -1) {
                        //     offers.value.list.splice(offerIndex,1);
                        // }
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        onMounted(() => {
            getChallengeOffersRepositories('');
            GetTheBestOffer();
        });

        return {
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
            rejectOffer,
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
