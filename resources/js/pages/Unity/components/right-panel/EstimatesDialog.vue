<template>
    <div class="px-5 sm:px-10pt-2">
        <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
            <div class="intro-y col-span-12">

            </div>
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref} from "vue";


export default {
    name: "EstimatesDialog",

    props: {
        challenge: Object,
        solution: String
    },
    setup(props) {
        const user = window.Laravel.user;
        const basicDataValues = require("../../../../json/challenge.json");
        const modelCategories = require("../../../../json/model_categories.json");

        const basicCosts = reactive({
            mechanical_integration: 0,
            electrical_integration: 0,
            workstation_integration: 0,
            programming_robot: 0,
            programming_plc: 0,
            documentation_ce: 0,
            training: 0,
            project: 0,
            margin: 0,
        });

        const additionalCosts = ref([]);


        const partPrices = ref([]);

        const finalPartsList = computed(() => {
            return props.solution.save_json.parts.filter(part => props.challenge.save_json.parts.every(part2 => !part2.unity_id.includes(part.unity_id)));
        });

        onMounted(() => {

        });

        return {
            user,
            finalPartsList,
            partPrices,
            additionalCosts,
            basicCosts,
            basicDataValues,
            modelCategories
        }
    }
}
</script>

<style scoped>

</style>
