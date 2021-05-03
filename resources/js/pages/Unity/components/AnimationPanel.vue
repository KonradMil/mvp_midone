<template>
    <div class="flex fixed w-full z-50 pb-2 h-24 bottom-0 h-28" v-if="expanded == 0" id="bottom-animation-minimalized">
        <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto;">
            <AnimationButtons :icons="icons"></AnimationButtons>
        </div>
    </div>
    <div style="margin-left: 10%;" class="flex fixed w-4/5 z-50 pb-2 h-96 bottom-0 bg-white rounded-md bg-opacity-25" v-if="expanded == 1" id="bottom-animation-normal">
        <div class="left flex-1 pt-2 flex-row ml-5">
            <div class="grid grid-cols-12 w-full">
                <div class="col-span-1">
                    <UnityButton tooltip="Dodaj linie" alttext="Dodaj linie" path="/s3/builder_icons/add_simple.png" action="addline" position="animationbuttonclick"/>
                    <UnityButton tooltip="Maksymalizuj" alttext="Maksymalizuj" path="/s3/builder_icons/maximize_simple.png" action="maximize" position="animationbuttonclick"/>
                    <UnityButton tooltip="Minimalizuj" alttext="Minimalizuj" path="/s3/builder_icons/minimalize_simple.png" action="minimalize" position="animationbuttonclick"/>
                    <UnityButton tooltip="Odtwórz" alttext="Odtwórz" path="/s3/builder_icons/play_simple.png" action="play" position="animationbuttonclick"/>
                </div>
                <div class="col-span-11 rounded-md mr-5" style="background-color: rgba(147, 15, 104, 0.25); overflow-y: scroll;">
                    <div class="grid grid-cols-12 h-full" v-for="(line, index) in animation.layers">
                        <div class="col-span-1">
                            <div style="margin-left: 25%; margin-top: calc(25% - 10px);">
                                <UnityButton tooltip="Ustawienia" alttext="Ustawienia" path="/s3/builder_icons/settings_simple.png" action="settingsline" position="animationbuttonclick"/>
                            </div>
                            <div style="margin-left: 25%; margin-top: calc(25% - 10px)">
                                <UnityButton tooltip="Usuń linie" alttext="Usuń linie" path="/s3/builder_icons/bin_simple.png" action="removeline" position="animationbuttonclick"/>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div style="border-radius: 50%; background-color: rgb(255, 255, 255); height: 56px; width: 56px; margin-left: 25%; margin-top: 25%;">
                                <span style="font-size: 20px; font-weight: bold; top: 33%; left: 6%; position: relative;">C: {{ line.interval }}</span>
                            </div>
                            <div style="border-radius: 50%; background-color: rgb(255, 255, 255); height: 56px; width: 56px; margin-left: 25%; margin-top: 25%;">
                                <span style="font-size: 20px; font-weight: bold; top: 33%; left: 6%; position: relative;">D: {{ line.delay }}</span>
                            </div>
                        </div>
                        <div class="col-span-10 h-full" style="overflow-x: auto; overflow-y: hidden;">
                            <div class="w-full  h-full">
                                <div class="row flex h-full" :class="(activeLineIndex == index)? 'active':''">
                                    <div class=" h-full" v-for="(animable, index) in line.animables">
                                        <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;" @click="activeAnimableIndex = index">
                                            <img class="w-full h-full"
                                                 :alt="animable.name.replace('models', 'models_images') + '.png'"
                                                 :src="animable.name.replace('models', 'models_images') + '.png'"
                                            />
                                            <div style="width: 94%; bottom: 0; position: relative; margin-top: 85%; margin-left: 10px; font-size: 16px; font-weight: bold;">Czas trwania: {{ animable.duration }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-left: 10%;" class="flex fixed w-4/5 z-50 pb-2 h-24 bottom-0 h-100 bg-white rounded-md bg-opacity-25" v-if="expanded == 2" id="bottom-animation-expanded">
        <div class="left flex  pt-2 flex-row ml-24">

        </div>
    </div>
</template>

<script>
import AnimationButtons from "./AnimationButtons";
import {getCurrentInstance, ref} from "vue";
import UnityButton from "./UnityButton";


export default {
    name: "AnimationPanel",
    components: {AnimationButtons, UnityButton},
    props: {
        icons: Object
    },
    setup(props, context) {
        const animation = ref({layers: []});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        //ANIMATION CONTROLLER
        function swapObjectByIndex(index, object) {
            animation.value.layers[index] = object;
        }

        function addLine() {
            animation.value.layers[animation.layers.length + 1] = {};
        }

        function updateAnimationUnity() {
            emitter.emit('unityoutgoingaction', {action: 'updateCurrentAnimation', data: animation});
        }
        //END OF ANIMATION CONTROLLER

        const activeLineIndex = ref(0);
        const activeAnimableIndex = ref(0);
        const expanded = ref(1);

        emitter.on('animationbuttonclick', e => handleClick(e.val))

        emitter.on('rightpanelaction', e => {
            console.log(e);
            if(e.action === 'updateLine' || e.action === 'updateAnimable' ) {
                if(activeLineIndex.value == undefined) {
                    activeLineIndex.value = 0;
                }
                swapObjectByIndex(activeLineIndex.value, e.data);
            }
            console.log('FINAL EMIT');
            console.log({layers: lines.value[0]});
            updateAnimationUnity();
            // emitter.emit('unityoutgoingaction', {action: 'updateCurrentAnimation', data: lines.value[0]});
        });

        emitter.on('UnityAnimationChainUpdate', e => {
            // lines.value = e.layers.layers;
            animation.value.layers = e.layers.layers;
        });

        const handleClick = (val) => {
            console.log(val);
            switch (val) {
                case 'maximize':
                    if (expanded.value == 0) {
                        expanded.value = 1;
                    } else if (expanded.value == 1) {
                        expanded.value = 2;
                    }
                    break;
                case 'speedupleft':
                    emitter.emit('unityoutgoingaction', {action: 'setPlaybackSpeed', data: val.data});
                    break;
                case 'stop':
                    emitter.emit('unityoutgoingaction', {action: 'stopAnimation', data: ''});
                    break;
                case 'pause':
                    emitter.emit('unityoutgoingaction', {action: 'pauseAnimation', data: ''});
                    break;
                case 'play':
                    emitter.emit('unityoutgoingaction', {action: 'runAnimation', data: ''})
                    break;
                case 'addline':
                    emitter.emit('unityoutgoingaction', {data: lines.value.length})
                    break;
                case 'removeline':
                    emitter.emit('unityoutgoingaction', {data: activeLineIndex.value})
                    break;
                case 'settingsline':
                    console.log(lines.value);
                    console.log('IMPORTANT');
                    console.log( lines.value[activeLineIndex.value]);
                    emitter.emit('UnityLineSettings', {action: 'settingsline', data: animation.value.layers[activeLineIndex.value]})
                    break;
                case 'line':
                    emitter.emit('UnityAnimableSettings', {
                        action: 'removeLine',
                        data: animation.value.layers[activeLineIndex.value].animables[activeAnimableIndex.value]
                    })
                    break;
                case 'minimalize':
                    if (expanded.value == 1) {
                        expanded.value = 0;
                    } else if (expanded.value == 2) {
                        expanded.value = 1;
                    }
                    break;
            }
        }

        return {
            animation,
            expanded,
            activeLineIndex,
            activeAnimableIndex
        }
    }
}
</script>

<style scoped>

</style>
