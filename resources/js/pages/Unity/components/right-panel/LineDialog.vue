<template>
    <div>
        <label for="modal-form-1" class="form-label">Czas cyklu</label>
        <input
            id="modal-form-1"
            type="number"
            class="form-control"
            placeholder=""
            v-model="l.interval"
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
        <TailSelect
            id="post-form-3"
            v-model="l.model_name"
            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz kategorie...',
                                limit: 'Nie można wybrać więcej',
                                search: false,
                                hideSelected: false,
                                classNames: 'w-full'
                                }">
            <option selected disabled>{{ $t('challengesNew.selectCategories') }}</option>
            <option v-for="detail in detailsAr" :value="detail.model_id">{{ detail.model_name }}</option>
        </TailSelect>
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
        const l = ref({interval: 10, delay: 0, model_name: ''});
        const detailsAr = ref([]);

        watch(l, (lab, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:line", lab);
        }, {deep: true})

        watch(props.line, (lin, prevLabel) => {
            console.log('HERE I GOT AGAINdsadsadsad');
            if (props.line.interval != undefined && props.line.interval != '') {
                lin.interval = props.line.interval;
            } else {
                lin.interval = 10;
            }

            if (props.line.delay != undefined && props.line.delay != '') {
                lin.delay = props.line.delay;
            } else {
                lin.delay = 0;
            }

            if(props.line.cargo != undefined) {
                if (props.line.cargo.model_name != undefined && props.line.cargo.model_name != '') {
                    lin.model_name = props.line.cargo.model_name;
                } else {
                    lin.model_name = 'carton';
                }
            }
            console.log('HERE I GOT AGAIN');
            console.log(props.line);
            console.log(props.line.value);
            console.log(props.line.value.data.value);
            lin.index = props.line.index;
            lin.cargo = props.line.cargo;
            lin.animables = props.line.animables;
        }, {deep: true})

        onMounted(() => {
            detailsAr.value = require('../../../../json/details.json');


        });

        return {
            l,
            detailsAr
        }
    }
}
</script>

<style scoped>

</style>
