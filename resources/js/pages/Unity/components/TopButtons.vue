<template>
    <div class="flex fixed w-full z-50 pt-2 h-24 top-0 " id="top">
            <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto;">
                <div  v-for="(icon, index) in icons.left" :key="'topIcon_' + index" class="top-i w-30 pl-6">
                    <UnityButton  v-if="icon.type === 'button'" :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="index" position="topbuttonclick"/>
                    <UnityDropdown v-if="icon.type === 'dropdown'" :alttext="icon.alttext" :path="icon.src" :action="index" position="topbuttonclick"></UnityDropdown>
                </div>
            </div>
            <div class="right flex  pt-2 mr-24 flex-row" style="margin-left: auto;">
                <div  v-for="(icon, index) in icons.right" :key="'topIcon_' + index" class="top-i w-30 pl-6">
                    <UnityButton  v-if="icon.type === 'button'" :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="index" position="topbuttonclick"/>
                    <UnityDropdown v-if="icon.type === 'dropdown'" :alttext="icon.alttext" :path="icon.src" :action="index" position="topbuttonclick" :options="icon.options"></UnityDropdown>
                </div>
            </div>
    </div>
</template>

<script>
import UnityButton from "./UnityButton";
import {getCurrentInstance, ref} from "vue";
import UnityDropdown from "./UnityDropdown";

export default {
    name: "TopButtons",
    props: {
        icons: Array,
        allowedEdit: Object
    },
    components: {UnityDropdown, UnityButton},
    setup() {


        return {

        }
    }
}
</script>

<style scoped>

</style>
