<template>
    <div class="flex fixed w-full z-50 pb-2 h-24 bottom-0 h-28" v-if="expanded == 0" id="bottom-animation-minimalized">
        <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto;">
            <AnimationButtons :icons="icons"></AnimationButtons>
        </div>
    </div>
    <div style="margin-left: 10%;" class="flex fixed w-4/5 z-50 pb-2 h-96 bottom-0 bg-white rounded-md bg-opacity-25" v-if="expanded == 1" id="bottom-animation-normal">
        <div class="left flex-1 pt-2 flex-row ml-24">
            <div class="grid grid-cols-12 w-full">
                <div class="col-span-1">
                    <UnityButton tooltip="Dodaj linie" alttext="Dodaj linie" path="/s3/builder_icons/add_simple.png" action="addline" position="animationbuttonclick"/>
                    <UnityButton tooltip="Usuń linie" alttext="Usuń linie" path="/s3/builder_icons/bin_simple.png" action="removeline" position="animationbuttonclick"/>
                    <UnityButton tooltip="Minimalizuj" alttext="Minimalizuj" path="/s3/builder_icons/minimalize_simple.png" action="minimalize" position="animationbuttonclick"/>
                </div>
                <div class="col-span-11 rounded-md mr-5" style="background-color: rgba(147, 15, 104, 0.25);">
                    <div class="grid grid-cols-12">
                        <div class="col-span-2">

                        </div>
                        <div class="col-span-10">
                            <div class="w-full" style="overflow-x: scroll;">
                                <div v-for="(line, index) in lines" class="row" :class="(activeLineIndex == index)? 'active':''">
                                    <div v-for="(animable, index) in line.animables">
                                        <div class="pos-image__preview image-fit">
                                            <img
                                                :alt="animable.name.replace('models', 'models_images') + '.png'"
                                                :src="animable.name.replace('models', 'models_images') + '.png'"
                                            />
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
        const lines = ref([{}]);
        const activeLineIndex = ref(0);
        const expanded = ref(0);
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        emitter.on('animationbuttonclick', e => handleClick(e.val))
        emitter.on('UnityAnimationChainUpdate', e => {
            lines.value = e.layers.layers;
            console.log(e);
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
                    emitter.emit('unityoutgoingaction', {action: 'addLine', data: lines.value.length})
                    break;
                case 'removeline':
                    emitter.emit('unityoutgoingaction', {action: 'removeLine', data: ''})
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
            expanded,
            lines,
            activeLineIndex
        }
    }
}
</script>

<style scoped>

</style>
