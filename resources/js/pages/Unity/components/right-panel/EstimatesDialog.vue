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

        const partsAr = [];

        const additionalCosts = ref([]);
        const partPrices = ref([
            {
                model13: {
                    price: 10
                }
            }
        ]);

        const finalPartsList = computed(() => {
                let tempChallenge = JSON.parse(challenge.value.save_json);

            console.log('PROP PARTS');
            console.log(props.parts);
            console.log(props.parts.length);
                if(props.parts.length != undefined) {
                    props.parts.map((obj) => {
                        console.log('OBJ');
                        console.log(obj);
                        if(partPrices.value[obj.model.model_name] != undefined) {
                            if(partsAr[obj.model.model_name] != undefined) {
                                partsAr[obj.model.model_name].count += 1;
                            } else {
                                partsAr[obj.model.model_name] = {
                                    count: 1,
                                    price: partPrices.value[obj.model.model_name],
                                };
                            }
                        } else {
                            if(partsAr[obj.model.model_name] != undefined) {
                                partsAr[obj.model.model_name].count += 1;
                            } else {
                                partsAr[obj.model.model_name] = {
                                    count: 1,
                                    price: 0,
                                };
                            }
                        }
                       tempChallenge.parts.forEach((objC, index) => {
                           console.log('EVERY');
                           console.log(objC);
                           if(partsAr[objC.model.model_name] != undefined) {
                               partsAr[objC.model.model_name].count -= 1;
                           }
                       })
                    });
                }
        });
        //
        // function comparer(otherArray){
        //     return function(current){
        //         return otherArray.filter(function(other){
        //             console.log(other, current);
        //             return other.unity_id != current.unity_id
        //         }).length == 0;
        //     }
        // }

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
            modelCategories,
            challenge,
            partsAr
        }
    }
}
</script>

<style scoped>

</style>
