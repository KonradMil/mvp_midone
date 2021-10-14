<template>
<!--    <div class="flex fixed w-full z-50 pb-2 h-24 bottom-0 h-28" v-if="expanded == 0" id="bottom-animation-minimalized" style="pointer-events: none;">-->
<!--        <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto; pointer-events: none;">-->
<!--            <AnimationButtons :icons="icons"></AnimationButtons>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div style="margin-left: 10%;" class="flex fixed w-4/5 z-50 pb-2 h-96 bottom-0 bg-white rounded-md bg-opacity-25" v-if="expanded == 1" id="bottom-animation-normal">-->
<!--        <div class="left flex-1 pt-2 flex-row ml-5">-->
<!--            <div class="grid grid-cols-12 w-full h-full">-->
<!--                <div class="col-span-1">-->
<!--                    <UnityButton tooltip="Dodaj linie" alttext="Dodaj linie" path="/s3/builder_icons/add_simple.png" action="addline" position="animationbuttonclick"/>-->
<!--                    <UnityButton tooltip="Maksymalizuj" alttext="Maksymalizuj" path="/s3/builder_icons/maximize_simple.png" action="maximize" position="animationbuttonclick"/>-->
<!--                    <UnityButton tooltip="Minimalizuj" alttext="Minimalizuj" path="/s3/builder_icons/minimalize_simple.png" action="minimalize" position="animationbuttonclick"/>-->
<!--                    <UnityButton tooltip="Odtwórz" alttext="Odtwórz" path="/s3/builder_icons/play_simple.png" action="play" position="animationbuttonclick"/>-->
<!--                </div>-->
<!--                <div class="col-span-11 rounded-md mr-5 relative" style=" overflow-y: scroll;">-->
<!--                    <div class="grid grid-cols-12 my-3" @click="activeLineIndex = line.index; setNewAnimationLayer();" :class="(activeLineIndex == line.index)? 'active-row':'inactive-row'" style="max-height: 200px;" v-for="(line, index) in animation.layers" :key="'linia_' + line.index">-->
<!--                        <div class="col-span-1">-->
<!--                            <div style="margin-left: 25%; margin-top: calc(25% - 10px);">-->
<!--&lt;!&ndash;                                <UnityButton tooltip="" alttext="Ustawienia" path="/s3/builder_icons/settings_simple.png" action="settingsline" position="animationbuttonclick"/>&ndash;&gt;-->
<!--                                <Tippy-->
<!--                                    id="meta-title-tab"-->
<!--                                    tag="span"-->
<!--                                    :content="'Ustawienia'"-->
<!--                                    href="javascript:;"-->
<!--                                    class="w-14 py-2 text-center flex justify-center items-center"-->
<!--                                    aria-selected="false">-->
<!--                                    <div class="w-14 h-14 flex-none image-fit overflow-hidden zoom-in" @click.native="settingsLine(line.index)">-->
<!--                                        <img class=""-->
<!--                                             :alt="'Ustawienia'"-->
<!--                                             :src="'/s3/builder_icons/settings_simple.png'"-->
<!--                                        />-->
<!--                                    </div>-->
<!--                                </Tippy>-->
<!--                            </div>-->
<!--                            <div style="margin-left: 25%; margin-top: calc(25% - 10px)">-->
<!--&lt;!&ndash;                                <UnityButton tooltip="Usuń linie" alttext="Usuń linie" path="/s3/builder_icons/bin_simple.png" action="removeline"  position="animationbuttonclick"/>&ndash;&gt;-->
<!--                                <Tippy-->
<!--                                    id="meta-title-tab"-->
<!--                                    tag="span"-->
<!--                                    :content="'Usuń linie'"-->
<!--                                    href="javascript:;"-->
<!--                                    class="w-14 py-2 text-center flex justify-center items-center"-->
<!--                                    aria-selected="false">-->
<!--                                    <div class="w-14 h-14 flex-none image-fit overflow-hidden zoom-in"  @click.native="removeLine(line.index)">-->
<!--                                        <img class=""-->
<!--                                             :alt="'Usuń linie'"-->
<!--                                             :src="'/s3/builder_icons/bin_simple.png'"-->
<!--                                        />-->
<!--                                    </div>-->
<!--                                </Tippy>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-span-1">-->
<!--                            <div style="border-radius: 50%; background-color: rgb(255, 255, 255); height: 56px; width: 56px; margin-left: 25%; margin-top: 25%;">-->
<!--                                <span style="font-size: 20px; font-weight: bold; top: 33%; left: 6%; position: relative;">C: {{ line.interval }}</span>-->
<!--                            </div>-->
<!--                            <div style="border-radius: 50%; background-color: rgb(255, 255, 255); height: 56px; width: 56px; margin-left: 25%; margin-top: 25%;">-->
<!--                                <span style="font-size: 20px; font-weight: bold; top: 33%; left: 6%; position: relative;">D: {{ line.delay }}</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-span-10 h-full" style="overflow-x: auto; overflow-y: hidden;">-->
<!--                            <div class="w-full  h-full">-->
<!--                                <div class="row flex h-full" >-->
<!--                                    <div class=" h-full" v-for="(animable, index) in line.animables" :key="'obiekt_' + index">-->
<!--                                        <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;" @click="activeAnimableIndex = index; showAnimableDialog();">-->
<!--                                            <img class="w-full h-full"-->
<!--                                                 :alt="animable.name.replace('models', 'models_images') + '.png'"-->
<!--                                                 :src="animable.name.replace('models', 'models_images') + '.png'"-->
<!--                                            />-->
<!--                                            <div style="width: 94%; bottom: 0; position: relative; margin-top: 85%; margin-left: 10px; font-size: 16px; font-weight: bold;">Czas trwania: {{ animable.duration }}-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div style="margin-left: 10%;" class="flex fixed w-4/5 z-50 pb-2 h-24 bottom-0 h-100 bg-white rounded-md bg-opacity-25" v-if="expanded == 2" id="bottom-animation-expanded">-->
<!--        <div class="left flex  pt-2 flex-row ml-24">-->

