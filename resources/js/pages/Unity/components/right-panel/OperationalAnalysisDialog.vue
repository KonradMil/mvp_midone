<template>
    <div
        class="mt-2">
        <div class="" id="hoverable-table">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Przed robotyzacją</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Po robotyzacji</th>
                        </tr>
                        </thead>
                        <tbody v-if="challenge.financial_before != undefined">
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-1" class="form-label">
                                    Czas dostępny (min)
                                </label>
                                <input type="number" :value="challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-2" class="form-label">
                                    {{$t('challengesNew.days')}}
                                </label>
                               </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Czas produkcji (min)
                                </label>
                                <input type="number" :value="(challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time))" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shifts')}}
                                </label>

                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Produkcja  (min)
                                </label>
                                <input type="number" :value="challenge.financial_before.operator_performance * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shift_time')}}
                                </label>

                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Czas produkcji sztuk dobrych  (min)
                                </label>
                                <input type="number" :value="(challenge.financial_before.operator_performance * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - challenge.financial_before.defective)" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.weekend_shift')}}
                                </label>

                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    AR - Współczynnik dostepności
                                </label>
                                <input type="number" :value="((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time))) / (challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60)" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.breakfast')}}
                                </label>

                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    PR - Współczynnik produktywności
                                </label>
                                <input type="number" :value="(challenge.financial_before.operator_performance * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) / ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>

                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    QR - współczynnik jakości
                                </label>
                                <input type="number" :value="((challenge.financial_before.operator_performance * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - challenge.financial_before.defective)) / ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>

                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    OEE
                                </label>
                                <input type="number" :value="((challenge.financial_before.operator_performance * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - challenge.financial_before.defective)) / (challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60)" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>

                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    Wielkość produkcji
                                </label>
                                <input type="number" :value="((challenge.financial_before.operator_performance * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - challenge.financial_before.defective)) * 60 / (challenge.financial_before.cycle_time)" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>

                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    PPH na osobę na zmianę
                                </label>
                                <input type="number" :value="((((challenge.financial_before.operator_performance * ((challenge.financial_before.days * challenge.financial_before.shifts * challenge.financial_before.shift_time * 60 + challenge.financial_before.weekend_shift * 50 * 60) - (challenge.financial_before.days * challenge.financial_before.shifts * (challenge.financial_before.breakfast + challenge.financial_before.stop_time) + challenge.financial_before.weekend_shift * 50 * (challenge.financial_before.breakfast + challenge.financial_before.stop_time)))) * (1 - challenge.financial_before.defective)) * 60 / (challenge.financial_before.cycle_time))/(challenge.financial_before.days )) / (challenge.financial_before.number_of_operators)" class="form-control" placeholder="0" disabled="disabled"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>

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
import {onMounted, ref, watch} from "vue";

export default {
    name: "OperationalAnalysisDialog",
    props: {
      solution: Object
    },
    setup(props, context) {

        const challenge = ref({});


        onMounted(() => {
            getChallenge();
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

        return {
            challenge
        }
    }
}
</script>

<style scoped>

</style>
