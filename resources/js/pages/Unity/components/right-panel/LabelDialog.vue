<template>
    <div>
        <label for="modal-form-1" class="form-label">Tytuł</label>
        <input
            id="modal-form-1"
            type="text"
            class="form-control"
            placeholder=""
            v-model="l.message"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Kolor</label>
        <VSwatches id="modal-form-2" v-model="l.textColor" inline></VSwatches>
    </div>
    <div class="mt-3">
        <label for="modal-form-3" class="form-label">Wielkość etykiety</label>
        <Slider id="modal-form-3" v-model="l.fontSize" :min="0" :max="55" style="width: 100%;"/>
    </div>
</template>
<style src="@vueform/slider/themes/default.css"></style>
<script>
import VSwatches from "../../../../components/color-swatches/VSwatches";
import {onMounted, ref, watch, watchEffect} from "vue";
import Slider from '@vueform/slider'

export default {
    name: "LabelDialog",
    components: {
        VSwatches, Slider
    },
    props: {
        label: Object
    },
    emits: ["update:label"],
    setup(props) {
        const l = ref({fontSize: 36, message: '', textColor: ''});
        watch(l, (lab, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:label", lab);
        })

        onMounted(() => {
            if (props.label.message != undefined && props.label.message != '') {
                 l.value.message = props.label.message;
            } else {
                l.value.message = '';
            }

            if (props.label.fontSize != undefined && props.label.fontSize != '') {
                l.value.fontSize = props.label.fontSize;
            } else {
                l.value.fontSize = 36;
            }

            if (props.label.textColor != undefined && props.label.textColor != '') {
                l.value.textColor = props.label.textColor;
            } else {
                l.value.textColor = '';
            }
        });

        return {
            l
        }
    }
}
</script>

<style scoped>

</style>
