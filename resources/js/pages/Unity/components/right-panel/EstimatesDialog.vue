<template>
    <div class="px-5 sm:px-10pt-2">
        <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
            <div class="intro-y col-span-12">

            </div>
        </div>
    </div>
</template>

<script>
import {computed, getCurrentInstance, onMounted, reactive, ref} from "vue";


export default {
    name: "EstimatesDialog",

    props: {
        solution: Object,
        parts: Array
    },
    setup(props) {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const challenge = ref({});
        const user = window.Laravel.user;
        const basicDataValues = require("../../../../json/challenge.json");
        const modelCategories = require("../../../../json/model_categories.json");
        // const finalPartsList = ref([]);

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
                let c = props.parts;
                if(c.length != undefined) {
                JSON.parse(challenge.value.save_json).parts.forEach((obj, indx) => {
                    console.log(indx);
                    c.every((obj2) => {
                        console.log(obj.model.model_name);
                        console.log(obj2.model_name);
                        if (obj.model.model_name == obj2.model_name) {
                            c.splice(indx, 1);
                            return false;
                        }
                    });
            });
                }

                return c;
        });

        function comparer(otherArray){
            return function(current){
                return otherArray.filter(function(other){
                    console.log(other, current);
                    return other.unity_id != current.unity_id
                }).length == 0;
            }
        }

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
