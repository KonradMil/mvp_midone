<template>
    <TopButtons v-if="loaded" :allowedEdit="allowedEdit && (challenge.status != 1)" :icons="topIcons" :canEditSolution="canEditSolution"></TopButtons>
    <LeftButtons :icons="leftIcons" v-if="(mode == 'edit' && allowedEdit && loaded)"></LeftButtons>
    <LeftPanel></LeftPanel>
    <div @contextmenu.prevent="openMenu">
        <Studio hideFooter="true" :src="unity_path" :width="window_width" :height="window_height" unityLoader="/UnityLoader.js" ref="gameWindow"/>
    </div>
    <BottomPanel v-if="loaded" :allowedEdit="allowedEdit" :mode="mode" v-model:animationSave="animationSave"></BottomPanel>
    <RightButtons v-if="loaded" :allowedEdit="allowedEdit" :icons="rightIcons" :type="type"></RightButtons>
    <RightPanel :allowedEdit="allowedEdit" :publishChallenges="publishChallenges" :isPublishSolution="isPublishSolution" :canEditSolution="canEditSolution"  :type="type" :challenge="challenge" :solution="solution"></RightPanel>
    <div v-if="!loaded" id="loader">
        <LoadingIcon icon="grid" class="w-8 h-8"/>
    </div>
