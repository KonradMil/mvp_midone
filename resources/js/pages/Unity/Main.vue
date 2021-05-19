<template>
    <TopButtons :icons="topIcons"></TopButtons>
    <LeftButtons :icons="leftIcons" v-if="mode == 'edit'"></LeftButtons>
    <LeftPanel></LeftPanel>
    <div @contextmenu.prevent="openMenu">
        <Studio hideFooter="true" :src="unity_path" :width="window_width" :height="window_height" unityLoader="/UnityLoader.js" ref="gameWindow"/>
    </div>
    <BottomPanel :mode="mode" v-model:animationSave="animationSave"></BottomPanel>
    <RightButtons :icons="rightIcons"></RightButtons>
    <RightPanel @mouseover.native="lockInput" @mouseleave.native="unlockInput" :type="type" :challenge="challenge" :solution="solution"></RightPanel>
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
import router from "../../router";
// import { VueCookies as $cookies } from 'vue3-cookies'
import {VueCookies as $cookies} from 'vue3-cookies'
const ww = WindowWatcher();

export default {
    name: "Main",
    props: {
        type: String,
        load: Object,
        id: Number
    },
    components: {RightButtons, RightPanel, BottomPanel, TopButtons, LeftPanel, LeftButtons, Studio},
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
        const doubleClick = ref(false);
        const mousePositionY = ref(0);
        const mousePositionX = ref(0);
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

        window_height.value = window.innerHeight;

        emitter.on('showChallenge', e => {
            challenge.value = e.obj;
            type.value = 'challenge';
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

        const lockInput = () => {
            console.log('LOCK');
            handleUnityActionOutgoing({action: "lockInput", data: ''});
        }

        const unlockInput = () => {
            console.log('UNLOCK');
            handleUnityActionOutgoing({action: "unlockInput", data: ''});
        }

        const openMenu = (e) => {
            e.preventDefault();
            console.log('RIGHT CLICK');
            console.log(e);
            if (loaded.value) {
                if (doubleClick.value) {
                    if ((mousePositionX.value > (e.clientX - 10) && mousePositionX.value < (e.clientX + 10)) && (mousePositionY.value > (e.clientY - 10) && mousePositionY.value < (e.clientY + 19))) {
                        let data = JSON.stringify({menu: currentRadialMenu.value});
                        console.log(data);
                        console.log('RIGHT CLICK SHOW');
                        handleUnityActionOutgoing({action: 'showRadialMenu', data: data});
                    } else {
                        doubleClick.value = false;
                    }
                } else {
                    console.log('ONE CLICK');
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

        const checkTeam = async () => {
            if(type.value == 'challenge') {
                await axios.post('/api/challenge/check-team', {user_id: user.id, challenge_id: challenge.value.id})
                    .then(response => {
                        // console.log(response.data)
                        if (response.data.success) {
                            inTeam.value = response.data.payload;
                        } else {

                        }
                    })
            } else {
                await axios.post('/api/solution/check-team', {user_id: user.id, solution_id: solution.value.id})
                    .then(response => {
                        // console.log(response.data)
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
            if(type.value == 'challenge') {
                if(inTeam.value || (user.id == challenge.author_id)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if(inTeam.value || (user.id == solution.author_id)) {
                    return true;
                } else {
                    return false;
                }
            }

            });

        emitter.on('topbuttonclick', e => {
            console.log(e);
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
                    console.log(gameWindow);
                    gameWindow.value.setFullscreen();
                    break;
                case 'logout':
                    router.push('/challenges')
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

                    break;
            }
        });


        emitter.on('UnitySave', e => {
            gameLoad.value.save_json = e.saveGame;
            if (type.value == 'challenge') {
                SaveChallengeUnity({save: gameLoad.value, id: id.value});
            } else {
                SaveSolutionUnity({save: gameLoad.value, id: id.value});
            }
            handleUnityActionOutgoing(e);
        });

        const handleUnityActionOutgoing = (e) => {
            try {
                unityActionOutgoingObject.value[e.action](e.data);
            } catch (ee) {
                console.log([ee, e]);
            }
        }

        const initalize = async () => {
            console.log("initializeMe");
            setTimeout(function () {
                loaded.value = true;
                // gameWindow.value.message('NetworkBridge', 'SetHangarApperance', 1);
                // gameWindow.value.message('NetworkBridge', 'UnlockUnityInput');
                unityActionOutgoingObject.value = unityActionOutgoing(gameWindow.value);
                handleUnityActionOutgoing({
                    action: 'setSessionId',
                    data: Number(Math.random().toString().substr(3, length) + Date.now()).toString(36)
                });
                // handleUnityActionOutgoing({action: 'setHangarAppearance', data: 1});
                handleUnityActionOutgoing({action: 'unlockUnityInput', data: ''});
                console.log('GET ME');
                if(type.value == 'solution') {
                    getSolutionRepositories(id.value);
                } else {
                    getCardChallengeRepositories(id.value);
                }
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
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log("response.data.payload");
                        console.log(response.data.payload);
                        console.log(JSON.parse(response.data.payload.save_json));
                        challenge.value = response.data.payload;
                        initialLoad.value = JSON.parse(response.data.payload.save_json);
                        animationSave.value = JSON.parse(response.data.payload.save_json).animation_layers;
                        handleUnityActionOutgoing({
                            action: 'loadStructure',
                            data: JSON.parse(response.data.payload.save_json)
                        });
                        // console.log('EMIT LOAD');
                        // emitter.emit('saveLoaded', {save: (response.data.payload)});
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const getSolutionRepositories = async (id) => {
            await axios.post('/api/solution/get/unity', {id: id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log("response.data.payload");
                        console.log(response.data.payload);
                        console.log(JSON.parse(response.data.payload.save_json));
                        solution.value = response.data.payload;
                        initialLoad.value = JSON.parse(response.data.payload.save_json);
                        animationSave.value = JSON.parse(response.data.payload.save_json).animation_layers;
                        handleUnityActionOutgoing({
                            action: 'loadStructure',
                            data: JSON.parse(response.data.payload.save_json)
                        });
                        // console.log('EMIT LOAD');
                        // emitter.emit('saveLoaded', {save: (response.data.payload)});
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const setCookie = (cname, cvalue, exdays) => {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }

        const getCookies = (name) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            console.log(parts);
            if (parts.length === 2) return parts.pop().split(';').shift();
        };

        onMounted(() => {
            checkTeam();
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
            if(props.type == undefined) {
                console.log(document.cookie);
                type.value = getCookies('type');
                id.value = getCookies('id');
                console.log(getCookies('id'));
            } else {
                type.value = props.type;
                id.value = props.id;
                setCookie('type', props.type, 1);
                setCookie('id', props.id, 1);
            }
        });

        return {
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
            openMenu,
            lockInput,
            unlockInput
        }
    }
}
</script>
