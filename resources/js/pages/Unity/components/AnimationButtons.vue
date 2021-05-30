<template>
    <div v-for="(icon, index) in icons" :key="'animationIcon_' + index" class="bot-i"  style="pointer-events: none;">
        <UnityButton  :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="index" position="animationbuttonclick" class="unity-button"/>
    </div>
</template>

<script>
import UnityButton from './UnityButton'

export default {
    name: "AnimationButtons",
    components: {
      UnityButton
    },
    props: {
      icons: Object
    },
    setup() {

    }
}
</script>

<style scoped>

</style>
