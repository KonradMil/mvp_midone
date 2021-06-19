<template>
    <div class="px-5 sm:px-10pt-2">
        <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
            <div class="intro-y col-span-12">
                <table>
                    <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Ilość</th>
                        <th>Cena</th>
                        <th>Suma</th>
                    </tr>
                    </thead>
                    <tbody>
                        <template v-for="(part, index) in finalPartsList">
                            <tr>
                                <td>
                                    {{index}}
                                </td>
                                <td>
                                    {{part.count}}
                                </td>
                                <td>
                                    <input type="text" pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,2}))?)" v-model="partPrices[index].price">
                                </td>
                                <td>
                                    {{part.count * partPrices[index].price}}
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
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
                let tempChallenge = JSON.parse(challenge.value.save_json);

            console.log('PROP PARTS');
            console.log(props.parts);
            console.log(props.parts.length);
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
                                partsAr.value[obj.model_name].count += 1;
                            } else {
                                partsAr.value[obj.model_name] = {
                                    count: 1,
                                    price: 0,
                                };
                            }
                        }
                    });
                    tempChallenge.parts.forEach((objC, index) => {
                        console.log('EVERY');
                        console.log(objC);
                        if(partsAr.value[objC.model.model_name] != undefined) {
                            partsAr.value[objC.model.model_name].count -= 1;
                        }
                    })
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
