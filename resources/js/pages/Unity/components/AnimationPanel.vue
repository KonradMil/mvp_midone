<template>
    <div class="flex fixed w-full z-50 pb-2 h-24 bottom-0 " :class="(expanded)? 'h-100': 'h-50'" id="bottom-animation">
        <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto;">

        </div>
    </div>
<AnimationButtons :icons="icons"></AnimationButtons>
</template>

<script>
import AnimationButtons from "./AnimationButtons";
import {ref} from "vue";
export default {
    name: "AnimationPanel",
    components: {AnimationButtons},
    props: {
        icons: Object
    },
    setup(props, context) {
        const lines = ref([]);
        const expanded = ref(false);

        return {
            expanded,
            lines
        }
    }
}
</script>

<style scoped>

</style>
