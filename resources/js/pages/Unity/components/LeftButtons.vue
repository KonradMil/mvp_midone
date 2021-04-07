<template>
    <div class="flex fixed h-full z-50 pt-10 pr-5">
        <div class="flex-1 pt-10">
            <UnityButton v-for="(icon, index) in icons" :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :key="'leftIcon_' + index" class="w-20 p-5 h-20 hover:transf "/>
        </div>
    </div>
</template>

<script>
import UnityButton from "./UnityButton";
export default {
    name: "LeftButtons",
    props: {
        icons: Array
    },
    components: {UnityButton}
}
</script>

<style scoped>

</style>
