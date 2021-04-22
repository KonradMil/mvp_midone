<template>
    <div>
        <label for="modal-form-1" class="form-label">Tytuł</label>
        <input
            id="modal-form-1"
            type="text"
            class="form-control"
            placeholder=""
            v-model="label.message"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Kolor</label>
        <VSwatches id="modal-form-2" v-model="label.textColor" inline></VSwatches>
    </div>
    <div class="mt-3">
        <label for="modal-form-3" class="form-label">Wielkość etykiety</label>
        <Slider id="modal-form-3" v-model="label.fontSize" :min="0" :max="15" style="width: 100%;"/>
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
    props: {
        label: Object
    },
    setup(props) {
        const color = ref('');
        const title = ref('');
        const size = ref(14);

        onMounted(() => {
            if (props.label.message != undefined && props.label.message != '') {
                // title.value = props.title;
            } else {
                props.label.message = '';
            }

            if (props.label.fontSize != undefined && props.label.fontSize != '') {
                // size.value = props.size;
            } else {
                props.label.fontSize = 36;
            }

            if (props.label.textColor != undefined && props.label.textColor != '') {
                // color.value = props.color;
            } else {
                props.label.textColor = '';
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
