<template>
    <div class="flex fixed h-full z-50">
        <div class="flex-1">
            <UnityButton tooltip="cos" alttext="alt_text" path="/s3/builder_icons/chair_simple.png" class="w-10 h-10"/>
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