<!--        </div>-->
<!--    </div>-->
</template>

<script>
import AnimationButtons from "./AnimationButtons";
import {computed, getCurrentInstance, onMounted, reactive, ref, toRaw, unref} from "vue";
import UnityButton from "./UnityButton";


export default {
    name: "AnimationPanel",
    components: {AnimationButtons, UnityButton},
    props: {
        icons: Object,
        animationSave: Object
    },
    emits: ["update:animationSave"],
    setup(props, context) {
        const animation = reactive({layers: []});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        //ANIMATION CONTROLLER
        function swapObjectByIndex(index, object) {


            animation.layers.forEach((obj, index) => {





                if(obj.index == activeLineIndex.value) {
                    animation.layers[index] = toRaw(object.layers);
                }
            })

        }

        const getLineByInternalIndex = computed(() => {
           return toRaw(animation.layers).find(x => x.index == activeLineIndex.value);
            // animation.layers.forEach((obj) => {







            //    if(obj.index == activeLineIndex.value) {
            //        c = toRaw(obj);
            //    }
            // });

        });

        function swapAnimableObjectByIndex(object) {




            getLineByInternalIndex.value.animables[activeAnimableIndex.value].duration = object.duration;

            // .forEach((obj) => {
            //     if(obj.index === activeAnimableIndex.value) {
            //         obj.duration = object.duration;
            //     }
            // });
            // animation.layers[activeLineIndex.value].animables[activeAnimableIndex.value].duration = object.duration;

        }


        function updateAnimationUnity() {


            animation.layers = animation.layers.filter(value => Object.keys(value).length !== 0);
            emitter.emit('unityoutgoingaction', {action: 'updateCurrentAnimation', data: animation});
        }
        //END OF ANIMATION CONTROLLER

        const showAnimableDialog = () => {
            emitter.emit('animationbuttonclick', {val: 'settingsanimable', data: activeAnimableIndex.value});
        }

        const setNewAnimationLayer = () => {

            if(Boolean(getLineByInternalIndex)) {
                emitter.emit('unityoutgoingaction', {action: 'addLine', data: activeLineIndex.value});
            } else {
                emitter.emit('unityoutgoingaction', {action: 'addLine', data: getLineByInternalIndex.index});
            }

        }

        const activeLineIndex = ref(0);
        const activeAnimableIndex = ref(0);
        const expanded = ref(1);

        emitter.on('animationbuttonclick', e => handleClick(e.val));

        // emitter.on('saveLoaded', e => {



        //     animation.layers = JSON.parse(e.save.save_json).layers;
        // })

        const removeLine = (i) => {
            emitter.emit('unityoutgoingaction', {action: 'removeLine', data: i})
        }

        const settingsLine = (i) => {
            // activeLineIndex.value = i;
            // animation.layers.forEach((obj) => {
            //     if(obj.index === activeLineIndex.value) {
            //         obj.temp_index = i;
            //     }
            // });


            setTimeout(() => {
                emitter.emit('UnityLineSettings', {action: 'settingsline', data: getLineByInternalIndex});
            }, 500)

        }

        emitter.on('rightpanelaction', e => {

            if(e.action === 'updateLine' ) {
                if(activeLineIndex.value == undefined) {
                    activeLineIndex.value = 0;
                }
                swapObjectByIndex(activeLineIndex.value, e.data);
            } else if(e.action === 'updateAnimable') {
                if(activeAnimableIndex.value == undefined) {
                    activeAnimableIndex.value = 0;
                }
                swapAnimableObjectByIndex(e.data);

            }

            updateAnimationUnity();

            // emitter.emit('unityoutgoingaction', {action: 'updateCurrentAnimation', data: lines.value[0]});
        });

        emitter.on('UnityAnimationChainUpdate', e => {
            // lines.value = e.layers.layers;

            if(e.layers.layers != undefined) {
                animation.layers = e.layers.layers;
            } else {
                animation.layers = e.layers;
            }


            emitter.emit('updateanimationSave', {data: animation});
        });

        onMounted(() => {




            animation.layers = props.animationSave.layers;
            if(toRaw(animation.layers).length > 0) {
                animation.layers.every((obj) => {
                    activeLineIndex.value = obj.index;
                    return false;
                })
                // activeLineIndex.value = animation.layers[0]
            }
        });

        const handleClick = (val) => {

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
                    expanded.value = 0;
                    emitter.emit('unityoutgoingaction', {action: 'runAnimation', data: {interval: 0, cycles: 0, layers: toRaw(animation)}})
                    break;
                case 'addline':

                    const l = animation.layers.length + Math.floor(Math.random() * 55);

                    emitter.emit('unityoutgoingaction', {action: 'addLine',data: l});
                    activeLineIndex.value = l;
                    setNewAnimationLayer();
                    break;
                case 'removeline':

                    break;
                case 'settingsanimable':





                    emitter.emit('UnityAnimableSettings', {action: 'settingsanimable', data: getLineByInternalIndex.value.animables[activeAnimableIndex.value]})
                    break;
                case 'settingsline':




                    break;
                case 'line':
                    emitter.emit('UnityAnimableSettings', {
                        action: 'removeLine',
                        data: getLineByInternalIndex.animables[activeAnimableIndex.value]
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
            showAnimableDialog,
            animation,
            expanded,
            activeLineIndex,
            activeAnimableIndex,
            setNewAnimationLayer,
            settingsLine,
            removeLine,
            getLineByInternalIndex
        }
    }
}
</script>

<style scoped>

</style>
