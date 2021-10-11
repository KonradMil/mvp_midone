<template>
    <div class="intro-y col-span-9 lg:col-span-9 xxl:col-span-9" v-if="guard === true">
        <div class="intro -y flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">{{$t('challengesMain.myOffers')}}</h2>
        </div>
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <transition-group name="fade">
                <div class="intro-y box col-span-6 xxl:col-span-6" v-for="offer in offers.list" :key="offer.id">
                    <div :class="(offer.rejected === 1) ? 'px-5 py-5 opacity-50' : 'px-5 py-5'">
                    <div id="latest-tasks-new" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                        <div class="flex items-center">
                            <div class="pl-4 my-2">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.solution')}}</span>
                                <div class="ark:text-theme-10 text-theme-1 pt-1" style="font-size: 16px; word-break: break-all; max-height: 100px; max-width: 200px;"> {{ offer.solution.name }}</div>
                            </div>
                            <div class="mt-2 pl-9 pb-6 md:flex" v-if="(user.id === offer.installer_id) || addSolutionOffer">
                                <button class="btn btn-primary shadow-md mr-2" @click="publishOffer(offer)" v-if="offer.status < 1">{{$t('challengesMain.publishOffer')}}</button>
                                <button class="btn btn-primary shadow-md mr-2" @click="editOffer(offer.id)" v-if="stage !== 3 && offer.status < 1">{{$t('models.edit')}}</button>
                                <button class="btn btn-primary shadow-md mr-2" @click="changeOffer(offer.id)" v-if="stage === 3 && user.id === offer.installer_id">Zmiana oferty</button>
                                <button class="btn btn-primary shadow-md mr-2" @click.prevent="deleteOffer(offer)" v-if="offer.status < 1 || offer.rejected == 1">{{$t('models.delete')}}</button>
                            </div>
                            <div v-if="stage===3">
                            <div class="flex items-center justify-center text-theme-9" v-if="project.project_accept_offer === 1 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.accepted')}}</div>
                            <div class="flex items-center justify-center text-theme-6" v-if="project.project_accept_offer === 2 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.rejected')}}</div>
                            <div class="flex items-center mr-3" v-if="project.project_accept_offer < 1 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.waitingApproval')}}</div>
                            </div>
                            <div class="" v-if="user.id === challenge_author_id && stage === 3">
                                  <button class="btn btn-primary shadow-md mr-2" style="margin-left: 90px;" @click.prevent="acceptProjectOffer">Akceptuje</button>
                                  <button class="btn btn-primary shadow-md mr-2" @click.prevent="rejectProjectOffer">Odrzucam</button>
                            </div>
                            <div class="flex items-center justify-center text-theme-9" v-if="offer.selected == 1 && stage !== 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.accepted')}}</div>
                            <div class="flex items-center justify-center text-theme-6" v-if="offer.rejected == 1"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.rejected')}}</div>
                            <div class="flex items-center mr-3" v-if="(offer.rejected != 1) && (offer.selected != 1) && (offer.status == 1) && stage !== 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.waitingApproval')}}</div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.offerExpires')}}:</span>
                                <div class="text-gray-600"> {{ offer.offer_expires_in }} dni</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceDelivery')}}:</span>
                                <div class="text-gray-600"> {{ offer.price_of_delivery }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.weeksToStart')}}:</span>
                                <div class="text-gray-600"> {{ values['weeks'][offer.weeks_to_start] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToStart')}}:</span>
                                <div class="text-gray-600"> {{ values['weeks-short'][offer.time_to_start] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.timeToFix')}}:</span>
                                <div class="text-gray-600"> {{ values['hours'][offer.time_to_fix] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponAgreement')}}:</span>
                                <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_agreement] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponDelivery')}}:</span>
                                <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_delivery] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.advanceUponStart')}}:</span>
                                <div class="text-gray-600"> {{ values['percent'][offer.advance_upon_start] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.yearsGuarantee')}}:</span>
                                <div class="text-gray-600"> {{ values['years-short'][offer.years_of_guarantee] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.maintenanceFrequency')}}:</span>
                                <div class="text-gray-600"> {{ offer.maintenance_frequency }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.priceMaintenance')}}:</span>
                                <div class="text-gray-600"> {{ offer.price_of_maintenance }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.reactionTime')}}:</span>
                                <div class="text-gray-600"> {{ values['hours'][offer.reaction_time] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.interventionPrice')}}:</span>
                                <div class="text-gray-600"> {{ offer.intervention_price }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.workHourPrice')}}:</span>
                                <div class="text-gray-600"> {{ offer.work_hour_price }}zł</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">{{$t('challengesMain.periodSupport')}}:</span>
                                <div class="text-gray-600"> {{ offer.period_of_support }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </transition-group>
            <!-- END: Announcement -->
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref, watch} from "vue";
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
        addSolutionOffer: Boolean,
        selected_offer_id: Number,
        stage: Number,
        author_id: Number,
        challenge_author_id: Number,
        project: Object
    },
    emits: ["update:activeTab"],

    setup(props, context) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const offers = ref([]);
        const user = window.Laravel.user;
        const values = require('../../../json/offer_values.json');
        const offer_id = ref();
        const guard = ref(false);
        const change = ref(false);
        const is_done_offer = ref(false);

        watch(() => offers.value.list, (first, second) => {
        }, {})

        const switchTab = () => {
            context.emit("update:activeTab", 'addingoffer');
        }

        const editOffer = async(edit_offer_id) => {
            emitter.emit('changeToEditOffer', {edit_offer_id: edit_offer_id});
        }

        const changeOffer = async(edit_offer_id) => {
            emitter.emit('changeOfferProject', {edit_offer_id: edit_offer_id, change: change});
        }

        const noChangeOffer = async() => {
            emitter.emit('noChangeOfferProject', {is_done_offer: is_done_offer});
        }

        const getOffersRepositories = async (callback) => {
            offers.value = GetOffers(props.id);
            callback();
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

        const deleteOffer = async(offer) => {
            axios.post('/api/offer/delete', {id: offer.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success(response.data.message);
                        offers.value.list.splice(offers.value.list.indexOf(offer), 1);
                    } else {
                    }
                })
        }

        const acceptProjectOffer = async () => {
            axios.post('/api/projects/project-offer/accept', {id: props.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zaakceptowałeś oferte');
                        emitter.emit('acceptOffer', {});
                    } else {

                    }
                })
        }
        const rejectProjectOffer = async () => {
            axios.post('/api/projects/project-offer/reject', {id: props.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Odrzuciłeś oferte');
                        emitter.emit('rejectOffer', {});
                    } else {

                    }
                })
        }


        onMounted(() => {
            getOffersRepositories(function(){

                guard.value = true;
            });
            if(props.stage === 3){
                change.value = true;
            }
        });

        return {
            rejectProjectOffer,
            acceptProjectOffer,
            noChangeOffer,
            is_done_offer,
            changeOffer,
            change,
            guard,
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

.fade-leave-from {
    opacity: 1;
    transform: scale(1);
}
.fade-leave-to {
    opacity: 0;
    transform: scale(0.6);
}
.fade-leave-active {
    transition: all 0.4s ease;
}

</style>
