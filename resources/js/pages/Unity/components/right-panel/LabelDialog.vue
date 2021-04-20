<template>
    <div>
        <label for="modal-form-1" class="form-label">Tytuł</label>
        <input
            id="modal-form-1"
            type="text"
            class="form-control"
            placeholder=""
            v-model="title"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Kolor</label>
        <VSwatches id="modal-form-2" v-model="color" inline></VSwatches>
    </div>
    <div class="mt-3">
        <label for="modal-form-3" class="form-label">Wielkość etykiety</label>
        <Slider id="modal-form-3" v-model="size" :min="0" :max="15" style="width: 100%;"/>
    </div>
</template>
<style src="@vueform/slider/themes/default.css"></style>
<script>
import VSwatches from "../../../../components/color-swatches/VSwatches";
import {onMounted, ref} from "vue";
import Slider from '@vueform/slider'

export default {
    name: "LabelDialog",
    components: {
        VSwatches, Slider
    },
    setup(props) {
        const color = ref('');
        const title = ref('');
        const size = ref(14);

        onMounted(() => {
            if (props.title != undefined && props.title != '') {
                title.value = props.title;
            }

            if (props.size != undefined && props.size != '') {
                size.value = props.size;
            }

            if (props.color != undefined && props.color != '') {
                color.value = props.color;
            }
        });

        return {
            color,
            title,
            size
        }
    }
}
</script>

<style scoped>

</style>
