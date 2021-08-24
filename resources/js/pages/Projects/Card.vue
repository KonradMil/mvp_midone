<template>
    <div>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Projekt</h2>
        </div>
        <div class="wizard flex flex-col lg:flex-row justify-center px-5 sm:px-20">
            <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full btn btn-primary">1</button>
                <div class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto">Inicjowanie projektu</div>
            </div>
            <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full btn text-gray-600 bg-gray-200 dark:bg-dark-1" @click="showModal">2</button>
                <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">Planowanie projektu</div>
            </div>
            <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full btn text-gray-600 bg-gray-200 dark:bg-dark-1">3</button>
                <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">Realizacja projektu zgodnie z ofertą</div>
            </div>
            <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full btn text-gray-600 bg-gray-200 dark:bg-dark-1">4</button>
                <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">Zamykanie projektu</div>
            </div>
            <div class="wizard__line hidden lg:block w-2/3 bg-gray-200 dark:bg-dark-1 absolute mt-5"></div>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box mt-5 lg:mt-0">
                    <div class="relative flex items-center p-5">
                        <div class="w-12 h-12 image-fit">
                            <img v-if="challenge.screenshot_path != undefined" class="rounded-full" :alt="challenge.name" :src="'/' + challenge.screenshot_path"/>
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="font-medium text-base">
                                {{ challenge.name }} <span class="text-theme-1 dark:text-theme-10" v-if="challenge.status == 0"> - Szkic</span>
                            </div>
                            <div class="text-gray-600">{{ types[challenge.type] }}</div>
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="text-gray-600">Karta bez zmian</div>
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="text-gray-600">Zmiana karty</div>
                        </div>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon"> <i data-feather="home"></i> </div>
                        <div class="menu__title">
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                                Startowa karta projektu
                            <i data-feather="chevron-down" class="menu__sub-icon"></i>
                        </div>
                    </a>
                    <ul class="">
                        <li>
                            <a class="flex items-center"
                               href=""
                               @click.prevent="activeTab = 'podstawowe'"
                               :class="(activeTab == 'podstawowe')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                                <ActivityIcon class="w-4 h-4 mr-2"/>
                                {{$t('challengesMain.basicInformation')}}
                            </a>
                        </li>
                        <li>
                            <a class="flex items-center mt-5" href=""
                               @click.prevent="activeTab = 'techniczne'"
                               :class="(activeTab == 'techniczne')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                <BoxIcon class="w-4 h-4 mr-2"/>
                                {{$t('challengesMain.technicalDetails')}}                        </a>
                        </li>
                        <li>
                            <a class="flex items-center mt-5" href="" v-if="challenge != undefined"
                               @click.prevent="activeTab = 'rozwiazania'"
                               :class="(activeTab == 'rozwiazania')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                <LockIcon class="w-4 h-4 mr-2"/>
                                <div v-if="challenge.selected != undefined && challenge.selected.length != 0">{{$t('challengesMain.solutions')}}</div><div v-if="challenge.selected == undefined || challenge.selected.length == 0">{{$t('challengesMain.solutions')}}
                            </div>
                            </a>
                        </li>
                        <li>
                            <a v-if="!inTeam && challenge.stage >= 1"
                               class="flex items-center mt-5" href=""
                               @click.prevent="activeTab = 'oferty'"
                               :class="(activeTab == 'oferty')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                <SettingsIcon class="w-4 h-4 mr-2"/>
                                {{$t('challengesMain.myOffers')}}
                            </a>
                        </li>
                        <li>
                            <a v-if="inTeam && challenge.stage >= 1"
                               class="flex items-center mt-5" href=""
                               @click.prevent="activeTab = 'all-offers'"
                               :class="(activeTab == 'all-offers')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                <SettingsIcon class="w-4 h-4 mr-2"/>
                                {{$t('challengesMain.offers')}}
                            </a>
                        </li>
                        <li>
                            <a class="flex items-center mt-5" href=""
                               @click.prevent="activeTab = 'pytania'"
                               :class="(activeTab == 'pytania')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                <SettingsIcon class="w-4 h-4 mr-2"/>
                                {{$t('communication.questions')}}
                            </a>
                        </li>
                        <li>
                            <a v-if="challenge.stage === 3"
                               class="flex items-center mt-5" href=""
                               @click.prevent="activeTab = 'operational-analysis'"
                               :class="(activeTab == 'operational-analysis')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                <SettingsIcon class="w-4 h-4 mr-2"/>
                                Analiza operacyjna rozwiązania
                            </a>
                        </li>
                        <li>
                            <a v-if="challenge.stage === 3"
                               class="flex items-center mt-5" href=""
                               @click.prevent="activeTab = 'financial-analysis'"
                               :class="(activeTab == 'financial-analysis')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                <SettingsIcon class="w-4 h-4 mr-2"/>
                                Analiza finansowa rozwiązania
                            </a>
                        </li>
                        <li>
                            <a v-if="challenge.stage === 3"
                               class="flex items-center mt-5" href=""
                               @click.prevent="activeTab = 'financial-analysis'"
                               :class="(activeTab == 'financial-analysis')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                <SettingsIcon class="w-4 h-4 mr-2"/>
                                Analiza finansowa rozwiązania
                            </a>
                        </li>
                        <li>
                            <div class="p-5 border-t border-gray-200 dark:border-dark-5" v-if="(challenge.author_id == user.id)">
                                <a class="flex items-center" href=""
                                   @click.prevent="activeTab = 'teams'"
                                   :class="(activeTab == 'teams')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                                    <ActivityIcon class="w-4 h-4 mr-2"/>
                                    {{$t('teams.teams')}}
                                </a>
                            </div>
                        </li>
                    </ul>
                 </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex" v-if="inTeam">
                        <button type="button" class="btn btn-primary py-1 px-2" v-if="challenge.solutions.length == 0 && editChallenges" @click="$router.push({name: 'addChallenge', params: {challenge_id: challenge.id }});">
                            {{$t('models.edit')}}
                        </button>
                        <button type="button" class="btn btn-primary py-1 px-2 ml-2" @click="$router.push({name: 'challengeStudio', params: {id: challenge.id, type: 'challenge', load: challenge, publishChallenges: publishChallenges}})">
                            Studio 3D
                        </button>
                        <button
                            v-if="challenge.status == 0 && publishChallenges"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click="publish(challenge.id)">
                            {{$t('challengesMain.publish')}}
                        </button>
                        <button
                            v-if="challenge.status == 1 && challenge.solutions.length == 0 && publishChallenges"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click="unpublish(challenge.id)">
                            {{$t('challengesMain.unpublish')}}
                        </button>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex" v-if="!inTeam && user.type == 'integrator'">
                        <button type="button" class="btn btn-primary py-1 px-2 ml-2" @click="$router.push({name: 'challengeStudio', params: {id: challenge.id, publishChallenges: publishChallenges ,type: 'challenge', load: challenge, readOnly: true}})">
                            Studio 3D
                        </button>
                        <button v-if="challenge.stage == 1"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click.prevent="addSolution">
                            {{$t('challengesMain.addSolution')}}
                        </button>
                    </div>
                </div>
                <WhatsNext :user="user" :challenge="challenge" :solutions="challenge.solutions"></WhatsNext>
            </div>
            <!-- END: Profile Menu -->
            <BasicInformationPanel :challenge="challenge" :inTeam="inTeam" v-if="activeTab == 'podstawowe'"></BasicInformationPanel>
            <TechnicalInformationPanel :challenge="challenge" v-if="activeTab == 'techniczne'"></TechnicalInformationPanel>
            <QuestionsPanel v-if="activeTab == 'pytania'" :author_id="challenge.author_id" :id="challenge.id" :challenge_stage="challenge.stage"></QuestionsPanel>
            <SolutionsPanel v-if="activeTab == 'rozwiazania'" :challenge="challenge" :inTeam="inTeam" :addChallengeSolution="addChallengeSolution" :acceptChallengeSolutions="acceptChallengeSolutions" :publishSolution="publishSolution" :addSolutionOffer="addSolutionOffer"></SolutionsPanel>
            <TeamsPanel v-if="(activeTab == 'teams') && ((challenge.author_id == user.id) || (solution.author_id == user.id))" :solution="solution" :challenge="challenge" :who="who" ></TeamsPanel>
            <OfferAdd v-if="activeTab == 'addingoffer'" :solution_id="selected_solution_id" :challenge_id="challenge.id" :edit_offer_id="edit_offer_id"></OfferAdd>
            <Offers v-if="activeTab == 'oferty'" v-model:activeTab="activeTab" :id="challenge.id" :inTeam="inTeam" :addSolutionOffer="addSolutionOffer" :selected_offer_id="challenge.selected_offer_id"></Offers>
            <ChallengeOffers v-if="(activeTab == 'all-offers') && inTeam" v-model:activeTab="activeTab" :inTeam="inTeam" :challenge="challenge" :acceptChallengeOffers="acceptChallengeOffers"></ChallengeOffers>
            <OperationalAnalysisInformationPanel v-if="activeTab == 'operational-analysis'" :solution="solution_project" ></OperationalAnalysisInformationPanel>
            <FinancialAnalysisInformationPanel v-if="activeTab == 'financial-analysis'" :solution="solution_project" ></FinancialAnalysisInformationPanel>
            <ModalCard :show="show" @closed="modalClosed">
                <h3 class="intro-y text-lg font-medium mt-5">{{ $t('teams.addMember') }}</h3>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div>
                        Zatwierdź
                    </div>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                        <button class="btn btn-primary shadow-md mr-2">Karta bez zmian</button>
                        <button class="btn btn-primary shadow-md mr-2">Zmiana karty</button>
                        </div>
                </div>
            </ModalCard>
        </div>
    </div>
