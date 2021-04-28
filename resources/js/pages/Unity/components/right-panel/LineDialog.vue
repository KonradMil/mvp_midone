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
            <option v-for="(detail,index) in details" :value="detail.model_name">{{ detail.model_name }}</option>
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
        const details = ref([]);

        watch(l, (lab, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:line", lab);
        }, {deep: true})

        onMounted(() => {
            details.value = require('../../../../json/details.json');
            if (props.line.interval != undefined && props.line.interval != '') {
                l.value.interval = props.line.interval;
            } else {
                l.value.interval = 10;
            }

            if (props.line.delay != undefined && props.line.delay != '') {
                l.value.delay = props.line.delay;
            } else {
                l.value.delay = 0;
            }

            if (props.line.cargo.model_name != undefined && props.line.cargo.model_name != '') {
                l.value.model_name = props.line.cargo.model_name;
            } else {
                l.value.model_name = 'carton';
            }
            l.value.index = props.line.index;
        });

        return {
            l,
            details
        }
    }
}
</script>

<style scoped>

</style>
