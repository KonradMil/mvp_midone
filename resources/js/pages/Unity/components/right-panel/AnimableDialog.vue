<template>
    <div>
        <label for="modal-form-1" class="form-label">Czas cyklu</label>
        <input
            id="modal-form-1"
            type="text"
            class="form-control"
            placeholder=""
            v-model="l.message"
        />
    </div>

    <div class="mt-3">
        <label for="modal-form-3" class="form-label">Wielkość etykiety</label>
        <Slider id="modal-form-3" v-model="l.delay" :min="0" :max="55" style="width: 100%;"/>
    </div>
</template>
<style src="@vueform/slider/themes/default.css"></style>
<script>
import VSwatches from "../../../../components/color-swatches/VSwatches";
import {onMounted, ref, watch, watchEffect} from "vue";
import Slider from '@vueform/slider'

export default {
    name: "AnimableDialog",
    components: {
        VSwatches, Slider
    },
    props: {
        label: Object
    },
    emits: ["update:line"],
    setup(props, context) {
        const l = ref({cycleTime: 36, delay: '', selectedDetail: ''});
        const details = ref([]);

        watch(l, (lab, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:line", lab);
        }, {deep: true})

        onMounted(() => {
            if (props.label.cycleTime != undefined && props.label.cycleTime != '') {
                l.value.cycleTime = props.label.cycleTime;
            } else {
                l.value.cycleTime = '';
            }

            if (props.label.delay != undefined && props.label.delay != '') {
                l.value.delay = props.label.delay;
            } else {
                l.value.delay = 36;
            }

            if (props.label.selectedDetail != undefined && props.label.selectedDetail != '') {
                l.value.selectedDetail = props.label.selectedDetail;
            } else {
                l.value.selectedDetail = '#222F3D';
            }
            l.value.index = props.label.index;
        });

        return {
            l
        }
    }
}
</script>

<style scoped>

</style>