</template>

<script>
import {
    defineComponent,
    ref,
    provide,
    onMounted,
    unref,
    toRaw,
    computed,
    getCurrentInstance,
    onBeforeMount,
    watch
} from "vue";

import GetCardChallenge from "../../compositions/GetCardChallenge";
import WhatsNext from "../Challenges/WhatsNext";
import BasicInformationPanel from "../Challenges/components/BasicInformationPanel";
import TechnicalInformationPanel from "../Challenges/components/TechnicalInformationPanel";
import QuestionsPanel from "../Challenges/components/QuestionsPanel";
import router from "../../router";
import SolutionsPanel from "../Challenges/components/SolutionsPanel";
import {useToast} from "vue-toastification";
import OfferAdd from "../Challenges/components/OfferAdd";
import Offers from "../Challenges/components/Offers";
import TeamsPanel from "../Challenges/components/TeamsPanel";
import ChallengeOffers from "../Challenges/components/ChallengeOffers";
import OperationalAnalysisInformationPanel from "./components/OperationalAnalysisInformationPanel";
import FinancialAnalysisInformationPanel from "./components/FinancialAnalysisInformationPanel";
import ModalCard from "../../components/ModalCard";

export default defineComponent({
    name: 'projectCard',
    components: {
        Offers,
        OfferAdd,
        ChallengeOffers,
        TeamsPanel,
        SolutionsPanel,
        QuestionsPanel,
        TechnicalInformationPanel,
        BasicInformationPanel,
        WhatsNext,
        OperationalAnalysisInformationPanel,
        FinancialAnalysisInformationPanel,
        ModalCard
    },
    props: {
        id: Number,
        change: String
    },
    setup(props, {emit}) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        const announcementRef = ref();
        const newProjectsRef = ref();
        const challenge = ref({});
        const solutions = ref({});
        const permissions = ref({});
        const solution = ref({});
        const questions = ref({});
        const temp_offer_id = ref(null);
        const edit_offer_id = ref(null);
        const activeTab = ref('podstawowe');
        const user = window.Laravel.user;
        // const permissions = window.Laravel.permissions;
        const selected_solution_id = ref(null);
        const types = require("../../json/types.json");
        const who = ref('challenge');
        const inTeam = ref(false);
        const isSolutions = ref(false);
        const isPublic = ref(false);
        const acceptChallengeOffers = ref(false);
        const addChallengeSolution = ref(false);
        const acceptChallengeSolutions = ref(false);
        const publishChallenges = ref(false);
        const editChallenges = ref(false);
        const publishSolution = ref(false);
        const addSolutionOffer = ref(false);
        const solution_project = ref('');
        const show = ref(false);


        watch(() => props.change, (first, second) => {
            if(props.change === 'all-offers' && user.type === 'integrator'){
                activeTab.value = 'oferty';
            }else{
                activeTab.value = props.change;
            }
        }, {})
        emitter.on('selectedSolution', e => {
            selected_solution_id.value = e.id;
            activeTab.value = 'addingoffer';
        });

        emitter.on('changeToEditOffer', e => {
            edit_offer_id.value = e.edit_offer_id;
            activeTab.value = 'addingoffer';
        });

        emitter.on('changeToOffers', e => {
            activeTab.value = 'oferty';
        });

        emitter.on('updateOffers', e => {
            activeTab.value = 'all-offers';
        });

        emitter.on('updateAddSolutionOffer', e => {
            addSolutionOffer.value = e.addSolutionOffer;
        });

        const checkSolution = () => {
             challenge.value.solutions.forEach(function(solution){
                if(solution.selected_offer_id === challenge.value.selected_offer_id){
                    solution_project.value = solution;
                }
             });
        }

        const modalClosed = () => {
            show.value = false;
        }

        const showModal = async() => {
            show.value = !show.value;
            console.log('showwww');
        }

        const filter = () => {
            console.log(challenge.value.solutions + '->  solutions.value');
            challenge.value.solutions.forEach(function (solution) {
                console.log(solution.author_id + 'author_id');
                if(solution.author_id=== user.id) {
                    isSolutions.value = true;
                } else if((solution.published === 1) && (solution.author.id === user.id)) {
                    isPublic.value = true;
                }
            });
        }

        const checkTeam = () => {
            console.log({user_id: user.id, challenge_id: challenge.value.id});
            axios.post('/api/challenge/check-team', {user_id: user.id, challenge_id: challenge.value.id})
                .then(response => {
                    console.log("response.data")
                    console.log(response.data)
                    if (response.data.success) {
                        console.log("user.id");
                        console.log(user.id);
                        console.log(challenge.value.author_id);
                        inTeam.value = response.data.payload || (user.id == challenge.value.author_id);
                    } else {

                    }
                })
        }

        emitter.on('changeTeamsSolution', e => () => {
            console.log('ChangeTeamsSolution');
            activeTab.value = 'teamsSolution'
        });

        emitter.on('*', (type, e) => {
            console.log(type, e);
            console.log('HERE212');
                if(type == 'activeTab') {
                    activeTab.value = e.name;
                    solution.value = e.solution;
                    who.value = e.who;
                }

        } );


        emitter.on('changeToOfferAdd', e => () => {
            console.log('BOLLOCKS');
            activeTab.value = 'addingoffer';
        });

        const handleCallback = () => {
            console.log('checkPermissions' + challenge.value.solutions);
            checkPermissions();
        };

        const getCardChallengeRepositories = async (id) => {
            await axios.post('/api/challenge/user/get/card', {id: id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log(response.data.payload);
                        challenge.value = response.data.payload;
                        checkTeam();
                        filter();
                        checkPermissions();
                        checkSolution();
                    } else {
                        // toast.error(response.data.message);
                    }
                }, handleCallback)
        }

        onMounted(function () {
            permissions.value = window.Laravel.permissions;
            console.log(props);
            getCardChallengeRepositories(props.id);
        })


        provide("bind[announcementRef]", el => {
            announcementRef.value = el;
        });

        provide("bind[newProjectsRef]", el => {
            newProjectsRef.value = el;
        });

        const publish = async(id) => {
            axios.post('/api/challenge/publish', {id: id})
                .then(response => {
                    console.log(response.data)
                    console.log(response.data.success + '-> heeeeeeeeeeere')
                    if (response.data.success) {
                        console.log(response.data.payload);
                        challenge.value = response.data.payload;
                        toast.success('Opublikowano.');
                    } else {
                        // toast.error(response.data.message);
                        toast.error('Błąd.');
                    }
                }).catch(function (error) {
                console.error(error);
            });
        }

        const unpublish = async(id) => {
            axios.post('/api/challenge/unpublish', {id: id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log(response.data.payload);
                        challenge.value = response.data.payload;
                        toast.success('Wyzwanie nie jest już publiczne.');
                    } else {
                        toast.error('Błąd.');
                    }
                })
        }

        const addSolution = () => {
            axios.post('/api/solution/create', {id: challenge.value.id})
                .then(response => {
                    if (response.data.success) {
                        console.log(response.data.payload);
                        router.push({path: '/studio/solution/' + response.data.payload.id});
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        };

        const delete_cookie = ( name, path = '/', domain ) => {
            if( get_cookie( name ) ) {
                document.cookie = name + "=" +
                    ((path) ? ";path="+path:"")+
                    ((domain)?";domain="+domain:"") +
                    ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
            }
        }

        const get_cookie = (name) => {
            return document.cookie.split(';').some(c => {
                return c.trim().startsWith(name + '=');
            });
        }

        const prevAnnouncement = () => {
            const el = announcementRef.value;
            el.tns.goTo("prev");
        };
        const nextAnnouncement = () => {
            const el = announcementRef.value;
            el.tns.goTo("next");
        };
        const prevNewProjects = () => {
            const el = newProjectsRef.value;
            el.tns.goTo("prev");
        };
        const nextNewProjects = () => {
            const el = newProjectsRef.value;
            el.tns.goTo("next");
        };

        const checkPermissions = () => {
            permissions.value.acceptChallengeOffers.forEach(function (permission) {
                if(permission == props.id){
                    acceptChallengeOffers.value = true;
                }
            });
            permissions.value.acceptChallengeSolutions.forEach(function (permission) {
                if(permission == props.id){
                    acceptChallengeSolutions.value = true;
                }
            });
            permissions.value.publishChallenges.forEach(function (permission) {
                if(permission == props.id){
                    publishChallenges.value = true;
                }
            });
            permissions.value.editChallenges.forEach(function (permission) {
                if(permission == props.id){
                    editChallenges.value = true;
                }
            });
            permissions.value.addSolutionOffer.forEach(function (permission) {
                console.log('addSolutionOffer + solutions' + challenge.value.solutions);
                challenge.value.solutions.forEach(function (solution){
                    if(permission == solution.id){
                        addSolutionOffer.value = true;
                    }
                });
            });
            permissions.value.publishSolution.forEach(function (permission) {
                if(permission == props.id){
                    publishSolution.value = true;
                }
            });
        }
        return {
            showModal,
            show,
            modalClosed,
            editChallenges,
            addSolutionOffer,
            publishSolution,
            publishChallenges,
            acceptChallengeSolutions,
            addChallengeSolution,
            acceptChallengeOffers,
            checkPermissions,
            permissions,
            filter,
            edit_offer_id,
            who,
            temp_offer_id,
            selected_solution_id,
            prevAnnouncement,
            nextAnnouncement,
            prevNewProjects,
            nextNewProjects,
            challenge,
            types,
            activeTab,
            user,
            publish,
            unpublish,
            addSolution,
            solution,
            inTeam,
            isSolutions,
            isPublic,
            solution_project,
            checkSolution
        };
    }
});
</script>
