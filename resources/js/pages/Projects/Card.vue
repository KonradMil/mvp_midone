<template>
    <div class="intro-y" v-if="guard === true">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Projekt</h2>
        </div>
        <div class="wizard flex flex-col lg:flex-row justify-center px-5 sm:px-20">
            <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full btn btn-primary">1</button>
                <div class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto">Inicjowanie projektu</div>
            </div>
            <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full btn text-gray-600 bg-gray-200 dark:bg-dark-1" @click="showModal">
                    2
                </button>
                <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">Planowanie
                    projektu
                </div>
            </div>
            <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full btn text-gray-600 bg-gray-200 dark:bg-dark-1">3</button>
                <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">Realizacja
                    projektu zgodnie z ofertą
                </div>
            </div>
            <div class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                <button class="w-10 h-10 rounded-full btn text-gray-600 bg-gray-200 dark:bg-dark-1">4</button>
                <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">Zamykanie
                    projektu
                </div>
            </div>
            <div class="wizard__line hidden lg:block w-2/3 bg-gray-200 dark:bg-dark-1 absolute mt-5"></div>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box mt-5 lg:mt-0">
                    <div class="relative flex items-center p-5">
                        <div class="w-12 h-12 image-fit">
                            <img v-if="challenge.screenshot_path != undefined" class="rounded-full"
                                 :alt="challenge.name" :src="'/' + challenge.screenshot_path"/>
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="font-medium text-base">
                                {{ challenge.name }} <span class="text-theme-1 dark:text-theme-10"
                                                           v-if="challenge.status == 0"> - Szkic</span>
                            </div>
                            <div class="text-gray-600">{{ types[challenge.type] }}</div>
                        </div>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-feather="home"></i></div>
                            <div class="menu__title" @click.prevent="showMenu = !showMenu">
                                <InfoIcon class="w-4 h-4 mr-2"/>
                                Startowa karta projektu
                                <i data-feather="chevron-down" class="menu__sub-icon"></i>
                            </div>
                        </a>
                        <ul v-if="showMenu" class="intro-y pt-4 pl-5">
                            <li class="intro-y">
                                <a class="flex items-center"
                                   href=""
                                   @click.prevent="activeTab = 'podstawowe'"
                                   :class="(activeTab == 'podstawowe')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                                    <ActivityIcon class="w-4 h-4 mr-2"/>
                                    {{ $t('challengesMain.basicInformation') }}
                                </a>
                            </li>
                            <li class="intro-y">
                                <a class="flex items-center mt-5" href=""
                                   @click.prevent="(activeTab = 'techniczne') && (stage=2)"
                                   :class="(activeTab == 'techniczne')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                    <BoxIcon class="w-4 h-4 mr-2"/>
                                    {{ $t('challengesMain.technicalDetails') }} </a>
                            </li>
                            <li class="intro-y">
                                <a class="flex items-center mt-5" href="" v-if="challenge != undefined"
                                   @click.prevent="activeTab = 'rozwiazania'"
                                   :class="(activeTab == 'rozwiazania')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                    <LockIcon class="w-4 h-4 mr-2"/>
                                    <div v-if="challenge.selected != undefined && challenge.selected.length != 0">
                                        Rozwiązanie
                                    </div>
                                    <div v-if="challenge.selected == undefined || challenge.selected.length == 0">
                                        {{ $t('challengesMain.solutions') }}
                                    </div>
                                </a>
                            </li>
                            <li class="intro-y">
                                <a v-if="!inTeam && challenge.stage >= 1"
                                   class="flex items-center mt-5" href=""
                                   @click.prevent="activeTab = 'oferty'"
                                   :class="(activeTab == 'oferty')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                    <SettingsIcon class="w-4 h-4 mr-2"/>
                                    Oferta
                                </a>
                            </li>
                            <li class="intro-y">
                                <a v-if="inTeam && challenge.stage >= 1"
                                   class="flex items-center mt-5" href=""
                                   @click.prevent="activeTab = 'oferty'"
                                   :class="(activeTab == 'oferty')? 'text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                    <SettingsIcon class="w-4 h-4 mr-2"/>
                                    Oferta
                                </a>
                            </li>
                            <li class="intro-y">
                                <a class="flex items-center mt-5" href=""
                                   @click.prevent="activeTab = 'pytania'"
                                   :class="(activeTab == 'pytania')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                    <SettingsIcon class="w-4 h-4 mr-2"/>
                                    {{ $t('communication.questions') }}
                                </a>
                            </li>
                            <li class="intro-y">
                                <a v-if="challenge.stage === 3"
                                   class="flex items-center mt-5" href=""
                                   @click.prevent="activeTab = 'operational-analysis'"
                                   :class="(activeTab == 'operational-analysis')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                    <SettingsIcon class="w-4 h-4 mr-2"/>
                                    Analiza operacyjna rozwiązania
                                </a>
                            </li>
                            <li class="intro-y">
                                <a v-if="challenge.stage === 3"
                                   class="flex items-center mt-5" href=""
                                   @click.prevent="activeTab = 'financial-analysis'"
                                   :class="(activeTab == 'financial-analysis')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                    <SettingsIcon class="w-4 h-4 mr-2"/>
                                    Analiza finansowa rozwiązania
                                </a>
                            </li>
                            <li class="intro-y" v-if="(challenge.author_id == user.id)">
                                <a class="flex items-center mt-5" href=""
                                   @click.prevent="activeTab = 'teams'"
                                   :class="(activeTab == 'teams')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                                    <ActivityIcon class="w-4 h-4 mr-2"/>
                                    {{ $t('teams.teams') }}
                                </a>
                            </li>
                        </ul>
                        <a v-if="challenge.stage === 3"
                           class="flex items-center mt-5"
                           href=""
                           @click.prevent="showMenuVision = !showMenuVision">
                            <EditIcon v-if="project.accept_local_vision < 1" class="w-4 h-4 mr-2 text-red-600"/>
                            <CheckCircleIcon v-if="project.accept_local_vision === 1"
                                             class="w-4 h-4 mr-2 text-green-600"/>
                            <XCircleIcon v-if="project.accept_local_vision === 2" class="w-4 h-4 mr-2 text-red-600"/>
                            Wizja lokalna
                        </a>
                        <ul v-if="showMenuVision" class="intro-y pt-4 pl-5">
                            <li class="intro-y">
                                <a class="flex items-center"
                                   href=""
                                   @click.prevent="activeTab = 'visit-date'"
                                   :class="(activeTab == 'visit-date') ? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                                    <CalendarIcon class="w-4 h-4 mr-2"/>
                                    Termin wizyt
                                </a>
                            </li>
                            <li class="intro-y">
                                <a class="flex items-center mt-5"
                                   href=""
                                   @click.prevent="activeTab = 'local-vision'"
                                   :class="(activeTab == 'local-vision') ? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                    <Edit2Icon class="w-4 h-4 mr-2"/>
                                    Raport wizji lokalnej
                                </a>
                            </li>
                        </ul>
                        <a v-if="challenge.stage === 3 && project.accept_local_vision === 1"
                           href=""
                           @click.prevent="activeTab = 'project-details'"
                           :class="(activeTab == 'project-details') ? 'flex items-center mt-5 text-theme-1 dark:text-theme-10 font-medium mt-5' : 'flex items-center mt-5'">
                            <EditIcon
                                v-if="project.accept_technical_details < 1 || project.accept_financial_details < 1 && (project.accept_technical_details !== 2 && project.accept_financial_details !== 2)"
                                class="w-4 h-4 mr-2 text-red-600"/>
                            <CheckCircleIcon
                                v-if="project.accept_technical_details === 1 && project.accept_financial_details === 1"
                                class="w-4 h-4 mr-2 text-green-600"/>
                            <XCircleIcon
                                v-if="project.accept_technical_details === 2 || project.accept_financial_details === 2"
                                class="w-4 h-4 mr-2 text-red-600"/>
                            Akceptacja założeń technicznych
                        </a>
                        <a v-if="project.accept_local_vision === 0"
                           :class="(project.accept_local_vision === 1) ? 'flex items-center mt-5 cursor-pointer' : 'flex items-center mt-5 opacity-50 cursor-pointer'">
                            <EditIcon
                                v-if="project.accept_technical_details < 1 || project.accept_financial_details < 1"
                                class="w-4 h-4 mr-2 text-red-600"/>
                            <Tippy
                                tag="a"
                                class="dark:text-gray-300 text-theme-600"
                                content="Etap odblokuje się po zakończeniu wizji lokalnej">
                                Akceptacja założeń technicznych
                            </Tippy>
                        </a>
                        <a v-if="challenge.stage === 3 && project.accept_technical_details === 1 && project.accept_financial_details === 1"
                           class="flex items-center mt-5 cursor-pointer"
                           @click.prevent="activeTab = 'project-offer'"
                           :class="(activeTab == 'project-offer') ? 'text-theme-1 dark:text-theme-10 font-medium cursor-pointer' : 'mt-5 cursor-pointer'">
                            <EditIcon v-if="project.accept_offer < 1" class="w-4 h-4 mr-2 text-red-600"/>
                            <CheckCircleIcon v-if="project.accept_offer === 1" class="w-4 h-4 mr-2 text-green-600"/>
                            <XCircleIcon v-if="project.accept_offer === 2" class="w-4 h-4 mr-2 text-red-600"/>
                            Podsumowanie z oferty
                        </a>
                        <a v-if="project.accept_technical_details !== 1 || project.accept_financial_details !== 1"
                           class="flex items-center mt-5 opacity-50 cursor-pointer">
                            <EditIcon
                                v-if="project.accept_technical_details !== 1 || project.accept_financial_details !== 1"
                                class="w-4 h-4 mr-2 text-red-600"/>
                            <Tippy
                                tag="a"
                                class="dark:text-gray-300 text-theme-600"
                                content="Etap odblokuje się po zaakceptowaniu założeń technicznych">
                                Podsumowanie z oferty
                            </Tippy>
                        </a>
                        <a v-if="challenge.stage === 3"
                           class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'report-init'"
                           :class="(activeTab == 'report-init')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <EditIcon class="w-4 h-4 mr-2 text-red-600"/>
                            Raport z fazy inicjowania
                        </a>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex" v-if="inTeam">
                        <button type="button" class="btn btn-primary py-1 px-2"
                                v-if="challenge.solutions.length == 0 && editChallenges"
                                @click="$router.push({name: 'addChallenge', params: {challenge_id: challenge.id }});">
                            {{ $t('models.edit') }}
                        </button>
                        <button type="button" class="btn btn-primary py-1 px-2 ml-2"
                                @click="$router.push({name: 'challengeStudio', params: {id: challenge.id, type: 'challenge', load: challenge, publishChallenges: publishChallenges}})">
                            Studio 3D
                        </button>
                        <button
                            v-if="challenge.status == 0 && publishChallenges"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click="publish(challenge.id)">
                            {{ $t('challengesMain.publish') }}
                        </button>
                        <button
                            v-if="challenge.status == 1 && challenge.solutions.length == 0 && publishChallenges"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click="unpublish(challenge.id)">
                            {{ $t('challengesMain.unpublish') }}
                        </button>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex"
                         v-if="!inTeam && user.type == 'integrator'">
                        <button type="button" class="btn btn-primary py-1 px-2 ml-2"
                                @click="$router.push({name: 'challengeStudio', params: {id: challenge.id, publishChallenges: publishChallenges ,type: 'challenge', load: challenge, readOnly: true}})">
                            Studio 3D
                        </button>
                        <button v-if="challenge.stage == 1"
                                type="button"
                                class="btn btn-outline-secondary py-1 px-2 ml-auto"
                                @click.prevent="addSolution">
                            {{ $t('challengesMain.addSolution') }}
                        </button>
                    </div>
                </div>
                <WhatsNext :user="user" :challenge="challenge" :solutions="challenge.solutions" :project="project" :stage="3"></WhatsNext>
            </div>
            <!-- END: Profile Menu -->
            <BasicInformationPanel :challenge="challenge" :inTeam="inTeam" v-if="activeTab == 'podstawowe'"
                                   :investor="investor" :integrator="integrator"></BasicInformationPanel>
            <TechnicalInformationProjectPanel :project="project" :challenge="challenge" :stage="challenge.stage"
                                              v-if="activeTab == 'project-details'"
                                              :author_id="solution_project.author_id"></TechnicalInformationProjectPanel>
            <TechnicalInformationPanel :project="project" :challenge="challenge" :stage="stage"
                                       v-if="activeTab == 'techniczne'"
                                       :author_id="solution_project.author_id"></TechnicalInformationPanel>
            <QuestionsPanel v-if="activeTab == 'pytania'" :author_id="challenge.author_id" :id="challenge.id"
                            :challenge_stage="challenge.stage"></QuestionsPanel>
            <SolutionProjectPanel v-if="activeTab == 'rozwiazania'" :challenge="challenge" :inTeam="inTeam"
                                  :addChallengeSolution="addChallengeSolution"
                                  :acceptChallengeSolutions="acceptChallengeSolutions"
                                  :publishSolution="publishSolution"
                                  :addSolutionOffer="addSolutionOffer"></SolutionProjectPanel>
            <TeamsPanel
                v-if="(activeTab == 'teams') && ((challenge.author_id == user.id) || (solution.author_id == user.id))"
                :solution="solution" :challenge="challenge" :who="who"></TeamsPanel>
            <OfferAdd v-if="activeTab == 'addingoffer'" :stage="challenge.stage" :project="project"
                      :solution_id="selected_solution_id" :challenge_id="challenge.id" :edit_offer_id="edit_offer_id"
                      :change_offer="change_offer"></OfferAdd>
            <OfferProject v-if="activeTab == 'project-offer' || activeTab == 'oferty'" v-model:activeTab="activeTab"
                          :project="project" :integrator="integrator" :investor="investor" :stage="challenge.stage"
                          :id="challenge.id" :inTeam="inTeam" :addSolutionOffer="addSolutionOffer"
                          :selected_offer_id="challenge.selected_offer_id" :author_id="solution_project.author_id"
                          :challenge_author_id="challenge.author_id" :challenge="challenge"></OfferProject>
            <ChallengeOffers v-if="(activeTab == 'all-offers') && inTeam" v-model:activeTab="activeTab" :inTeam="inTeam"
                             :challenge="challenge" :acceptChallengeOffers="acceptChallengeOffers"></ChallengeOffers>
            <OperationalAnalysisInformationPanel v-if="activeTab == 'operational-analysis'"
                                                 :solution="solution_project"></OperationalAnalysisInformationPanel>
            <FinancialAnalysisInformationPanel v-if="activeTab == 'financial-analysis'"
                                               :solution="solution_project"></FinancialAnalysisInformationPanel>
            <LocalVisionPanel v-if="activeTab == 'local-vision'" :project="project" :challenge="challenge"
                              :challenge_author_id="challenge.author_id" :challenge_id="challenge.id"
                              :author_id="solution_project.author_id" :integrator="integrator"
                              :investor="investor"></LocalVisionPanel>
            <VisitDatePanel v-if="activeTab == 'visit-date'" :project="project" :challenge="challenge"
                            :challenge_author_id="challenge.author_id" :challenge_id="challenge.id"
                            :author_id="solution_project.author_id" :integrator="integrator"
                            :investor="investor"></VisitDatePanel>
            <ReportInitPanel v-if="activeTab == 'report-init'" :project="project" :challenge_id="challenge.id"
                             :author_id="solution_project.author_id"></ReportInitPanel>
            <ModalCard :show="show" @closed="modalClosed">
                <h3 class="intro-y text-lg font-medium mt-5">Czy na pewno chcesz przejść do następnej fazy?</h3>
                <div class="intro-y box p-5 mt-12 sm:mt-5" style="text-align: center;">
                    <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                        <button class="btn btn-primary shadow-md mr-2" @click.prevent="goTo">Tak</button>
                        <button class="btn btn-primary shadow-md mr-2">Anuluj</button>
                    </div>
                </div>
            </ModalCard>
            <ModalSuccess :show="showSuccess" @closed="modalClosed">
                <div class="p-5 text-center">
                    <CheckCircleIcon class="w-16 h-16 text-theme-9 mx-auto mt-3"></CheckCircleIcon>
                    <div class="text-3xl mt-5">Gratulacje zakończyłeś pierwszą faze projektu! Kontynuuj projekt przechodząc do drugiej fazy!</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-dismiss="modal" class="btn btn-primary w-24" @click.prevent="modalClosed">Ok</button>
                </div>
            </ModalSuccess>
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

