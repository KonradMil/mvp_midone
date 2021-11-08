<template>
    <div v-if="guard === true" class="intro-y">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{$t('challengesMain.challenge')}}</h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box mt-5 lg:mt-0">
                    <div class="relative flex items-center p-5">
<!--                        <div class="w-12 h-12 image-fit">-->
<!--                            <img v-if="challenge.screenshot_path != undefined" class="rounded-full" :alt="challenge.name" :src="'/' + challenge.screenshot_path"/>-->
<!--                        </div>-->
                        <div class=" mr-auto">
                            <div class="font-medium text-base">
                                {{ challenge.name }} <span class="text-theme-1 dark:text-theme-10" v-if="challenge.status == 0"> - Szkic</span>
                            </div>
                            <div class="text-gray-600">{{ types[challenge.type] }}</div>
                        </div>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a class="flex items-center"
                            href=""
                            @click.prevent="activeTab = 'podstawowe'"
                            :class="(activeTab == 'podstawowe')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                            {{$t('challengesMain.basicInformation')}}
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'techniczne'"
                           :class="(activeTab == 'techniczne')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <BoxIcon class="w-4 h-4 mr-2"/>
                            {{$t('challengesMain.technicalDetails')}}                        </a>
                        <a class="flex items-center mt-5" href="" v-if="challenge != undefined"
                           @click.prevent="activeTab = 'rozwiazania'"
                           :class="(activeTab == 'rozwiazania')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <LockIcon class="w-4 h-4 mr-2"/>
                            <div v-if="challenge.selected != undefined && challenge.selected.length != 0">{{$t('challengesMain.solutions')}}</div><div v-if="challenge.selected == undefined || challenge.selected.length == 0">{{$t('challengesMain.solutions')}}
                        </div>
                        </a>
                        <a v-if="!inTeam && challenge.stage >= 1 && user.type === 'integrator'"
                            class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'oferty'"
                           :class="(activeTab == 'oferty')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <SettingsIcon class="w-4 h-4 mr-2"/>
                            {{$t('challengesMain.myOffers')}}
                        </a>
                        <a v-if="inTeam && challenge.stage >= 1 || challenge.author_id === user.id"
                            class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'all-offers'"
                           :class="(activeTab == 'all-offers')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <SettingsIcon class="w-4 h-4 mr-2"/>
                            {{$t('challengesMain.offers')}}
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'pytania'"
                           :class="(activeTab == 'pytania')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <SettingsIcon class="w-4 h-4 mr-2"/>
                            {{$t('communication.questions')}}
                        </a>
                        <a v-if="challenge.stage === 3"
                            class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'operational-analysis'"
                           :class="(activeTab == 'operational-analysis')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <SettingsIcon class="w-4 h-4 mr-2"/>
                            Analiza operacyjna rozwiązania
                        </a>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5" v-if="(challenge.author_id == user.id)">
                        <a class="flex items-center" href=""
                           @click.prevent="activeTab = 'teams'"
                           :class="(activeTab == 'teams')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                            {{$t('teams.teams')}}
                        </a>
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
                <WhatsNext v-if="guard === true" :user="user" :challenge="challenge" :id="id" :solutions="challenge.solutions"></WhatsNext>
            </div>
            <!-- END: Profile Menu -->
            <BasicInformationPanel :challenge="challenge" :inTeam="inTeam" v-if="activeTab == 'podstawowe'"></BasicInformationPanel>
            <TechnicalInformationPanel :challenge="challenge" v-if="activeTab == 'techniczne'"></TechnicalInformationPanel>
            <QuestionsPanel v-if="activeTab == 'pytania'" :author_id="challenge.author_id" :id="challenge.id" :challenge_stage="challenge.stage" :type="'challenge'"></QuestionsPanel>
            <SolutionsPanel v-if="activeTab == 'rozwiazania' && guard === true" :challenge="challenge" :inTeam="inTeam" :addChallengeSolution="addChallengeSolution" :acceptChallengeSolutions="acceptChallengeSolutions" :publishSolution="publishSolution" :addSolutionOffer="addSolutionOffer"></SolutionsPanel>
            <TeamsPanel v-if="(activeTab == 'teams') && ((challenge.author_id == user.id) || (solution.author_id == user.id))" :solution="solution" :challenge="challenge" :who="who" ></TeamsPanel>
            <OfferAdd v-if="activeTab == 'addingoffer' && guard === true" :stage="challenge.stage" :solution_id="selected_solution_id" :challenge_id="challenge.id" :edit_offer_id="edit_offer_id"></OfferAdd>
            <Offers v-if="activeTab == 'oferty' && guard === true" v-model:activeTab="activeTab" :id="challenge.id" :inTeam="inTeam" :addSolutionOffer="addSolutionOffer" :stage="challenge.stage"></Offers>
            <ChallengeOffers v-if="(activeTab == 'all-offers' && guard === true) && inTeam" v-model:activeTab="activeTab" :inTeam="inTeam" :challenge="challenge" :acceptChallengeOffers="acceptChallengeOffers"></ChallengeOffers>
            <OperationalAnalysisInformationPanel v-if="activeTab == 'operational-analysis'" :solution="solution_project" ></OperationalAnalysisInformationPanel>
        </div>
    </div>
