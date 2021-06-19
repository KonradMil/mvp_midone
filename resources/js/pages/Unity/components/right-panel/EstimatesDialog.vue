<template>
    <div class="px-5 sm:px-10pt-2">
        <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
            <div class="intro-y col-span-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Nazwa</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Ilość</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Cena</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Suma</th>
                    </tr>
                    </thead>
                    <tbody>
                        <template v-for="(part, index) in partsAr">
                            <tr class="hover:bg-gray-200">
                                <td class="border">
                                    {{index}}
                                </td>
                                <td class="border">
                                    {{part.count}}
                                </td>
                                <td class="border">
                                    <input type="text" v-if="partPrices[index] != undefined" class="form-control" pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,2}))?)" v-model="partPrices[index].price">
                                </td>
                                <td class="border">
                                    <span v-if="partPrices[index] != undefined">
                                        {{part.count * partPrices[index].price}}
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-1" class="form-label">

                </label>
                <input type="number" v-model="basicCosts.mechanical_integration" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
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

        const partsAr = ref({});

        const additionalCosts = ref([]);
        const partPrices = ref({});

        const finalPartsList = computed(() => {



                if(props.parts.length != undefined) {
                    props.parts.forEach((obj) => {
                        console.log('OBJ');
                        console.log(obj);
                        if(partPrices.value[obj.model_name] != undefined) {
                            if(partsAr.value[obj.model_name] != undefined) {
                                partsAr.value[obj.model_name].count += 1;
                            } else {
                                partsAr.value[obj.model_name] = {
                                    count: 1,
                                    price: partPrices.value[obj.model_name],
                                };
                            }
                        } else {
                            if(partsAr.value[obj.model_name] != undefined) {
                                partPrices.value[obj.model_name] = 0;
                                partsAr.value[obj.model_name].count += 1;
                            } else {
                                partPrices.value[obj.model_name] = 0;
                                partsAr.value[obj.model_name] = {
                                    count: 1,
                                    price: 0,
                                };
                            }
                        }
                    });
                    try {
                        let tempChallenge = JSON.parse(challenge.value.save_json);
                        tempChallenge.parts.forEach((objC, index) => {
                            console.log('EVERY');
                            console.log(objC);
                            if(partsAr.value[objC.model.model_name] != undefined) {
                                partsAr.value[objC.model.model_name].count -= 1;
                            }
                        })
                    }catch (e) {

                    }

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
