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
            v-model="selected"
            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz kategorie...',
                                limit: 'Nie można wybrać więcej',
                                search: false,
                                hideSelected: false,
                                classNames: 'w-full'
                                }">
            <option selected disabled>{{ $t('challengesNew.selectCategories') }}</option>
            <option v-for="(detail, index) in detailsAr" :value="index">{{ detail.model_name }}</option>
        </TailSelect>
    </div>
</template>
<script>
import {getCurrentInstance, onMounted, ref, watch, watchEffect} from "vue";

export default {
    name: "LineDialog",
    components: {

    },
    props: {
        modelValue: Object
    },
    emits: ["update:modelValue"],
    setup(props, context) {
        const l = ref({interval: 10, delay: 0, model_name: '', cargo: {
                model_name: "9195a37a-9a13-12e3-8591-012165a3a613",
                model_id: "Karton średni",
                prefab_url: window.app_path + "/models/carton_sredni",
                additional_data: ""
            }, animables: []});
        const selected = ref(0);
        const detailsAr = ref([]);


        watch(l, (lab, prevLabel) => {



            context.emit("update:modelValue", lab);
        }, {deep: true})


        watch(selected, (lab, prevLabel) => {


            l.value.cargo.model_name = detailsAr.value[lab].model_name;
            l.value.cargo.model_id = detailsAr.value[lab].model_id;
            l.value.cargo.prefab_url = window.app_path + detailsAr.value[lab].prefab_url;
            context.emit("update:line", lab);

        }, {deep: true})


        onMounted(() => {


            if (props.modelValue.data.interval != undefined && props.modelValue.data.interval != '') {
                l.value.interval = parseInt(props.modelValue.data.interval);
            } else {
                l.value.interval = 10;
            }

            if (props.modelValue.data.delay != undefined && props.modelValue.data.delay != '') {
                l.value.delay = parseInt(props.modelValue.data.delay);
            } else {
                l.value.delay = 0;
            }

            if(props.modelValue.data.cargo != undefined) {
                if (props.modelValue.data.cargo.model_name != undefined && props.modelValue.data.cargo.model_name != '') {
                    l.value.model_name = props.modelValue.data.cargo.model_name;
                } else {
                    l.value.model_name = 'carton';
                }
            }



            l.value.index = parseInt(props.modelValue.data.index);
            l.value.cargo = props.modelValue.data.cargo;
            l.value.animables = props.modelValue.data.animables;

            detailsAr.value = require('../../../../json/details.json');
        });

        return {
            l,
            detailsAr,
            selected
        }
    }
}
</script>

<style scoped>

</style>
