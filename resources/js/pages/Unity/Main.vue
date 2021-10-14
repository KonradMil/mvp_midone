<template>
    <TopButtons v-if="loaded" :allowedEdit="allowedEdit && (challenge.status != 1)" :icons="topIcons" :canEditSolution="canEditSolution"></TopButtons>
    <LeftButtons :icons="leftIcons" v-if="(mode == 'edit' && allowedEdit && loaded)"></LeftButtons>
    <LeftPanel></LeftPanel>
    <div @contextmenu.prevent="openMenu">
        <Studio hideFooter="true" :src="unity_path" :width="window_width" :height="window_height" unityLoader="/UnityLoader.js" ref="gameWindow"/>
    </div>
    <BottomPanel v-if="loaded" :allowedEdit="allowedEdit" :mode="mode" v-model:animationSave="animationSave"></BottomPanel>
    <RightButtons v-if="loaded" :allowedEdit="allowedEdit" :icons="rightIcons" :type="type"></RightButtons>
    <RightPanel :allowedEdit="allowedEdit" :publishChallenges="publishChallenges" :canEditSolution="canEditSolution"  :type="type" :challenge="challenge" :solution="solution"></RightPanel>
<!--    @mouseover.native="lockInput" @mouseleave.native="unlockInput"-->
    <div v-if="!loaded" id="loader">
        <LoadingIcon icon="grid" class="w-8 h-8"/>
    </div>
    <Peer v-if="sessionid != ''" :sessionId="sessionid" :owner="owner"></Peer>
    <!--    <VoiceChat :sessionId="sessionid" :owner="owner"></VoiceChat>-->
    <!--    <WebRTC width="100%" roomId="roomId"></WebRTC>-->
    <div id="help-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">
                    <h3 class="intro-y text-lg font-medium mt-5">Pomoc</h3>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <!-- BEGIN: Profile Menu -->
                        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                            <div class="intro-y box mt-5 lg:mt-0">
                                <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                                    <a class="flex items-center"
                                       href=""
                                       @click.prevent="modelActiveTab = 'klawiszologia'"
                                       :class="(modelActiveTab == 'klawiszologia')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                                        <ActivityIcon class="w-4 h-4 mr-2"/>
                                        Klawiszologia
                                    </a>
                                    <a class="flex items-center mt-5" href=""
                                       @click.prevent="modelActiveTab = 'faq'"
                                       :class="(modelActiveTab == 'faq')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                        <BoxIcon class="w-4 h-4 mr-2"/>
                                        FAQ
                                    </a>
                                    <a class="flex items-center mt-5" href=""
                                       @click.prevent="modelActiveTab = 'tutorial'"
                                       :class="(modelActiveTab == 'tutorial')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                        <SettingsIcon class="w-4 h-4 mr-2"/>
                                        Tutorial
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- END: Profile Menu -->
                        <div class="col-span-9 lg:col-span-9 xxl:col-span-9" v-if="modelActiveTab == 'klawiszologia'">
                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto"> Klawiszologia</h2>
                            </div>
                            <div class="grid grid-cols-12 gap-6">
                                <!-- BEGIN: Announcement -->
                                <div class="intro-y box col-span-12 xxl:col-span-12">
                                    <img src="/s3/images/klawiszologia.jpeg" class="img-fluid cursor-pointer" @click="window.open('/s3/images/klawiszologia.jpeg', '_blank').focus();"/>
                                </div>
                                <!-- END: Announcement -->
                            </div>
                        </div>
                        <div class="col-span-9 lg:col-span-9 xxl:col-span-9" v-if="modelActiveTab == 'faq'">
                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">FAQ</h2>
                            </div>
                            <div class="grid grid-cols-12 gap-6">
                                <!-- BEGIN: Announcement -->
                                <div class="intro-y box col-span-12 xxl:col-span-12">

                                </div>
                                <!-- END: Announcement -->
                            </div>
                        </div>
                        <div class="col-span-9 lg:col-span-9 xxl:col-span-9" v-if="modelActiveTab == 'tutorial'">
                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">Tutorial</h2>
                            </div>
                            <div class="grid grid-cols-12 gap-6">
                                <!-- BEGIN: Announcement -->
                                <div class="intro-y box col-span-6 xxl:col-span-6">
                                    <div class="px-15 py-15">
                                        <button class="btn btn-primary" type="button" @click="startTutorial">Rozpocznij tutorial</button>
                                    </div>
                                </div>
                                <!-- END: Announcement -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <ModalWorkshop :show="workshopOpen"></ModalWorkshop>-->
    <!--    <WorkshopModal v-if="workshopOpen" :open="workshopOpen"></WorkshopModal>-->
