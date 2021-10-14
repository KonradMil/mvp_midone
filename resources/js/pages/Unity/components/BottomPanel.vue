<template>
    <AnimationPanel v-if="mode == 'animation'" :icons="animation_icons" v-model:animationSave="animationSave"></AnimationPanel>
    <div v-if="mode == 'edit' || mode == 'layout'" class="flex fixed w-full z-50 pb-2 h-24 bottom-0 " id="bottom">
        <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto;">
            <div  v-if="mode == 'edit'" class="bot-i w-30 pl-6 unity-button">
                <div class="dropdown">
                    <button
                        class="dropdown-toggle"
                        aria-expanded="false"
                    >
                        <div class="w-20 py-2 text-center flex justify-center items-center">
                            <div class="w-14 h-14 flex-none image-fit overflow-hidden zoom-in">
                                <img class=""
                                     alt="Siatka"
                                     src="/s3/builder_icons/grid_simple.png"
                                />
                            </div>
                        </div>
                    </button>
                    <div class="dropdown-menu w-36">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <Slider v-model="gridSize" :min="0" :max="15" style="width: 100%;" @change="changeGridSize"/>
                        </div>
                    </div>
                </div>
            </div>
<!--            <div  v-if="mode == 'animation'" v-for="(icon, index) in animation_icons" :key="'animationIcon_' + index" class="bot-i w-30 pl-6">-->
<!--                <UnityButton    :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="index" position="animationbuttonclick" />-->
<!--            </div>-->
            <div  v-if="mode == 'layout'" v-for="(icon, index) in layout_icons" :key="'layoutIcon_' + index" class="bot-i w-30 pl-6 unity-button">
                <UnityButton    :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="index" position="layoutbuttonclick" />
            </div>
        </div>
    </div>
</template>
<style src="@vueform/slider/themes/default.css"></style>
<script>
import {computed, getCurrentInstance, onMounted, ref, watch} from "vue";
import cash from "cash-dom";
import AnimationPanel from "./AnimationPanel";
import UnityButton from "./UnityButton";
import Slider from '@vueform/slider'

export default {
    name: "BottomPanel",
    components: {AnimationPanel, UnityButton, Slider},
    props: {
        mode: String,
        animationSave: Object,
        allowedEdit: Boolean
    },
    emits: ["update:animationSave"],
    setup(props, context) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const animation_icons = ref([]);
        const edit_icons = ref([]);
        const layout_icons = ref([]);
        const gridSize = ref(0);

        const animationSave = computed({
            get: () => props.animationSave,
            set: (value) => emit('update:animationSave', value),
        });
        const changeGridSize = (val) => {
            gridSize.value = val;
            emitter.emit('gridsizechange', { val: val })
        }



        // watch(animationSave, (lab, prevLabel) => {
        //   emitMe(lab);
        // }, {deep: true})

        // watch(props.animationSave, (lab, prevLabel) => {
        //     animationSaves.value = lab;
        // }, {deep: true})

        // function emitMe(lab) {
        //     context.emit("update:animationSave", lab);
        // }

        onMounted(()=> {
            // animationSave.value = props.animationSave;
            //REMOVES PADDING
            cash("body")
                .removeClass("main")
                .removeClass("error-page")
            const  li = require("../../../json/unity_layout_buttons.json");
            layout_icons.value = li.icons;
            const  ei = require("../../../json/unity_edit_buttons.json");
            edit_icons.value = ei.icons;
            const  ai = require("../../../json/unity_animation_buttons.json");
            animation_icons.value = ai.icons;
        });

        return {
            animationSave,
            layout_icons,
            edit_icons,
            animation_icons,
            gridSize,
            changeGridSize
        }
    }
}
</script>

<style scoped>

</style>
