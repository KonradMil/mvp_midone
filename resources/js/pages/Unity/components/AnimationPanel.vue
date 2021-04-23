<template>
    <div class="flex fixed w-full z-50 pb-2 h-24 bottom-0 h-28" v-if="expanded == 0" id="bottom-animation-minimalized">
        <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto;">
            <AnimationButtons :icons="icons"></AnimationButtons>
        </div>
    </div>
    <div class="flex fixed w-full z-50 pb-2 h-24 bottom-0 "  v-if="expanded == 1"id="bottom-animation-normal">
        <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto;">

        </div>
    </div>
    <div class="flex fixed w-full z-50 pb-2 h-24 bottom-0 "  v-if="expanded == 2" :class="(expanded)? 'h-100': 'h-50'" id="bottom-animation-expanded">
        <div class="left flex  pt-2 flex-row ml-24" style="margin-right: auto;">

        </div>
    </div>
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
        const expanded = ref(0);

        return {
            expanded,
            lines
        }
    }
}
</script>

<style scoped>

</style>
