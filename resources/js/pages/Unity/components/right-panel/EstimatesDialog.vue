<template>
    <div class="px-5 sm:px-10pt-2">
        <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
            <div class="intro-y col-span-12">

                <p class="alert alert-warning show">Przed wprowadzeniem zmian upewnij się, że kursor znajduje się we właściwym polu.</p><br>
                <div class="intro-y col-span-12 sm:col-span-12" >
                    <h3>Części i urządzenia</h3>
                </div>
                <button class="btn btn-primary hidden sm:flex my-2"  @click="refreshMe">
                    Aktualizuj części
                </button>

                <table class="table">
                    <thead>
                    <tr>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Nazwa</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Ilość</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Cena</th>
                    </tr>
                    </thead>
                        <template v-for="(part, index) in partsAr">

                            <tbody class="hover:bg-gray-200 border-b-2 ">
                                <tr>
                                    <td class="border" rowspan="2">
                                        {{index}}
                                    </td>
                                    <td class="border">
                                        {{part.count}}
                                    </td>
                                    <td class="border">
                                        <input type="text" v-if="partPrices[index] != undefined" class="form-control"   pattern="[0-9]+([\.,][0-9]+)?" step="0.01" v-model="partPrices[index]">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border" colspan="2">
                                        Suma: <span v-if="partPrices[index] != undefined">{{part.count * partPrices[index]}}</span>
                                    </td>
                                </tr>
                            </tbody>

                        </template>
                </table>
            </div>
            <div class="divide-gray-200"></div>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <h4>Koszty podstawowe</h4>
            </div>

            <div class="intro-y col-span-12 sm:col-span-12" >
                <label for="input-wizard-1" class="form-label">
                    Integracja mechaniczna + materiały
                </label>
                <div class="input-group">
                    <input type="text" v-model="basicCosts.mechanical_integration" class="form-control" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                    <div id="input-group-price63242" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <label for="input-wizard-2" class="form-label">
                    Integracja elektryczna + materiały
                </label>
                <div class="input-group">
                <input type="text" v-model="basicCosts.electrical_integration" class="form-control" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                <div id="input-group-price623422" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <label for="input-wizard-3" class="form-label">
                    Integracja stanowiska z linią
                </label>
                <div class="input-group">
                <input type="text" v-model="basicCosts.workstation_integration" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                <div id="input-group-price6234" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-0" class="form-label">
                    Projekt wykonawczy
                </label>
                <div class="input-group">
                <input type="text" v-model="basicCosts.project" class="form-control" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                <div id="input-group-price63247" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-4" class="form-label">
                    Programowanie robota
                </label>
                <div class="input-group">
                <input type="text" v-model="basicCosts.programming_robot" class="form-control" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                <div id="input-group-price6324" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-5" class="form-label">
                    Programowanie PLC
                </label>
                <div class="input-group">
                <input type="text" v-model="basicCosts.programming_plc" class="form-control" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                <div id="input-group-price634" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-6" class="form-label">
                    Dokumentacja CE
                </label>
                <div class="input-group">
                <input type="text" v-model="basicCosts.documentation_ce" class="form-control" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                <div id="input-group-price234" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-7" class="form-label">
                    Szkolenie
                </label>
                <div class="input-group">
                <input type="text" v-model="basicCosts.training" class="form-control" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                <div id="input-group-price34" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6" >
                <label for="input-wizard-8" class="form-label">
                   Marża
                </label>
                <div class="input-group">
                <input type="text" v-model="basicCosts.margin" class="form-control" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                <div id="input-group-price90" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="divide-gray-200"></div>
            <div class="intro-y col-span-12 sm:col-span-12" >
            <h4>Pozostałe koszty</h4>
            </div>
            <template v-for="(obj, index) in additionalCosts">
                <div class="intro-y col-span-12 sm:col-span-12" >
                    <label :for="'input-wizard-' + index" class="form-label w-1/2">
                        <input type="text" class="form-control" v-model="obj.name"/>
                    </label>
                    <div class="input-group">
                    <input type="text" v-model="obj.price" class="form-control w-1/2" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                    <div class="input-group-text">zł</div>
                    </div>
                </div>
            </template>
            <div class="intro-y col-span-12 sm:col-span-12" >
            <a @click.prevent="addCost" href="" class="intro-x w-full block text-center rounded-md py-3 mt-3 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600">
              <span>
                  Dodaj koszt
              </span>
            </a>
            </div>
            <div class="divide-gray-200"></div>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <h4>Sumy</h4>
            </div>
            <div class="intro-y col-span-12 sm:col-span-12" >
            <button class="btn btn-primary hidden sm:flex mt-2"  @click="refreshMe">
                Aktualizuj części
            </button>
            </div>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <label for="input-wizard-11242" class="form-label">
                    Koszty części
                </label>
                <div class="input-group">
                    <input type="text" v-model="partsCost" class="form-control"  disabled :aria-label="$t('challengesNew.numberSupported')" />
                    <div id="input-group-price512123422" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <label for="input-wizard-12412" class="form-label">
                    Koszty integracji
                </label>
                <div class="input-group">
                    <input type="text" v-model="integrationCost" class="form-control"  disabled :aria-label="$t('challengesNew.numberSupported')" />
                    <div id="input-group-price6551422" class="input-group-text">zł</div>
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-12" >
                <label for="input-wizard-24124412" class="form-label">
                    Razem
                </label>
                <div class="input-group">
                    <input type="text" :value="(parseFloat(partsCost) + parseFloat(integrationCost))" class="form-control" disabled :aria-label="$t('challengesNew.numberSupported')" />
                    <div id="input-group-price62342211" class="input-group-text">zł</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, getCurrentInstance, onMounted, reactive, ref, watch} from "vue";
