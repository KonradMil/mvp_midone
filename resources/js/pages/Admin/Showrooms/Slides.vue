<template>
        <Box v-for="(slide, index) in slides" :key="'slide_' + index">
            <h4>{{slide.title}}</h4>
        </Box>
</template>

<script>
import {onMounted, ref} from "vue";
import Box from "../../../components-terraform/Box";

export default {
    name: "Slides",
    components: {Box},
    props: {
        slides: {
            type: Array
        }
    },
    setup(props, {emit}) {
        const slides = ref([]);

        onMounted(() => {
            slides.value = props.slides;
        });
    }
}
</script>

<style scoped>

</style>
