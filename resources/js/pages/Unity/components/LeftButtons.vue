<template>
    <div class="flex fixed h-full z-50 pt-14" style="pointer-events: none;">
        <div class="flex-1 pt-2 ml-10">
            <div :class="(category == icon.value)?'left-button-category-active':''" v-for="(icon, index) in icons" :key="'leftIcon_' + index" class="unity-button">
                <UnityButton :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="icon.value" position="leftbuttonclick"/>
            </div>
        </div>
    </div>
</template>

<script>
import UnityButton from "./UnityButton";
import {getCurrentInstance, ref} from "vue";

export default {
    name: "LeftButtons",
    props: {
        icons: Array,
        allowedEdit: Boolean
    },
    components: {UnityButton},
    setup() {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const category = ref(null);
        emitter.on('leftbuttonclick', e => handleChange(e.val));

        const handleChange = (cat_id) => {
            if (category.value === cat_id) {
                category.value = null;
            } else {
                category.value = cat_id;
            }
        }

        return {
            category
        }
    }
}
</script>

<style scoped>

</style>
