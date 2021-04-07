<template>
    <LeftButtons :icons="icons"></LeftButtons>
    <Studio hideFooter="true" :src="unity_path" :width="window_width" unityLoader="/UnityLoader.js" ref="gameWindow"/>
</template>

<script>
import Studio from "./Studio";
import {getCurrentInstance, onBeforeMount, onMounted, ref} from "vue";
import WindowWatcher from "../../events/WindowWatcher";
import UnityBridge from "./bridge";
import cash from "cash-dom";
import LeftButtons from "./components/LeftButtons";

const ww = WindowWatcher();

export default {
    name: "Main",
    components: {LeftButtons, Studio},
    setup(props, {emit}) {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        //INTERNAL
        const bridge = ref();
        const gameWindow = ref(null);
        //EXTERNAL
        const unity_path = ref('/s3/unity/AssemBrot19_03.json');
        const window_width = ref('100%');
        const icons = ref([])


        //RUNS WHEN UNITY IS READY
        emitter.on('onInitialized', e =>  initalize() );
        //LEFT BUTTON CLICKED
        emitter.on('leftbuttonclick', e =>  console.log(e) )

        const initalize = async () => {
            console.log("initializeMe");
            setTimeout(function () {
                console.log(gameWindow);
                gameWindow.value.message('NetworkBridge', 'SetHangarApperance', 1);
                gameWindow.value.message('NetworkBridge', 'UnlockUnityInput');
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
            const  i = require("../../json/unity_left_buttons.json");
            icons.value = i.icons;
        });

        return {
            unity_path,
            window_width,
            gameWindow,
            icons
        }
    }
}
</script>
