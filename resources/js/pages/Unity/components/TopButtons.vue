<template>
    <div class="flex fixed w-full z-50 pt-2 h-24 top-0">
        <div class="flex-1 pt-2 ml-10">
            <div :class="(category == icon.value)?'left-button-category-active':''" v-for="(icon, index) in icons" :key="'leftIcon_' + index">
                <UnityButton    :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="icon.value" position="topbuttonclick"/>
            </div>
        </div>
    </div>
</template>

<script>
import UnityButton from "./UnityButton";
import {getCurrentInstance, ref} from "vue";

export default {
    name: "TopButtons",
    props: {
        icons: Array
    },
    components: {UnityButton},
    setup() {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const category = ref(null);
        emitter.on('topbuttonclick', e =>  handleChange(e.val) );
        const handleChange = (val) => {
            console.log(val);
        }
        return {
            category
        }
    }
}
</script>

<style scoped>

</style>
