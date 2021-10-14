<template>
    <div class="webgl-content">

        <canvas :id="containerId" v-bind:style="{ width: '100vw', height: '100vh' }"></canvas>
        <div v-if="loaded === false">
            <div class="unity-loader">
                <div class="bar">
                    <div class="fill" v-bind:style="{ width: progress * 100 + '%'}"></div>
                </div>
            </div>
        </div>
<!--        <div class="footer" v-if="hideFooter !== true">-->
<!--            <a class="fullscreen" @click.prevent="setFullscreen">Fullscreen</a>-->
<!--        </div>-->
    </div>
</template>

<script>
import {onMounted, onBeforeMount, ref, getCurrentInstance, onBeforeUnmount} from "vue";
import cash from "cash-dom/dist/cash";

export default {
    props: ['src', 'module', 'width', 'height', 'externalProgress', 'unityLoader', 'hideFooter'],
    name: 'Studio',
    setup(props,{emit}) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const containerId = ref();
        const gameInstance = ref();
        const loaded = ref(false);
        const progress = ref();
        const error = ref(null);
        const unity_path = window.unity_path;
        containerId.value = 'unity-container-' + Number(Math.random().toString().substr(3, length) + Date.now()).toString(36);
        const setFullscreen = () => {
            gameInstance.value.SetFullscreen(1);
        }
4
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

            onBeforeUnmount(() => {
                try {
                    gameInstance.value.Quit();
                } catch (e) {

                }
            });

        const instantiate = () => {



            createUnityInstance(document.querySelector('#' + containerId.value), {
                dataUrl: "/s3/unity/" + unity_path + ".data.br",
                frameworkUrl: "/s3/unity/" + unity_path + ".framework.js.br",
                codeUrl: "/s3/unity/" + unity_path + ".wasm.br",
                streamingAssetsUrl: "StreamingAssets",
                companyName: "DBR",
                productName: window.app_path,
                productVersion: "1.0",
            }).then(function (instance) {
                gameInstance.value = instance;
                loaded.value = true;
                emitter.emit('onInitialized', { loaded: true });
                // window.addEventListener('resize', onResize);
                // onResize();
            });
            // if (typeof UnityLoader === 'undefined') {
            //     let errorr = 'The UnityLoader was not defined, please add the script tag ' +
            //         'to the base html and embed the UnityLoader.js file Unity exported or use "unityLoader" attribute for path to UnityLoader.js.'
            //     console.error(errorr)
            //     error.value = errorr
            //     return
            // }
            // if (props.src === null) {
            //     let errorr = 'Please provice a path to a valid JSON in the "src" attribute.'
            //     console.error(errorr)
            //     error.value = errorr
            //     return
            // }
            // let params = {}
            // if (props.externalProgress) {
            //     params.onProgress = props.externalProgress
            // } else {
            //     params.onProgress = ((gameInstance, progresss) => {
            //          if(progresss === 1) {
            //             loaded.value = true;
            //              emitter.emit('onInitialized', { loaded: true });
            //         } else {
            //              loaded.value = false;
            //          }
            //         progress.value = progresss
            //     })
            // }
            // if (props.module) {
            //     params.Module = params.module
            // }

            // gameInstance.value = UnityLoader.instantiate(containerId.value, props.src, params)
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
            message,
        }
    },

}

</script>
