<template>
    <div>
        <label for="modal-form-1" class="form-label">Czas cyklu</label>
        <input
            id="modal-form-1"
            type="number"
            class="form-control"
            placeholder=""
            v-model="l.cycleTime"
        />
    </div>
    <div>
        <label for="modal-form-2" class="form-label">Opóźnienie</label>
        <input
            id="modal-form-2"
            type="number"
            class="form-control"
            placeholder=""
            v-model="l.delay"
        />
    </div>
    <div>
        <label for="modal-form-1" class="form-label">Detal</label>
<!--        <input-->
<!--            id="modal-form-1"-->
<!--            type="text"-->
<!--            class="form-control"-->
<!--            placeholder=""-->
<!--            v-model="l.message"-->
<!--        />-->
    </div>
</template>
<script>
import {onMounted, ref, watch, watchEffect} from "vue";

export default {
    name: "LineDialog",
    components: {

    },
    props: {
        line: Object
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
            details.value = require('../../../../json/details.json');
            if (props.label.cycleTime != undefined && props.label.cycleTime != '') {
                l.value.cycleTime = props.label.cycleTime;
            } else {
                l.value.cycleTime = 10;
            }

            if (props.label.delay != undefined && props.label.delay != '') {
                l.value.delay = props.label.delay;
            } else {
                l.value.delay = 0;
            }

            if (props.label.selectedDetail != undefined && props.label.selectedDetail != '') {
                l.value.selectedDetail = props.label.selectedDetail;
            } else {
                l.value.selectedDetail = 'carton';
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
