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
        solution: Object
    },
    setup(props) {
        const challenge = ref({});
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
            if(challenge.value.save_json != undefined) {
                console.log( JSON.parse(challenge.value.save_json).parts);
                return JSON.parse(props.solution.save_json).parts.filter(part => JSON.parse(challenge.value.save_json).parts.forEach(part2 => !(part2.unity_id == part.unity_id)));
            }
        });

        const getChallenge = () => {
            axios.post('/api/challenge/user/get/card', {id: props.solution.challenge_id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log("response.data.payload");
                        console.log(response.data.payload);
                        console.log(JSON.parse(response.data.payload.save_json));
                        challenge.value = response.data.payload;

                    }
                })
        }

        onMounted(() => {
            getChallenge();
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
