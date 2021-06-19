<template>
    <div class="px-5 sm:px-10pt-2">
        <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
            <div class="intro-y col-span-12">
                <h4>Części i urządzenia</h4>
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
                                    <input type="text" v-if="partPrices[index] != undefined" class="form-control" pattern="(0\.((0[1-9]{1})|([1-9]{1}([0-9]{1})?)))|(([1-9]+[0-9]*)(\.([0-9]{1,2}))?)" v-model="partPrices[index]">
                                </td>
                                <td class="border">
                                    <span v-if="partPrices[index] != undefined">
                                        {{part.count * partPrices[index]}}
                                    </span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="divide-gray-200"></div>
            <h4>Koszty podstawowe</h4>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <label for="input-wizard-1" class="form-label">
                    Integracja mechaniczna + materiały
                </label>
                <input type="number" v-model="basicCosts.mechanical_integration" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
            </div>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <label for="input-wizard-2" class="form-label">
                    Integracja elektryczna + materiały
                </label>
                <input type="number" v-model="basicCosts.electrical_integration" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
            </div>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <label for="input-wizard-3" class="form-label">
                    Integracja stanowiska z linią
                </label>
                <input type="number" v-model="basicCosts.workstation_integration" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-0" class="form-label">
                    Projekt wykonawczy
                </label>
                <input type="number" v-model="basicCosts.project" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-4" class="form-label">
                    Programowanie robota
                </label>
                <input type="number" v-model="basicCosts.programming_robot" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-5" class="form-label">
                    Programowanie PLC
                </label>
                <input type="number" v-model="basicCosts.programming_plc" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-6" class="form-label">
                    Dokumentacja CE
                </label>
                <input type="number" v-model="basicCosts.documentation_ce" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-7" class="form-label">
                    Szkolenie
                </label>
                <input type="number" v-model="basicCosts.training" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-8" class="form-label">
                   Marża
                </label>
                <input type="number" v-model="basicCosts.margin" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
            </div>
            <div class="divide-gray-200"></div>
            <h4>Pozostałe koszty</h4>
            <template v-for="(obj, index) in additionalCosts">
                <div class="intro-y col-span-12 sm:col-span-12" >
                    <label :for="'input-wizard-' + index" class="form-label">
                        <input type="text" class="form-control" v-model="obj.name"/>
                    </label>
                    <input type="number" v-model="obj.price" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                </div>
            </template>
            <div class="intro-y col-span-12 sm:col-span-12" >
            <a
                @click.prevent="addCost"
                href=""
                class="intro-x w-full block text-center rounded-md py-3 mt-3 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600">

              <span>
                  Dodaj koszt
              </span>

            </a>
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

        const addCost = () => {
            additionalCosts.value.push({
                name: 'Nowy koszt',
                price: 0
            });
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
            partsAr,
            addCost
        }
    }
}
</script>

<style scoped>

</style>
