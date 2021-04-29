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
import {getCurrentInstance, onMounted, ref, watch, watchEffect} from "vue";

export default {
    name: "LineDialog",
    components: {

    },
    props: {
        line: Object
    },
    emits: ["update:line"],
    setup(props, context) {
        const l = ref({interval: 10, delay: 0, model_name: '', cargo: {}, animables: []});
        const detailsAr = ref([]);

        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        watch(l, (lab, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:line", lab);
        }, {deep: true})


        onMounted(() => {
            console.log('HERE I GOT AGAINAAAA');
            console.log(props.line);
            if (props.line.data.interval != undefined && props.line.data.interval != '') {
                l.value.interval = toInteger(props.line.data.interval);
            } else {
                l.value.interval = 10;
            }

            if (props.line.data.delay != undefined && props.line.data.delay != '') {
                l.value.delay = toInteger(props.line.data.delay);
            } else {
                l.value.delay = 0;
            }

            if(props.line.data.cargo != undefined) {
                if (props.line.data.cargo.model_name != undefined && props.line.data.cargo.model_name != '') {
                    l.value.model_name = props.line.data.cargo.model_name;
                } else {
                    l.value.model_name = 'carton';
                }
            }

            console.log('HERE I GOT AGAIN');
            console.log(props.line.data);
            l.value.index = toInteger(props.line.data.index);
            l.value.cargo = props.line.data.cargo;
            l.value.animables = props.line.data.animables;

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
