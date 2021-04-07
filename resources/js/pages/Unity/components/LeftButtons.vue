<template>
    <div class="flex fixed h-full z-50 pt-2">
        <div class="flex-1 pt-2 ml-10">
            <UnityButton v-for="(icon, index) in icons" :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :key="'leftIcon_' + index" :action="index" />
        </div>
    </div>
</template>

<script>
import UnityButton from "./UnityButton";
import {getCurrentInstance} from "vue";
export default {
    name: "LeftButtons",
    props: {
        icons: Array
    },
    components: {UnityButton},
    setup() {

    }
}
</script>

<style scoped>

</style>
