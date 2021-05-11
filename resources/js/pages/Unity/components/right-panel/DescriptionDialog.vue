<template>
    <div class="flex">

    <div class="flex-initial pl-2">
    <div class="mt-3 ">
        <label for="modal-form-3" class="form-label">Solution deadline</label>
        <input
            id="modal-form-3"
            type="text"
            class="form-control"
            placeholder=""
            v-model="c.solution_deadline"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-4" class="form-label">Offer deadline</label>
        <input
            id="modal-form-4"
            type="text"
            class="form-control"
            placeholder=""
            v-model="c.offer_deadline"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-1" class="form-label">Tytuł</label>
        <input
            id="modal-form-1"
            type="text"
            class="form-control"
            placeholder=""
            v-model="c.name"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Opis</label>
        <textarea
            id="modal-form-2"
            class="form-control"
            v-model="c.description"
        />
    </div>
    </div>
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import Multiselect from '@vueform/multiselect'
import cash from "cash-dom";


export default {
    name: "DescriptionDialog",
    props: {
        object: Object
    },
    setup(props, context) {
        const c = ref({description: '', name: '', solution_deadline: '', offer_deadline: ''});


        // const select_detail_weight = ref();

        const types = require("../../../../json/types.json");
        const tagss = require("../../../../json/tagsChallenge.json");


        watch(c, (ca, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:comment", ca);
        }, {deep: true})
        onMounted(() => {

            // if (props.object.name != undefined && props.object.name != '') {
            //     c.value.name = props.object.name;
            // } else {
            //     c.value.name = '';
            // }
            // if (props.object.description != undefined && props.object.description != '') {
            //     c.value.description = props.object.description;
            // } else {
            //     c.value.description = '';
            // }
            // if (props.object.solution_deadline != undefined && props.object.solution_deadline != '') {
            //     c.value.solution_deadline = props.object.solution_deadline;
            // } else {
            //     c.value.solution_deadline = '';
            // }
            // if (props.object.offer_deadline != undefined && props.object.offer_deadline != '') {
            //     c.value.offer_deadline = props.object.offer_deadline;
            // } else {
            //     c.value.offer_deadline = '';
            // }
        });

        return {
            c,
            types,
            // select_detail_weight,
        }
    }
}
</script>

<style scoped>

</style>
