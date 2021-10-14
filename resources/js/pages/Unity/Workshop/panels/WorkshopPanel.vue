<template>

</template>

<script>
import StudioWorkshop from "../StudioWorkshop";
import {ref} from "vue";
export default {
    name: "WorkshopPanel",
    components: {StudioWorkshop},
    setup() {
        const window_width = ref('100%');
        const window_height = ref(0);

        return {
            window_height,
            window_width
        }
    }
}
</script>

<style scoped>

</style>
