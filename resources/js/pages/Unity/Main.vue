<template>
    <TopButtons :icons="topIcons"></TopButtons>
    <LeftButtons :icons="leftIcons"></LeftButtons>
    <LeftPanel></LeftPanel>

    <Studio hideFooter="true" :src="unity_path" :width="window_width" unityLoader="/UnityLoader.js" ref="gameWindow"/>
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

const ww = WindowWatcher();

export default {
    name: "Main",
    components: {TopButtons, LeftPanel, LeftButtons, Studio},
    setup(props, {emit}) {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        //INTERNAL
        const type = ref('challenge');
        const bridge = ref();
        const gameWindow = ref(null);
        const gameLoad = ref({});
        //EXTERNAL
        const unity_path = ref('/s3/unity/AssemBrot19_03.json');
        const window_width = ref('100%');
        const leftIcons = ref([])
        const topIcons = ref([])
        const unityActionOutgoingObject = ref({});


        //RUNS WHEN UNITY IS READY
        emitter.on('onInitialized', e =>  initalize() );

        //HANDLES ALL UNITY ACTIONS
        emitter.on('unityoutgoingaction', e => {
            handleUnityActionOutgoing(e);
        });

        emitter.on('UnitySave', e => {
            gameLoad.value.save_json = e.saveGame;
            if(type.value == 'challenge') {
                SaveChallengeUnity(gameLoad);
            } else {

            }
            handleUnityActionOutgoing(e);
        });

        const handleUnityActionOutgoing = (e) => {
            try {
                unityActionOutgoingObject.value[e.action](e.data);
            }catch (ee) {
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

        onMounted(()=> {
            //REMOVES PADDING
            cash("body")
                .removeClass("main")
                .removeClass("error-page")
                .addClass("p-0");
            const  li = require("../../json/unity_left_buttons.json");
            leftIcons.value = li.icons;
            const  ti = require("../../json/unity_top_buttons.json");
            leftIcons.value = ti.icons;
        });

        return {
            unity_path,
            window_width,
            gameWindow,
            leftIcons,
            topIcons
        }
    }
}
</script>
