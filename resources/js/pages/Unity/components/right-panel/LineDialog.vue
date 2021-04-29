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
        const l = ref({interval: 10, delay: 0, model_name: ''});
        const detailsAr = ref([]);

        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        emitter.on('settingsline', e => {
            if (e.interval != undefined && e.interval != '') {
                l.interval = e.interval;
            } else {
                l.interval = 10;
            }

            if (e.delay != undefined && e.delay != '') {
                l.delay = e.delay;
            } else {
                l.delay = 0;
            }

            if(e.cargo != undefined) {
                if (e.cargo.model_name != undefined && e.cargo.model_name != '') {
                    l.model_name = e.cargo.model_name;
                } else {
                    l.model_name = 'carton';
                }
            }
            console.log('HERE I GOT AGAIN');
            console.log(props.line);
            console.log(props.line.value);
            console.log(props.line.value.data.value);
            l.index = props.line.index;
            l.cargo = props.line.cargo;
            l.animables = props.line.animables;
        });

        watch(l, (lab, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:line", lab);
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
