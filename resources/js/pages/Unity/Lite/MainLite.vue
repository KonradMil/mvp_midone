<template>
    <TopButtons v-if="loaded" :allowedEdit="true" :icons="topIcons" :canEditSolution="true"></TopButtons>
    <LeftButtons :icons="leftIcons"></LeftButtons>
    <LeftPanel></LeftPanel>
    <div @contextmenu.prevent="openMenu">
        <StudioLite hideFooter="true" :src="unity_hangar_path" :width="window_width" :height="window_height" unityLoader="/UnityLoader.js" ref="gameWindow"/>
    </div>
    <BottomPanel  v-if="loaded" :allowedEdit="true" :mode="mode" v-model:animationSave="animationSave"></BottomPanel>
    <div v-if="!loaded" id="loader">
        <LoadingIcon icon="grid" class="w-8 h-8" />
    </div>
<PeerTest :unityActionOutgoingObject="unityActionOutgoingObject"></PeerTest>
</template>

<script>
import StudioLite from "./StudioLite";
import {computed, getCurrentInstance, onBeforeMount, onMounted, reactive, ref} from "vue";
import UnityBridge from "./bridge";
import cash from "cash-dom";
import WindowWatcher from "../../../events/WindowWatcher";
import unityActionOutgoing from "../composables/ActionsOutgoing";
import LeftButtons from "./../components/LeftButtons";
import LeftPanel from "./../components/LeftPanel";
import TopButtons from "./../components/TopButtons";
import BottomPanel from "./../components/BottomPanel";
import PeerTest from "../../PeerTest";

const ww = WindowWatcher();

export default {
    name: "MainLite",
    props: {
        type: String,
        id: Number,
        readOnly: {
            default: false,
            type: Boolean
        },
        sessionid: String
    },
    components: {
        PeerTest,
       BottomPanel, TopButtons, LeftPanel, LeftButtons, StudioLite
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
        const loaded = ref(false);
        const doubleClick = ref(false);
        const mousePositionY = ref(0);
        const mousePositionX = ref(0);
        const initialLoad = ref({});
        const user = window.Laravel.user;
        const modelActiveTab = ref('klawiszologia');

        //EXTERNAL
        const unity_hangar_path = window.unity_path;
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
        const sessionid = ref('');
        const owner = ref(false);

        if(props.sessionid === undefined) {
            sessionid.value = Math.random().toString(36).slice(-5);
            owner.value = true;
        } else {
            sessionid.value = props.sessionid;
            owner.value = false;
        }

        window_height.value = window.innerHeight;

        const startTutorial = () => {
            handleUnityActionOutgoing({action: 'launchTutorial', data: ''});
        }

        //ALL EVENTS
        emitter.on('*', (type, e) => {
            console.log('*', [type, e]);
            switch (type) {
                case 'unityoutgoingaction':
                    handleUnityActionOutgoing(e);
                    break;
                case 'gridsizechange':
                    handleUnityActionOutgoing({action: "changeGridSize", data: e.val});
                    break;
                case 'layoutbuttonclick':
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
                    break;
                case 'lockState':
                    if (e.action == 'lock') {
                        lockInput();
                    } else {
                        unlockInput();
                    }
                    break;
                case 'topbuttonclick':
                    console.log('aaa', e.val);
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
                    break;
                case 'UnitySave':
                    if (!saving.value) {
                        // saving.value = true;
                        // gameLoad.value.save_json = e.saveGame;
                        // if (type.value == 'challenge' && window.location.href.indexOf("challenge") > -1) {
                        //     SaveChallengeUnity({save: gameLoad.value, id: id.value}, () => {
                        //         saving.value = false;
                        //     });
                        // } else {
                        //     SaveSolutionUnity({save: gameLoad.value, id: id.value}, (sol) => {
                        //         id.value = sol.id;
                        //         saving.value = false;
                        //     });
                        // }
                        // emitter.emit('UnitySaved', {val: ''});
                        // handleUnityActionOutgoing(e);
                    }
                    break;
                case 'onInitialized':
                    initalize()
                    break;
                case 'updateanimationSave':
                    animationSave.value.layers = e.data.layers;
                    break;
            }
        });

        const lockInput = () => {
            handleUnityActionOutgoing({action: "lockInput", data: ''});
        }

        const unlockInput = () => {
            handleUnityActionOutgoing({action: "unlockInput", data: ''});
        }

        const getRoboData  = () => {
            axios.post('/api/playground/save', {id: id.value})
                .then(response => {
                    console.log('RESP', response);
                    challenge.value = response.data;
                    initialLoad.value = response.data.save_json;
                    animationSave.value = response.data.save_json.animation_layers;

                    handleUnityActionOutgoing({
                        action: 'loadStructure',
                        data: response.data.save_json
                    });
                })
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
                return false;
        })


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

                handleUnityActionOutgoing({action: 'prefix', data: window.app_path + '/s3'});
                getRoboData();
            }, 2000);
            setTimeout(() => {
                unlockInput();
            }, 5000);
        }

        onBeforeMount(() => {
            //ADDS LISTENERS
            bridge.value = UnityBridge();

        });

        const getSave = async (id) => {
        }


        onMounted(() => {
            //REMOVES PADDING
            cash("body")
                .removeClass("main")
                .removeClass("error-page")
                .addClass("p-0");
            const li = require("../../../json/unity_left_buttons.json");
            leftIcons.value = li.icons;
            const ri = require("../../../json/unity_right_buttons.json");
            rightIcons.value = ri.icons;
            const ti = require("../../../json/unity_top_buttons.json");
            topIcons.value = ti.icons;
            radialMenuAnimation.value = require("../../../json/radial_animation.json");
            radialMenuEdit.value = require("../../../json/radial_edit.json");
            radialMenuLayout.value = require("../../../json/radial_layout.json");
            currentRadialMenu.value = radialMenuEdit.value;
            mode.value = 'edit';
            type.value = props.type;
            id.value = props.id;
        });


        return {
            user,
            initialLoad,
            type,
            id,
            animationSave,
            unity_hangar_path,
            window_width,
            window_height,
            gameWindow,
            leftIcons,
            topIcons,
            rightIcons,
            mode,
            openMenu,
            lockInput,
            unlockInput,
            modelActiveTab,
            startTutorial,
            loaded,
            sessionid,
            owner,
            showLeftButtons,
            unityActionOutgoingObject
        }
    }
}
</script>
