<template>
    <div class="webgl-content">
        <div :id="containerId" v-bind:style="{ width: width + 'px', height: height + 'px' }"></div>
        <div v-if="loaded === false">
            <div class="unity-loader">
                <div class="bar">
                    <div class="fill" v-bind:style="{ width: progress * 100 + '%'}"></div>
                </div>
            </div>
        </div>
        <div class="footer" v-if="hideFooter !== true">
            <a class="fullscreen" @click.prevent="setFullscreen">Fullscreen</a>
        </div>
    </div>
</template>

<script>
import {onMounted, onBeforeMount, ref} from "vue";

export default {
    props: ['src', 'module', 'width', 'height', 'externalProgress', 'unityLoader', 'hideFooter'],
    name: 'Studio',
    setup(props,{emit}) {
        const containerId = 'unity-container-' + Number(Math.random().toString().substr(3, length) + Date.now()).toString(36);
        const gameInstance = ref();
        const loaded = ref(false);
        const progress = ref();
        const error = ref(null);

        const setFullscreen = () => {
            gameInstance.SetFullscreen(1);
        }

        const message = (gameObject, method, param) => {
            if (param === null) {
                param = ''
            }
            if (gameInstance !== null){
                gameInstance.SendMessage(gameObject, method, param)
            } else {
                console.warn('vue-unity-webgl: you\'ve sent a message to the Unity content, but it wasn\t instantiated yet.')
            }
        }

        onBeforeMount(() => {
            if (props.unityLoader) {
                const script = document.createElement('SCRIPT')
                script.setAttribute('src', props.unityLoader)
                script.setAttribute('async', '')
                script.setAttribute('defer', '')
                document.body.appendChild(script)
                script.onload = () => {
                    emit('onload')
                }
            }
        })

            emit.$on('onload', () => {
                console.log('LAODED');
            })
        onMounted(()=> {
            const instantiate = () => {
                if (typeof UnityLoader === 'undefined') {
                    let errorr = 'The UnityLoader was not defined, please add the script tag ' +
                        'to the base html and embed the UnityLoader.js file Unity exported or use "unityLoader" attribute for path to UnityLoader.js.'
                    console.error(errorr)
                    error.value = errorr
                    return
                }
                if (props.src === null) {
                    let errorr = 'Please provice a path to a valid JSON in the "src" attribute.'
                    console.error(errorr)
                    error.value = errorr
                    return
                }
                let params = {}
                if (props.externalProgress) {
                    params.onProgress = props.externalProgress
                } else {
                    params.onProgress = ((gameInstance, progress) => {
                        loaded.value = (progress === 1)
                        progress.value = progress
                    })
                }
                if (this.module) {
                    params.Module = params.module
                }
                gameInstance.value = UnityLoader.instantiate(containerId.value, src.value, params)
            }
                instantiate()
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