import WhatsNext from "../Challenges/WhatsNext";
import BasicInformationPanel from "../Challenges/components/BasicInformationPanel";
import TechnicalInformationProjectPanel from "./components/TechnicalInformationProjectPanel";
import QuestionsPanel from "../Challenges/components/QuestionsPanel";
import SolutionProjectPanel from "./components/SolutionProjectPanel";
import {useToast} from "vue-toastification";
import OfferAdd from "../Challenges/components/OfferAdd";
import OfferProject from "./components/OfferProject";
import TeamsPanel from "../Challenges/components/TeamsPanel";
import ChallengeOffers from "../Challenges/components/ChallengeOffers";
import TechnicalInformationPanel from "../Challenges/components/TechnicalInformationPanel";
import OperationalAnalysisInformationPanel from "./components/OperationalAnalysisInformationPanel";
import FinancialAnalysisInformationPanel from "./components/FinancialAnalysisInformationPanel";
import LocalVisionPanel from "./components/LocalVisionPanel";
import VisitDatePanel from "./components/VisitDatePanel";
import ModalCard from "../../components/ModalCard";
import ModalSuccess from "../../components/ModalSuccess";
import ReportInitPanel from "./components/ReportInitPanel";
import RequestHandler from "../../compositions/RequestHandler";
import router from "../../router";

