<template>
    <div class="mt-2">
        <div class="" id="fintable">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Przed robotyzacją</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Po robotyzacji</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Zmiana</th>
                        </tr>
                        </thead>
                        <tbody v-if="challenge.financial_before != undefined">
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-1" class="form-label">
                                    Koszt pracy na stanowisku na godzinę za osobę
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="Math.round(challenge.financial_before.operator_cost / 160 * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(solution.financial_after.operator_cost / 160 * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Koszt pracy na stanowisku rok
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="Math.round(((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100)) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((solution.financial_after.days)*(solution.financial_after.shifts)*(solution.financial_after.shift_time)+(solution.financial_after.weekend_shift)*50*(solution.financial_after.shift_time))*(solution.financial_after.operator_cost / 160)*(solution.financial_after.number_of_operators)*(1+(solution.financial_after.absence / 100)) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100)))-(((solution.financial_after.days)*(solution.financial_after.shifts)*(solution.financial_after.shift_time)+(solution.financial_after.weekend_shift)*50*(solution.financial_after.shift_time))*(solution.financial_after.operator_cost / 160)*(solution.financial_after.number_of_operators)*(1+(solution.financial_after.absence / 100))))/(((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100))) * 100 * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Koszt pracy na sztukę produkcji
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="Math.round(((((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100))) / (((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 )))) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((((solution.financial_after.days)*(solution.financial_after.shifts)*(solution.financial_after.shift_time)+(solution.financial_after.weekend_shift)*50*(solution.financial_after.shift_time))*(solution.financial_after.operator_cost / 160)*(solution.financial_after.number_of_operators)*(1+(solution.financial_after.absence / 100))) / (((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 )))) * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <input type="number" :value="Math.round(((((((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100))) / (((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 )))))-(((((solution.financial_after.days)*(solution.financial_after.shifts)*(solution.financial_after.shift_time)+(solution.financial_after.weekend_shift)*50*(solution.financial_after.shift_time))*(solution.financial_after.operator_cost / 160)*(solution.financial_after.number_of_operators)*(1+(solution.financial_after.absence / 100))) / (((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 ))))))/(((((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100))) / (((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))))) * 100 * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Miesieczna  redukcja koszty obsługi stanowiska (ludzie)
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="Math.round(((((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100))) - (((solution.financial_after.days)*(solution.financial_after.shifts)*(solution.financial_after.shift_time)+(solution.financial_after.weekend_shift)*50*(solution.financial_after.shift_time))*(solution.financial_after.operator_cost / 160)*(solution.financial_after.number_of_operators)*(1+(solution.financial_after.absence / 100))))/12 * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">

                            </td>
                            <td class="border">

                             </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Obniżka TKW na sztukę produkcji
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="(((((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100))) / (((challenge.financial_before.operator_performance / 100) * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - (challenge.financial_before.defective / 100 ))))) - (((((solution.financial_after.days)*(solution.financial_after.shifts)*(solution.financial_after.shift_time)+(solution.financial_after.weekend_shift)*50*(solution.financial_after.shift_time))*(solution.financial_after.operator_cost / 160)*(solution.financial_after.number_of_operators)*(1+(solution.financial_after.absence / 100))) / (((solution.financial_after.operator_performance / 100) * ((solution.financial_after.days * solution.financial_after.shifts * solution.financial_after.shift_time * 60 + solution.financial_after.weekend_shift * 50 * 60) - (solution.financial_after.days * solution.financial_after.shifts * (solution.financial_after.breakfast + solution.financial_after.stop_time) + solution.financial_after.weekend_shift * 50 * (solution.financial_after.breakfast + solution.financial_after.stop_time)))) * (1 - (solution.financial_after.defective / 100 )))))" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">

                            </td>
                            <td class="border">

                                 </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Roczna oszczędność finansowa (dodatkowy zysk brutto)
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <input type="number" :value="(((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100))) - (((solution.financial_after.days)*(solution.financial_after.shifts)*(solution.financial_after.shift_time)+(solution.financial_after.weekend_shift)*50*(solution.financial_after.shift_time))*(solution.financial_after.operator_cost / 160)*(solution.financial_after.number_of_operators)*(1+(solution.financial_after.absence / 100)))" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">

                            </td>
                            <td class="border">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Capex
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border" colspan="3">
                                <input type="number" v-model="capex" class="form-control finclass" placeholder="0"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Koszt kapitału (zakładany automatycznie)
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border" colspan="3">
                                <input type="number" v-model="capitalCost" class="form-control finclass" placeholder="0"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Zakładany okres analizy
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border" colspan="3">
                                <input type="number" v-model="timeframe" class="form-control finclass" placeholder="12"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Średnia oszczędność miesięczna
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border" colspan="3">
                                <input type="number" :value="Math.round(((((challenge.financial_before.days)*(challenge.financial_before.shifts)*(challenge.financial_before.shift_time)+(challenge.financial_before.weekend_shift)*50*(challenge.financial_before.shift_time))*(challenge.financial_before.operator_cost / 160)*(challenge.financial_before.number_of_operators)*(1+(challenge.financial_before.absence / 100))) - (((solution.financial_after.days)*(solution.financial_after.shifts)*(solution.financial_after.shift_time)+(solution.financial_after.weekend_shift)*50*(solution.financial_after.shift_time))*(solution.financial_after.operator_cost / 160)*(solution.financial_after.number_of_operators)*(1+(solution.financial_after.absence / 100))))/12 * 100) / 100" class="form-control finclass" placeholder="0" disabled="disabled"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Okres zwrotu prosty
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border" colspan="3">
                                {{Math.round(okresZwrotuProsty * 100) / 100}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="border">
                                <label for="input-wizard-9" class="form-label">
                                    NPV
                                </label>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border" colspan="3">
                                {{Math.round(npv * 100) / 100}}
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, ref, watch, watchEffect} from "vue";

export default {
    name: "FinancialAnalysisDialog",
    props: {
        solution: Object
    },
    setup(props, context) {

        const challenge = ref({});
        const capitalCost = ref(12);
        const capex = ref(0);
        const timeframe = ref(5);
        const okresZwrotuProsty = ref(0);
        const okresZwrotuZdyskontowany = ref(0);
        const npv = ref(0);


        onMounted(() => {
            getChallenge();
        });


        watch([capitalCost, capex, timeframe], (newValues, prevValues) => {
            npvFunction();
        })



        const npvFunction = () =>  {
            const cashFlow = [];
            const wacc = [];
            const dcf = [];
            const scf = [];
            const rtp = [];
            const sdcf = [];
            const drtp = [];

            const workStationCostBefore = ((challenge.value.financial_before.days)*(challenge.value.financial_before.shifts)*(challenge.value.financial_before.shift_time)+(challenge.value.financial_before.weekend_shift)*50*(challenge.value.financial_before.shift_time))*(challenge.value.financial_before.operator_cost / 160)*(challenge.value.financial_before.number_of_operators)*(1+(challenge.value.financial_before.absence / 100));
            const workStationCostAfter = ((props.solution.financial_after.days)*(props.solution.financial_after.shifts)*(props.solution.financial_after.shift_time)+(props.solution.financial_after.weekend_shift)*50*(props.solution.financial_after.shift_time))*(props.solution.financial_after.operator_cost / 160)*(props.solution.financial_after.number_of_operators)*(1+(props.solution.financial_after.absence / 100));

            for (let i = 0; i < (timeframe.value + 1); i += 1) {
                if (i === 0) {
                    cashFlow.push(parseFloat(capex.value) * -1);
                    wacc.push(100);
                    dcf.push(parseFloat(capex.value) * -1);
                    scf.push(parseFloat(capex.value) * -1);
                    sdcf.push(parseFloat(capex.value) * -1);
                    rtp.push(0);
                } else {
                    cashFlow.push(workStationCostBefore - workStationCostAfter);
                    wacc.push(1 / ((1 + (parseFloat(capitalCost.value) / 100)) ** i));
                    dcf.push(cashFlow[i] * (wacc[i]));
                    scf.push(scf[i - 1] + (workStationCostBefore - workStationCostAfter));
                    if (scf[i] > 0) {
                        rtp.push(i);
                    } else {
                        rtp.push(0);
                    }
                    sdcf.push(sdcf[i - 1] + dcf[i]);

                    if (sdcf[i] > 0) {
                        drtp.push(i);
                    } else {
                        drtp.push(0);
                    }
                }
            }
            console.log([cashFlow, wacc, dcf, scf, sdcf, rtp]);
            for (let i = 0; i < rtp.length; i += 1) {
                if (rtp[i] > 0) {
                    okresZwrotuProsty.value = (i - 1) + ((capex.value / (workStationCostBefore - workStationCostAfter)) - Math.floor((capex.value / (workStationCostBefore - workStationCostAfter))));
                    break;
                }
            }
            // console.log(this.localTimeframe * (workStationCostBefore - workStationCostAfter));

            for (let i = 0; i < drtp.length; i += 1) {
                if (drtp[i] > 0) {
                    okresZwrotuZdyskontowany.value = i + ((sdcf[(i - 1)] / ((sdcf[(i - 1)] * -1) + sdcf[i])) - Math.floor((sdcf[(i - 1)] / ((sdcf[(i - 1)] * -1) + sdcf[i]))));
                    break;
                }
            }

            npv.value = sdcf[timeframe.value];
            console.log([cashFlow, wacc, dcf, scf, rtp, sdcf, drtp]);
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

        return {
            challenge,
            timeframe,
            capex,
            capitalCost,
            okresZwrotuProsty,
            okresZwrotuZdyskontowany,
            npv
        }
    }
}
</script>

<style scoped>

</style>