</template>

<script>
import Studio from "./Studio";
import {computed, getCurrentInstance, onBeforeMount, onMounted, reactive, ref} from "vue";
import WindowWatcher from "../../events/WindowWatcher";
import UnityBridge from "./bridge";
import cash from "cash-dom";
import LeftButtons from "./components/LeftButtons";
import LeftPanel from "./components/LeftPanel";
import SaveChallengeUnity from "../../compositions/SaveChallengeUnity";
import SaveSolutionUnity from "../../compositions/SaveSolutionUnity";
import unityActionOutgoing from './composables/ActionsOutgoing';
import TopButtons from "./components/TopButtons";
import BottomPanel from "./components/BottomPanel";
import RightPanel from "./components/RightPanel";
import RightButtons from "./components/RightButtons";
import WorkshopModal from "./WorkshopModal"
import WebRTC from "./WebRTC";
import ModalWorkshop from "../../components/ModalWorkshop";
import Peer from "./Peer";

const ww = WindowWatcher();

export default {
    name: "Main",
    props: {
        type: String,
        id: Number,
        readOnly: {
            default: false,
            type: Boolean
        },
        publishChallenges: Boolean,
        canEditSolution: Boolean,
        sessionid: String
    },
    components: {
        Peer,
        ModalWorkshop, WebRTC, RightButtons, RightPanel, BottomPanel, TopButtons, LeftPanel, LeftButtons, Studio
    },
    setup(props, {emit}) {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        //INTERNAL
        const id = ref(0);
        const type = ref('challenge');
        const mode = ref('');
        const bridge = ref();
        const gameWindow = ref(null);
        const gameLoad = ref({});
        const loaded = ref(false);
        const workshopOpen = ref(false);
        const doubleClick = ref(false);
        const mousePositionY = ref(0);
        const mousePositionX = ref(0);
        const initialLoad = ref({});
        const challenge = ref({});
        const solution = ref({});
        const user = window.Laravel.user;
        const inTeam = ref(false);
        const modelActiveTab = ref('klawiszologia');

        //EXTERNAL
        const unity_path = ref('/s3/unity/AssemBrot14_05_ver2.json');
        const window_width = ref('100%');
        const window_height = ref(0);
        const rightIcons = ref([]);
        const leftIcons = ref([]);
        const topIcons = ref([]);
        const unityActionOutgoingObject = ref({});
        const currentRadialMenu = ref([]);
        const radialMenuEdit = ref([]);
        const radialMenuAnimation = ref([]);
        const radialMenuLayout = ref([]);
        const animationSave = ref({layers: []});
        const saving = ref(false);
        const sessionid = ref('');
        const owner = ref(false);



        window_height.value = window.innerHeight;

        emitter.on('showChallenge', e => {
            challenge.value = e.obj;
            type.value = 'challenge';
        });

        const startTutorial = () => {
            handleUnityActionOutgoing({action: 'launchTutorial', data: ''});
        }

        emitter.on('workshop_object_clicked', e => {
            workshopOpen.value = false;
            handleUnityActionOutgoing({action: "loadWorkshopObject", data: JSON.parse(e.object.save)});
        });

        emitter.on('workshop_open', e => {
            // cash("#workshop-modal").modal("show");
            workshopOpen.value = true;
        });

        //RUNS WHEN UNITY IS READY
        emitter.on('onInitialized', e => initalize());

        //HANDLES ALL UNITY ACTIONS
        emitter.on('unityoutgoingaction', e => {
            handleUnityActionOutgoing(e);
        });

        //HANDLES ALL UNITY ACTIONS
        emitter.on('gridsizechange', e => {
            handleUnityActionOutgoing({action: "changeGridSize", data: e.val});
        });

        //HANDLES ALL LAYOUT ACTIONS
        emitter.on('layoutbuttonclick', e => {
            switch (e.val) {
                case "edit":
                    handleUnityActionOutgoing({action: "beginLayoutEdit", data: ''});
                    break;
                case "addlabel":
                    handleUnityActionOutgoing({action: "beginLayoutLabel", data: ''});
                    break;
                case "addlayout":
                    handleUnityActionOutgoing({action: "beginLayoutDraw", data: ''});
                    break;
                case "notatka":
                    handleUnityActionOutgoing({action: "beginLayoutComment", data: ''});
                    break;
            }
        });

        emitter.on('lockState', e => {
            if (e.action == 'lock') {
                lockInput();
            } else {
                unlockInput();
            }
        });

        const lockInput = () => {

            handleUnityActionOutgoing({action: "lockInput", data: ''});
        }

        const unlockInput = () => {

            handleUnityActionOutgoing({action: "unlockInput", data: ''});
        }

        const openMenu = (e) => {
            e.preventDefault();

            if (loaded.value) {
                if (doubleClick.value) {
                    if ((mousePositionX.value > (e.clientX - 10) && mousePositionX.value < (e.clientX + 10)) && (mousePositionY.value > (e.clientY - 10) && mousePositionY.value < (e.clientY + 19))) {
                        let data = JSON.stringify({menu: currentRadialMenu.value});
                        handleUnityActionOutgoing({action: 'showRadialMenu', data: data});
                    } else {
                        doubleClick.value = false;
                    }
                } else {
                    mousePositionX.value = e.clientX;
                    mousePositionY.value = e.clientY;
                    doubleClick.value = true;
                    handleUnityActionOutgoing({action: 'closeRadialMenu', data: ''});
                    setTimeout(function () {
                        doubleClick.value = false;
                    }, 1000);
                }
            }
        }

        const showLeftButtons = computed(() => {
            if (mode == 'edit' && allowedEdit && loaded) {
                return true;
            } else {
                return false;
            }
        })

        const checkTeam = async () => {
            if (type.value == 'challenge') {
                await axios.post('/api/challenge/check-team', {user_id: user.id, challenge_id: challenge.value.id})
                    .then(response => {


                        if (response.data.success) {
                            inTeam.value = response.data.payload;
                        } else {

                        }
                    })
            } else {
                await axios.post('/api/solution/check-team', {user_id: user.id, solution_id: solution.value.id}).then(response => {
                        if (response.data.success) {
                            inTeam.value = response.data.payload;
                        } else {

                        }
                    })
            }
        };

        const changeMode = (mode) => {

        }

        const allowedEdit = computed(() => {
            if (type.value == 'challenge') {
                if (inTeam.value || (user.id == challenge.value.author_id)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (inTeam.value || (user.id == solution.value.author_id)) {
                    return true;
                } else {
                    return false;
                }
            }
        });

        emitter.on('topbuttonclick', e => {
            switch (e.val) {
                case 'animation_mode':
                    handleUnityActionOutgoing({action: "animationMode", data: ''});
                    currentRadialMenu.value = radialMenuAnimation.value;
                    mode.value = 'animation';
                    break;
                case 'edit_mode':
                    handleUnityActionOutgoing({action: "editMode", data: ''});
                    currentRadialMenu.value = radialMenuEdit.value;
                    mode.value = 'edit';
                    break;
                case 'layout':
                    handleUnityActionOutgoing({action: "layoutMode", data: ''});
                    currentRadialMenu.value = radialMenuLayout.value;
                    mode.value = 'layout';
                    break;
                case 'fullscreen':

                    gameWindow.value.setFullscreen();
                    break;
                case 'logout':
                    if (type.value == 'solution') {
                        window.location.href = window.app_path + '/challenges/card/' + solution.value.challenge_id;
                    } else {
                        window.location.href = window.app_path + '/challenges/card/' + challenge.value.id;
                    }
                    break;
                case 'orto':
                    handleUnityActionOutgoing({action: 'ChangeCamera', data: 2});
                    break;
                case 'fpv':
                    handleUnityActionOutgoing({action: 'ChangeCamera', data: 3});
                    break;
                case 'topdown':
                    handleUnityActionOutgoing({action: 'ChangeCamera', data: 1});
                    break;
                case 'standard':
                    handleUnityActionOutgoing({action: 'ChangeCamera', data: 0});
                    break;
                case 'save':
                    handleUnityActionOutgoing({action: 'save', data: ''});
                    break;
                case 'help':
                    cash("#help-modal").modal("show");
                    break;
            }
        });


        emitter.on('UnitySave', e => {
            if (!saving.value) {
                saving.value = true;
                gameLoad.value.save_json = e.saveGame;
                if (type.value == 'challenge' && window.location.href.indexOf("challenge") > -1) {
                    SaveChallengeUnity({save: gameLoad.value, id: id.value}, () => {
                        saving.value = false;
                    });
                } else {
                    SaveSolutionUnity({save: gameLoad.value, id: id.value}, (sol) => {
                        id.value = sol.id;
                        saving.value = false;
                    });
                }
                emitter.emit('UnitySaved', {val: ''});
                handleUnityActionOutgoing(e);
            }
        });

        const handleUnityActionOutgoing = (e) => {
            try {
                unityActionOutgoingObject.value[e.action](e.data);
            } catch (ee) {

            }
        }

        const initalize = async () => {
            setTimeout(function () {
                loaded.value = true;
                unityActionOutgoingObject.value = unityActionOutgoing(gameWindow.value);
                handleUnityActionOutgoing({
                    action: 'setSessionId',
                    data: Number(Math.random().toString().substr(3, length) + Date.now()).toString(36)
                });
                // handleUnityActionOutgoing({action: 'setHangarAppearance', data: 1});
                handleUnityActionOutgoing({action: 'unlockUnityInput', data: ''});

                if (type.value == 'solution') {
                    getSolutionRepositories(id.value);
                } else {
                    getCardChallengeRepositories(id.value);
                }
                console.log({action: 'prefix', data: window.app_path + '/s3'});
                handleUnityActionOutgoing({action: 'prefix', data: window.app_path + '/s3'});
            }, 2000);
            setTimeout(() => {
                unlockInput();
            }, 5000);
        }

        onBeforeMount(() => {
            //ADDS LISTENERS
            bridge.value = UnityBridge();
        });

        emitter.on('updateanimationSave', e => {
            animationSave.value.layers = e.data.layers;
        });

        const getCardChallengeRepositories = async (id) => {
            await axios.post('/api/challenge/user/get/card', {id: id})
                .then(response => {
                    if (response.data.success) {
                        if (response.data.payload.save_json == "") {
                            challenge.value = response.data.payload;
                            checkTeam();
                            unlockInput();
                        } else {

                            challenge.value = response.data.payload;
                            initialLoad.value = response.data.payload.save_json;
                            animationSave.value = response.data.payload.save_json.animation_layers;
                            checkTeam();

                            handleUnityActionOutgoing({
                                action: 'loadStructure',
                                data: response.data.payload.save_json
                            });
                            unlockInput();
                        }


                        // emitter.emit('saveLoaded', {save: (response.data.payload)});
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const getSolutionRepositories = async (id) => {
            await axios.post('/api/solution/get/unity', {id: id})
                .then(response => {

                    if (response.data.success) {
                        solution.value = response.data.payload;
                        initialLoad.value = JSON.parse(response.data.payload.save_json);
                        animationSave.value = JSON.parse(response.data.payload.save_json).animation_layers;
                        checkTeam();

                        handleUnityActionOutgoing({
                            action: 'loadStructure',
                            data: JSON.parse(response.data.payload.save_json)
                        });
                        unlockInput();
                        // emitter.emit('saveLoaded', {save: (response.data.payload)});
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        onMounted(() => {

            //REMOVES PADDING
            cash("body")
                .removeClass("main")
                .removeClass("error-page")
                .addClass("p-0");
            const li = require("../../json/unity_left_buttons.json");
            leftIcons.value = li.icons;
            const ri = require("../../json/unity_right_buttons.json");
            rightIcons.value = ri.icons;
            const ti = require("../../json/unity_top_buttons.json");
            topIcons.value = ti.icons;
            radialMenuAnimation.value = require("../../json/radial_animation.json");
            radialMenuEdit.value = require("../../json/radial_edit.json");
            radialMenuLayout.value = require("../../json/radial_layout.json");
            currentRadialMenu.value = radialMenuEdit.value;
            mode.value = 'edit';
            type.value = props.type;
            id.value = props.id;
        });

        return {
            workshopOpen,
            user,
            challenge,
            solution,
            initialLoad,
            type,
            id,
            animationSave,
            unity_path,
            window_width,
            window_height,
            gameWindow,
            leftIcons,
            topIcons,
            rightIcons,
            mode,
            inTeam,
            allowedEdit,
            openMenu,
            lockInput,
            unlockInput,
            modelActiveTab,
            startTutorial,
            loaded,
            sessionid,
            owner,
            showLeftButtons
        }
    }
}
</script>
