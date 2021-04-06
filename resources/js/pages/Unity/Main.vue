<template>
    <Studio @onload="initialize" hideFooter="true" :src="unity_path" :width="window_width" unityLoader="/UnityLoader.js" ref="gameWindow"/>
</template>

<script>
import Studio from "./Studio";
import {getCurrentInstance, onBeforeMount, onMounted, ref} from "vue";
import WindowWatcher from "../../events/WindowWatcher";
import UnityBridge from "./bridge";

const ww = WindowWatcher();

export default {
    name: "Main",
    components: {Studio},
    setup(props, {emit}) {
        const bridge = ref();
        const gameWindow = ref(null);
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const unity_path = ref('/s3/unity/AssemBrot19_03.json');
        const window_width = ref('100%');

        const initalize = async () => {
            console.log("initializeMe");
            gameWindow.message('NetworkBridge', 'SetHangarApperance', 1);
            gameWindow.message('NetworkBridge', 'UnlockUnityInput');
        }

        onBeforeMount(() => {
            bridge.value = UnityBridge();
        });

        onMounted(()=> {
            console.log("ww");
            console.log(ww);
        });

        return {
            unity_path,
            window_width,
            bridge,
            gameWindow,
            initalize
        }
    }
}
</script>
