<template>
    <TopButtons :icons="topIcons"></TopButtons>
    <LeftButtons :icons="leftIcons"></LeftButtons>
    <LeftPanel></LeftPanel>

    <Studio hideFooter="true" :src="unity_path" :width="window_width" :height="window_height" unityLoader="/UnityLoader.js" ref="gameWindow"/>
    <BottomPanel :mode="mode"></BottomPanel>
</template>

<script>
import Studio from "./Studio";
import {getCurrentInstance, onBeforeMount, onMounted, ref} from "vue";
import WindowWatcher from "../../events/WindowWatcher";
import UnityBridge from "./bridge";
import cash from "cash-dom";
import LeftButtons from "./components/LeftButtons";
import LeftPanel from "./components/LeftPanel";
import SaveChallengeUnity from "../../compositions/SaveChallengeUnity";
import unityActionOutgoing from './composables/ActionsOutgoing';
import TopButtons from "./components/TopButtons";
import BottomPanel from "./components/BottomPanel";

const ww = WindowWatcher();

export default {
    name: "Main",
    components: {BottomPanel, TopButtons, LeftPanel, LeftButtons, Studio},
    setup(props, {emit}) {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        //INTERNAL
        const type = ref('challenge');
        const mode = ref('');
        const bridge = ref();
        const gameWindow = ref(null);
        const gameLoad = ref({});
        //EXTERNAL
        const unity_path = ref('/s3/unity/AssemBrot19_03.json');
        const window_width = ref('100%');
        const window_height = ref(0);
        const leftIcons = ref([])
        const topIcons = ref([])
        const unityActionOutgoingObject = ref({});
        window_height.value = window.innerHeight;

        //RUNS WHEN UNITY IS READY
        emitter.on('onInitialized', e => initalize());

        //HANDLES ALL UNITY ACTIONS
        emitter.on('unityoutgoingaction', e => {
            handleUnityActionOutgoing(e);
        });

        const changeMode = (mode) => {

        }

        emitter.on('topbuttonclick', e => {
            console.log(e);
            switch (e.val) {
                case 'animation_mode':
                    mode.value = 'animation';
                    break;
                case 'edit_mode':
                    mode.value = 'edit';
                    break;
                case 'layout':
                    mode.value = 'layout';
                    break;
                case 'fullscreen':
                    console.log(gameWindow);
                    gameWindow.value.setFullscreen();
                    break;
                case 'logout':
                    // handleUnityActionOutgoing(e);
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
                    handleUnityActionOutgoing({action: 'SaveStructure', data: ''});
                    break;
                case 'help':

                    break;
            }
        });


        emitter.on('UnitySave', e => {
            gameLoad.value.save_json = e.saveGame;
            if (type.value == 'challenge') {
                SaveChallengeUnity(gameLoad);
            } else {

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
                console.log(gameWindow);
                // gameWindow.value.message('NetworkBridge', 'SetHangarApperance', 1);
                // gameWindow.value.message('NetworkBridge', 'UnlockUnityInput');
                unityActionOutgoingObject.value = unityActionOutgoing(gameWindow.value);
                handleUnityActionOutgoing({action: 'setSessionId', data: 1});
                handleUnityActionOutgoing({action: 'setHangarAppearance', data: 1});
                handleUnityActionOutgoing({action: 'unlockUnityInput', data: ''});

            }, 5000);
        }

        onBeforeMount(() => {
            //ADDS LISTENERS
            bridge.value = UnityBridge();
        });

        onMounted(() => {
            //REMOVES PADDING
            cash("body")
                .removeClass("main")
                .removeClass("error-page")
                .addClass("p-0");
            const li = require("../../json/unity_left_buttons.json");
            leftIcons.value = li.icons;
            const ti = require("../../json/unity_top_buttons.json");
            topIcons.value = ti.icons;
        });

        return {
            unity_path,
            window_width,
            window_height,
            gameWindow,
            leftIcons,
            topIcons,
            mode
        }
    }
}
</script>