<!--    <Peer v-if="sessionid != ''" :sessionId="sessionid" :owner="owner"></Peer>-->
    <HelpModal></HelpModal>
    <ModalSuccess :show="showSuccess" @closed="modalClosed">
        <div class="p-5 text-center">
            <CheckCircleIcon class="w-16 h-16 text-theme-9 mx-auto mt-3"></CheckCircleIcon>
            <div class="text-3xl mt-5">Gratulacje Twoje rozwiązanie zostało zaakceptowane! W tym przypadku tryb edycji został wyłączony.</div>
        </div>
        <div class="px-5 pb-8 text-center">
            <button type="button" data-dismiss="modal" class="btn btn-primary w-24" @click.prevent="modalClosed">Ok</button>
        </div>
    </ModalSuccess>
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
import ModalWorkshop from "../../components/ModalWorkshop";
import HelpModal from "./components/HelpModal";
import useEmitter from "../../composables/useEmitter";
import useRadialMenu from "../../composables/radialMenu";
import useLayoutButtonClick from "../../composables/useLayoutButtonClick";
import ModalSuccess from "../../components/ModalSuccess";

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
        sessionid: String,
        isPublishSolution: String,
    },
    components: {
        HelpModal, ModalWorkshop, RightButtons, RightPanel, BottomPanel, TopButtons, LeftPanel, LeftButtons, Studio, ModalSuccess
    },
    setup(props, {emit}) {
        //GLOBAL
        const emitter = useEmitter();
        //INTERNAL
        const id = ref(0);
        const type = ref('challenge');
        const mode = ref('');
        const bridge = ref();
        const gameWindow = ref(null);
        const gameLoad = ref({});
        const loaded = ref(false);
        const workshopOpen = ref(false);

        const initialLoad = ref({});
        const challenge = ref({});
        const solution = ref({});
        const user = window.Laravel.user;
        const inTeam = ref(false);

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
        const isPublishSolution = ref('');
        const showSuccess = ref(false);

        const modalClosed = () => {
            showSuccess.value = false;
        }
        //ALL EVENTS
        emitter.on('*', (type, e) => {
            console.log('*', [type, e]);
            switch (type) {
                    case 'unityoutgoingaction':
                        handleUnityActionOutgoing(e);
                        break;
                    case 'workshop_object_clicked':
                        workshopOpen.value = false;
                        handleUnityActionOutgoing({action: "loadWorkshopObject", data: JSON.parse(e.object.save)});
                        break;
                    case 'showChallenge':
                        challenge.value = e.obj;
                        type.value = 'challenge';
                        break;
                    case 'workshop_open':
                        workshopOpen.value = true;
                        break;
                    case 'gridsizechange':
                        handleUnityActionOutgoing({action: "changeGridSize", data: e.val});
                        break;
                    case 'layoutbuttonclick':
                        useLayoutButtonClick(e.val, (val) => {
                            handleUnityActionOutgoing(val);
                        })
                        break;
                    case 'lockState':
                        if (e.action == 'lock') {
                            lockInput();
                        } else {
                            unlockInput();
                        }
                        break;
                    case 'topbuttonclick':
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
                                if (props.type == 'solution') {
                                    window.location.href = window.app_path + '/challenges/card/' + solution.value.challenge_id+"#solutions";
                                } else {
                                    window.location.href = window.app_path + '/challenges/card/' + challenge.value.id+"#solutions";
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
                        break;
                    case 'UnitySave':
                        if (!saving.value) {
                            saving.value = true;
                            gameLoad.value.save_json = e.saveGame;
                            if (props.type == 'challenge' && window.location.href.indexOf("challenge") > -1) {
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
                        break;
                        case 'starttutorial':
                            handleUnityActionOutgoing({action: 'launchTutorial', data: ''});
                            break;
                        case 'onInitialized':
                            initalize()
                        break;
                            case 'updateanimationSave':
                                animationSave.value.layers = e.data.layers;
                        break;
                }
        });

        //TELL UNITY TO GIVE KEYBOARD EVENTS TO WEB
        const lockInput = () => {
            handleUnityActionOutgoing({action: "lockInput", data: ''});
        }

        const unlockInput = () => {
            handleUnityActionOutgoing({action: "unlockInput", data: ''});
        }

        //RADIAL MENU OPEN/CLOSE
        const openMenu = (e) => {
            e.preventDefault();
            useRadialMenu(loaded.value, currentRadialMenu.value, e,(val) => {
                handleUnityActionOutgoing(val);
            });
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


        const allowedEdit = computed(() => {
            if (type.value == 'challenge') {
                if (inTeam.value || (user.id == challenge.value.author_id)) {
                    return true;
                } else {
                    return false;
                }
            } else if(isPublishSolution.value === 'true'){
                  showSuccess.value = true;
                  return false;
            }else {
                if (inTeam.value || (user.id == solution.value.author_id)) {
                    return true;
                } else {
                    return false;
                }
            }
        });

        //FUNCTION TO PASS EVENTS TO UNITY
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
                unlockInput();

                if (type.value == 'solution') {
                    getSolutionRepositories(id.value);
                } else {
                    getCardChallengeRepositories(id.value);
                }
                console.log({action: 'prefix', data: window.app_path + '/s3'});
                //SET PREFIX FOR MODELS AND PREFABS
                handleUnityActionOutgoing({action: 'prefix', data: window.app_path + '/s3'});
            }, 2000);
            setTimeout(() => {
                unlockInput();
            }, 5000);
        }

        onBeforeMount(() => {
            //ADDS UNITY WINDOW LISTENERS
            bridge.value = UnityBridge();
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

                            window.unityLoad = response.data.payload.save_json;

                            handleUnityActionOutgoing({
                                action: 'loadStructure',
                                data: response.data.payload.save_json
                            });
                            unlockInput();
                        }
                    } else {

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

                        window.unityLoad = response.data.payload.save_json;

                        handleUnityActionOutgoing({
                            action: 'loadStructure',
                            data: JSON.parse(response.data.payload.save_json)
                        });
                        unlockInput();
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

            //INITIALIZES DATA FOR BUTTONS
            const li = require("../../json/unity_left_buttons.json");
            leftIcons.value = li.icons;
            const ri = require("../../json/unity_right_buttons.json");
            rightIcons.value = ri.icons;
            const ti = require("../../json/unity_top_buttons.json");
            topIcons.value = ti.icons;

            //PRELOADES DATA FOR RADIALS
            radialMenuAnimation.value = require("../../json/radial_animation.json");
            radialMenuEdit.value = require("../../json/radial_edit.json");
            radialMenuLayout.value = require("../../json/radial_layout.json");
            currentRadialMenu.value = radialMenuEdit.value;

            //INITIALIZES MAIN VALUES
            mode.value = 'edit';
            type.value = props.type;
            isPublishSolution.value = props.isPublishSolution;
            id.value = props.id;
            window_height.value = window.innerHeight;
        });

        return {
            modalClosed,
            showSuccess,
            isPublishSolution,
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
            loaded,
            sessionid,
            owner,
            showLeftButtons
        }
    }
}
</script>
