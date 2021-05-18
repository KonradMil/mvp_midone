<template>

</template>

<script>
import {onMounted, ref} from "vue";
// import Multiselect from '@vueform/multiselect'

export default {
    name: "FinancialAnalysisDialog",
    // components: {Multiselect},
    props: {
        object: Object,
        technical: Object,
        id: Number
    },
    setup(props) {
        const sels = require("../../../../json/challenge.json");

        const t = ref('');
        // const select_detail_pick = ref();
        const select_work_shifts = ref();
        const work = ref();

        console.log('Financial.ID!!!!' + props.technical.id);
        const challengeSelects = ref();
        onMounted(() => {
            challengeSelects.value = sels;
            // t.value = props.technical
            // select_detail_pick.value = sels.select_detail_pick.find(i => i.value === object.detail_pick).name
            // c.value = props.object

        });

        return {
            sels,
            select_work_shifts,
            t,
            // select_detail_pick,
        }
    }
}
</script>

<style scoped>

</style>
