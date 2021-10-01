<template>
    <div class="flex fixed w-full z-50 pt-2 h-24 top-0 " id="top" style="pointer-events: none;">
            <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto;">
                <div  v-for="(icon, index) in icons.left" :key="'topIcon_' + index" class="top-i w-30 pl-6 unity-button">
                    <UnityButton  v-if="icon.type === 'button'" :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="index" position="topbuttonclick"/>
                    <UnityDropdown v-if="icon.type === 'dropdown'" :alttext="icon.alttext" :path="icon.src" :action="index" position="topbuttonclick"></UnityDropdown>
                </div>
            </div>
            <div class="right flex  pt-2 mr-24 flex-row" style="margin-left: auto;" v-if="icons.right != undefined">
                <div :key="'topIcon_fullscreen'" class="top-i w-30 pl-6 unity-button">
                    <UnityButton :tooltip="''" :alttext="''" :path="'/s3/builder_icons/fullscreen_simple.png'" :action="'fullscreen'" position="topbuttonclick"/>
<!--                    <UnityDropdown v-if="icon.type === 'dropdown'" :alttext="icon.alttext" :path="icon.src" :action="index" position="topbuttonclick" :options="icon.options"></UnityDropdown>-->
                </div>
                <div :key="'topIcon_logout'" class="top-i w-30 pl-6 unity-button">
                    <UnityButton :tooltip="''" :alttext="''" :path="'/s3/builder_icons/logout_simple.png'" :action="'logout'" position="topbuttonclick"/>
<!--                    <UnityDropdown v-if="icon.type === 'dropdown'" :alttext="icon.alttext" :path="icon.src" :action="index" position="topbuttonclick" :options="icon.options"></UnityDropdown>-->
                </div>
                <div :key="'topIcon_eye'" class="top-i w-30 pl-6 unity-button">
<!--                    <UnityButton  v-if="icon.type === 'button'" :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="index" position="topbuttonclick"/>-->
                    <UnityDropdown :alttext="''" :path="'/s3/builder_icons/eye_simple3.png'" :action="'eye'" position="topbuttonclick" :options="icons.right['eye'].options"></UnityDropdown>
                </div>
                <div :key="'topIcon_save'" class="top-i w-30 pl-6 unity-button" v-if="allowedEdit">
                    <UnityButton tooltip="''" :alttext="''" :path="'/s3/builder_icons/save_simple.png'" :action="'save'" position="topbuttonclick"/>
                </div>
                <div :key="'topIcon_help'" class="top-i w-30 pl-6 unity-button" v-if="allowedEdit">
                    <UnityButton :alttext="''" :path="'/s3/builder_icons/help_simple.png'" :action="'help'" position="topbuttonclick" ></UnityButton>
                </div>
            </div>
    </div>
</template>

<script>
import UnityButton from "./UnityButton";
import {getCurrentInstance, onMounted, ref, watch} from "vue";
import UnityDropdown from "./UnityDropdown";

export default {
    name: "TopButtons",
    props: {
        icons: Array,
        allowedEdit: Boolean,
        canEditSolution: Boolean
    },
    components: {UnityDropdown, UnityButton},
    setup(props) {


        onMounted(() => {
        });

        return {

        }
    }
}
</script>

<style scoped>

</style>