</template>

<script>
import {
    defineComponent,
    ref,
    provide,
    onMounted,
    getCurrentInstance,
    watch
} from "vue";
import WhatsNext from "./WhatsNext";
import BasicInformationPanel from "./components/BasicInformationPanel";
import TechnicalInformationPanel from "./components/TechnicalInformationPanel";
import QuestionsPanel from "./components/QuestionsPanel";
import router from "../../router";
import SolutionsPanel from "./components/SolutionsPanel";
import {useToast} from "vue-toastification";
import OfferAdd from "./components/OfferAdd";
import Offers from "./components/Offers";
import TeamsPanel from "./components/TeamsPanel";
import ChallengeOffers from "./components/ChallengeOffers";
import OperationalAnalysisInformationPanel from "./components/OperationalAnalysisInformationPanel";
import RequestHandler from '../../compositions/RequestHandler';

export default defineComponent({
    name: 'Card',
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
        OperationalAnalysisInformationPanel
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
        const guard = ref(false);

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

        const filter = () => {

            challenge.value.solutions.forEach(function (solution) {

                if(solution.author_id=== user.id) {
                    isSolutions.value = true;
                } else if((solution.published === 1) && (solution.author.id === user.id)) {
                    isPublic.value = true;
                }
            });
        }

        const checkTeam = () => {
            axios.post('/api/challenge/check-team', {user_id: user.id, challenge_id: challenge.value.id})
                .then(response => {
                    if (response.data.success) {
                        inTeam.value = response.data.payload || (user.id == challenge.value.author_id);
                    } else {

                    }
                })
        }

        emitter.on('changeTeamsSolution', e => () => {
            activeTab.value = 'teamsSolution'
        });

        emitter.on('*', (type, e) => {
            if(type == 'activeTab') {
                    activeTab.value = e.name;
                    solution.value = e.solution;
                    who.value = e.who;
                }

        } );


        emitter.on('changeToOfferAdd', e => () => {
            activeTab.value = 'addingoffer';
        });

        const handleCallback = () => {

            checkPermissions();
        };

        const getCardChallengeRepositories = async (callback) => {
            await axios.post('/api/challenge/user/get/card', {id: props.id})
                .then(response => {
                    if (response.data.success) {
                        challenge.value = response.data.payload;
                        callback(response);
                    } else {
                    }
                }, handleCallback)
        }

        onMounted(function () {
            if(props.change === 'all-offers' && user.type === 'integrator'){
                activeTab.value = 'oferty';
            } else {
                activeTab.value = props.change
            }
            if(props.change === undefined){
                activeTab.value = 'podstawowe';
            }

            if(window.location.hash == '#solutions') {
                activeTab.value = 'rozwiazania';
            }

            permissions.value = window.Laravel.permissions;
            getCardChallengeRepositories(function (){
                checkTeam();
                filter();
                checkPermissions();
                checkSolution();
                guard.value = true;
                if(challenge.value.stage === 3){
                    window.location.replace('/projects/card/' + challenge.value.id);
                }
            });
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


                    if (response.data.success) {

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

                    if (response.data.success) {

                        challenge.value = response.data.payload;
                        toast.success('Wyzwanie nie jest już publiczne.');
                    } else {
                        toast.error('Błąd.');
                    }
                })
        }

        const addSolution = () => {

            RequestHandler('v2/user/company/is_valid', 'POST', {}, function(response){

                if(typeof response.data.isValid !== 'undefined' && !response.data.isValid) {

                    window.location.replace('/profiles#fill_company_data');

                } else {

                    axios.post('/api/solution/create', {id: challenge.value.id})
                        .then(response => {
                            if (response.data.success) {
                                router.push({path: '/studio/solution/' + response.data.payload.id});
                            } else {
                                // toast.error(response.data.message);
                            }
                        })

                }

            });

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
            guard,
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