export default defineComponent({
    name: 'projectCard',
    components: {
        OfferProject,
        OfferAdd,
        ChallengeOffers,
        TeamsPanel,
        SolutionProjectPanel,
        QuestionsPanel,
        TechnicalInformationProjectPanel,
        BasicInformationPanel,
        WhatsNext,
        OperationalAnalysisInformationPanel,
        FinancialAnalysisInformationPanel,
        ModalCard,
        ModalSuccess,
        LocalVisionPanel,
        VisitDatePanel,
        ReportInitPanel,
        TechnicalInformationPanel,
        RequestHandler,
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
        const project = ref({});
        const permissions = ref({});
        const solution = ref({});
        const temp_offer_id = ref(null);
        const edit_offer_id = ref(null);
        const activeTab = ref('podstawowe');
        const user = window.Laravel.user;
        const selected_solution_id = ref(null);
        const types = require("../../json/types.json");
        const who = ref('challenge');
        const inTeam = ref(false);
        const isSolutions = ref(false);
        const isPublic = ref(false);
        const solution_project = ref('');
        const show = ref(false);
        const showMenu = ref(false);
        const showMenuVision = ref(false);
        const is_done_offer = ref(false);
        const change_offer = ref(false);
        const is_done_technical = ref(false);
        const stage = ref(0);
        const investor = ref({});
        const integrator = ref({});
        const guard = ref(false);
        const showSuccess = ref(false);
        const stageSecondActive = ref(false);



        watch(() => props.change, (first, second) => {
            if (props.change === 'all-offers' && user.type === 'integrator') {
                activeTab.value = 'oferty';
            } else {
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

        emitter.on('changeOfferProject', e => {
            edit_offer_id.value = e.edit_offer_id;
            change_offer.value = true;
            activeTab.value = 'addingoffer';
        });

        emitter.on('noChangeOfferProject', e => {
            is_done_offer.value = true;
        });

        emitter.on('changeToOffers', e => {
            project.value.selected_offer_id = 1
            activeTab.value = 'project-offer';
            is_done_offer.value = true;
        });

        emitter.on('updateOffers', e => {
            activeTab.value = 'all-offers';
        });

        emitter.on('updateAddSolutionOffer', e => {
            addSolutionOffer.value = e.addSolutionOffer;
        });
        emitter.on('acceptOffer', e => {
            project.value.accept_offer = 1;
            activeTab.value = 'report-init';
            showSuccess.value = true;
        });
        emitter.on('acceptLocalVision', e => {
            project.value.accept_vision = 1;
            activeTab.value = 'project-details';
        });
        emitter.on('acceptTechnicalDetails', e => {
            project.value.accept_technical_details = 1;
            if (project.value.accept_technical_details === 1 && project.value.accept_financial_details === 1) {
                activeTab.value = 'project-offer'
            }
        });
        emitter.on('acceptFinancialDetails', e => {
            project.value.accept_financial_details = 1;
            if (project.value.accept_financial_details === 1 && project.value.accept_technical_details === 1) {
                activeTab.value = 'project-offer'
            }
        });
        emitter.on('rejectOffer', e => {
            project.value.accept_offer = 2;
        });
        emitter.on('rejectLocalVision', e => {
            project.value.accept_vision = 2;
        });
        emitter.on('rejectDetails', e => {
            project.value.accept_details = 2;
        });

        const checkSolution = () => {
            challenge.value.solutions.forEach(function (solution) {
                if (solution.selected_offer_id === challenge.value.selected_offer_id) {
                    solution_project.value = solution;
                }
            });
        }

        const modalClosed = () => {
            show.value = false;
            showSuccess.value = false;
        }

        const showModal = async () => {
            show.value = !show.value;
        }

        const filter = () => {
            challenge.value.solutions.forEach(function (solution) {
                if (solution.author_id === user.id) {
                    isSolutions.value = true;
                } else if ((solution.published === 1) && (solution.author.id === user.id)) {
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
                .catch(function (error) {

                });
        }

        const goTo = () => {
            router.push( {path : '/projects/card/second/' + props.id})
        }

        emitter.on('changeTeamsSolution', e => () => {
            activeTab.value = 'teamsSolution'
        });

        emitter.on('*', (type, e) => {
            if (type == 'activeTab') {
                activeTab.value = e.name;
                solution.value = e.solution;
                who.value = e.who;
            }

        });


        emitter.on('changeToOfferAdd', e => () => {
            activeTab.value = 'addingoffer';
        });

        const getCardProjectRepositories = async (callback) => {
            RequestHandler('projects/' + props.id + '/card', 'get', {}, (response) => {
                challenge.value = response.data.challenge;
                project.value = response.data.project;
                callback(response);
            });
        }
        onMounted(function () {
            permissions.value = window.Laravel.permissions;
            getCardProjectRepositories(function (){
                checkTeam();
                filter();
                checkSolution();
                if(project.value.accept_offer === 1){
                        showSuccess.value = true;
                }
            });
            getInvestorAndIntegrator(function () {

            })
            setTimeout(function () {
                guard.value = true;
            }, 1500)
        })

        const getInvestorAndIntegrator = (callback) => {
            RequestHandler('projects/' + props.id + '/investor-integrator', 'get', {}, (response) => {
                investor.value = response.data.investor;
                integrator.value = response.data.integrator;
                callback(response);
            });
        }

        provide("bind[announcementRef]", el => {
            announcementRef.value = el;
        });

        provide("bind[newProjectsRef]", el => {
            newProjectsRef.value = el;
        });

        const delete_cookie = (name, path = '/', domain) => {
            if (get_cookie(name)) {
                document.cookie = name + "=" +
                    ((path) ? ";path=" + path : "") +
                    ((domain) ? ";domain=" + domain : "") +
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

        return {
            goTo,
            showSuccess,
            guard,
            investor,
            integrator,
            showMenuVision,
            project,
            stage,
            is_done_technical,
            change_offer,
            is_done_offer,
            showMenu,
            showModal,
            show,
            modalClosed,
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
            solution,
            inTeam,
            isSolutions,
            isPublic,
            solution_project,
            checkSolution,
            stageSecondActive
        };
    }
});
</script>
