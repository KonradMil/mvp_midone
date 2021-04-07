<template>
    <div class="flex fixed h-full z-50">
        <div class="flex-1 pt-10">
            <UnityButton v-for="(icon, index) in icons" :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" class="w-10 h-10 hover:transf "/>
        </div>
    </div>
</template>

<script>
import UnityButton from "./UnityButton";
export default {
    name: "LeftButtons",
    components: {UnityButton}
}
</script>

<style scoped>

</style>
