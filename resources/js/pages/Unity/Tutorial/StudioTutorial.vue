<template>
    <div class="webgl-content">
        <canvas :id="containerId" v-bind:style="{ width: '62vw', height: '83vh' }"></canvas>
        <div v-if="loaded === false">
            <div class="unity-loader">
                <div class="bar">
                    <div class="fill" v-bind:style="{ width: progress * 100 + '%'}"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, onBeforeMount, ref, getCurrentInstance} from "vue";
import cash from "cash-dom/dist/cash";
import unityActionOutgoing from "../composables/ActionsOutgoing";

export default {
    props: ['src', 'module', 'width', 'height', 'externalProgress', 'unityLoader', 'hideFooter'],
    name: 'StudioTutorial',
    setup(props,{emit}) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const containerId = ref();
        const gameInstance = ref();
        const loaded = ref(false);
        const progress = ref();
        const error = ref(null);
        const unity_tutorial_path = window.unity_tutorial_path;
        const unity_path = window.unity_path;

        containerId.value = 'unity-container-' + Number(Math.random().toString().substr(3, length) + Date.now()).toString(36);
        const setFullscreen = () => {
            gameInstance.value.SetFullscreen(1);
        }

        const message = (gameObject, method, param) => {
            if (param === null) {
                param = ''
            }
            if (gameInstance.value !== null){
                gameInstance.value.SendMessage(gameObject, method, param)
            } else {
                console.warn('vue-unity-webgl: you\'ve sent a message to the Unity content, but it wasn\t instantiated yet.')
            }
        }


        onBeforeMount(() => {
            // if (props.unityLoader) {
                const script = document.createElement('SCRIPT')
             script.setAttribute('src', '/s3/unity/' + unity_path + '.loader.js')
                script.setAttribute('async', '')
                script.setAttribute('defer', '')
                document.body.appendChild(script)
                script.onload = () => {
                    emitter.emit('onload', { done:1 })
                }
            // }
        })

        const instantiate = () => {
            console.log('INST');
            console.log(document.querySelector('#' + containerId.value));
            createUnityInstance(document.querySelector('#' + containerId.value), {
                dataUrl: "/s3/" + unity_tutorial_path + ".data.br",
                frameworkUrl: "/s3/" + unity_tutorial_path + ".framework.js.br",
                codeUrl: "/s3/" + unity_tutorial_path + ".wasm.br",
                streamingAssetsUrl: "StreamingAssets",
                companyName: "DBR",
                productName: "devsys.appworks-dev.pl",
                productVersion: "1.0",
            }).then(function (instance) {
                gameInstance.value = instance;
                loaded.value = true;
                emitter.emit('onInitialized', { loaded: true });
                // window.addEventListener('resize', onResize);
                // onResize();
            });
        }


        onMounted(()=> {
            emitter.on('onload', e =>  setTimeout(function () {
                instantiate();
            }, 1500))
        });

        return {
            containerId,
            loaded,
            progress,
            error,
            setFullscreen,
            message
        }
    },

}

</script>