import {helper as $h} from "../../../../utils/helper";


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
        const robots = ref([]);
        const additionalCosts = ref([]);
        const partPrices = ref({});

        const getParts = () => {
            emitter.emit('unityoutgoingaction', {action: 'getParts'});
        }

        emitter.on('estimatesave', e => {
            axios.post('/api/solution/estimate/save', {solution_id: props.solution.id, basicCosts: basicCosts, additionalCosts: additionalCosts.value, partPrices: partPrices.value, partsAr: partsAr.value, partsCost:partsCost.value, integrationCost: integrationCost.value })
                .then(response => {

                    if (response.data.success) {
                    } else {

                    }
                });
        });

        const finalPartsList = (parts = null) => {

            partsAr.value = {};

            if(!parts) {
                parts = props.parts;
            }

            if(parts.length !== undefined) {

                parts.forEach((obj) => {

                    //1091 - id modelu "Operator - Ethan"
                    if(typeof obj.sourceType !== undefined && obj.sourceType === 'solution' && parseInt(obj.model_id) !== 1091) {

                        if (partPrices.value[obj.model_name] !== undefined) {
                            if (partsAr.value[obj.model_name] !== undefined) {
                                partsAr.value[obj.model_name].count += 1;

                            } else {
                                partsAr.value[obj.model_name] = {
                                    count: 1,
                                    price: partPrices.value[obj.model_name],
                                };

                            }
                        } else {
                            if (partsAr.value[obj.model_name] !== undefined) {
                                if (partPrices.value[obj.model_name] === undefined) {
                                    partPrices.value[obj.model_name] = 0;

                                }
                                partsAr.value[obj.model_name].count += 1;

                            } else {
                                if (partPrices.value[obj.model_name] === undefined) {
                                    partPrices.value[obj.model_name] = 0;

                                }
                                partsAr.value[obj.model_name] = {
                                    count: 1,
                                    price: 0,
                                };

                            }
                        }
                    }
                });

                try {
                    let tempChallenge = JSON.parse(challenge.value.save_json);
                    tempChallenge.parts.forEach((objC, index) => {


                        if(partsAr.value[objC.model.model_name] !== undefined) {
                            partsAr.value[objC.model.model_name].count -= 1;
                        }
                    })
                }catch (e) {

                }

            }

        };

        const partsCost = computed(() => {
            let sum = 0;

            for (let key in partsAr.value) {
                    sum += partsAr.value[key].price * partsAr.value[key].count;
            }

            return sum;
        });

        const integrationCost = computed(() => {
            let sum = 0;
            additionalCosts.value.forEach((obj) => {
                sum += parseFloat(obj.price);
            });


            for (let key in basicCosts) {


                sum += parseFloat(basicCosts[key]);
            }
            return sum;
        });

        const getEstimate = () => {
            axios.post('/api/solution/estimate/get', { solution_id: props.solution.id})
                .then(response => {


                    let pay = JSON.parse(response.data.payload.parts_prices);

                    if (response.data.success) {
                        try {


                                partPrices.value = pay;



                        } catch (e) {


                        }


                        try {
                            additionalCosts.value = JSON.parse(response.data.payload.additional_costs);
                        } catch (e) {

                        }

                        basicCosts.mechanical_integration = response.data.payload.mechanical_integration;
                            basicCosts.electrical_integration = response.data.payload.electrical_integration;
                            basicCosts.workstation_integration = response.data.payload.workstation_integration;
                            basicCosts.programming_robot = response.data.payload.programming_robot;
                            basicCosts.programming_plc = response.data.payload.programming_plc;
                            basicCosts.documentation_ce = response.data.payload.documentation_ce;
                            basicCosts.training = response.data.payload.training;
                            basicCosts.project = response.data.payload.project;
                            basicCosts.margin = response.data.payload.margin;
                    }
                })
        }

        const refreshMe = () => {
            getParts();
            setTimeout(() => {
                finalPartsList();
            }, 1000);
        };

        const getChallenge = () => {
            axios.post('/api/challenge/user/get/card', {id: props.solution.challenge_id})
                .then(response => {

                    if (response.data.success) {
                        challenge.value = response.data.payload;
                        finalPartsList();
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
            if(props.solution == undefined) {
                setTimeout(() => {
                    getChallenge();
                    getEstimate();
                }, 1000);
            } else {
                getChallenge();
                getEstimate();
            }

        });

        emitter.on('UnityObjectPlaced', e => {
            finalPartsList(e.partsPlaced);
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
            addCost,
            refreshMe,
            integrationCost,
            partsCost,
            robots
        }
    }
}
</script>

<style scoped>

</style>
