<template>
    <Studio hideFooter="true" :src="unity_path" :width="window_width" unityLoader="/UnityLoader.js" ref="gameWindow"/>
</template>

<script>
import Studio from "./Studio";
import {onBeforeMount, onMounted, ref} from "vue";
export default {
name: "Main",
    components: {Studio},
    setup(props, {emit}) {
    const unity_path = ref('/s3/unity/AssemBrot19_03.json');
    const window_width = ref('100%');

        onBeforeMount(() => {

        });

        onMounted(()=> {

        });

        return {
            unity_path,
            window_width
        }
    }
}
</script>
