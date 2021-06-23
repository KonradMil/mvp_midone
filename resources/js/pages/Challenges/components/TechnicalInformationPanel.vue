<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div
                    class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                >
                    <h2 class="font-medium text-base mr-auto"> Szczegóły techniczne</h2>
                </div>
                <div class="px-5 py-5">
                    <div
                        id="latest-tasks-new"
                        class="tab-pane active"
                        role="tabpanel"
                        aria-labelledby="latest-tasks-new-tab"
                    >
                        <div class="flex items-center">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Maksymalna waga detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_weight'][challenge.technical_details.detail_weight].name }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Jakość chwytania detalu:</span>
                                <div class="text-gray-600"> {{ details['select_pick_quality'][challenge.technical_details.pick_quality].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Materiał detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_material'][challenge.technical_details.detail_material].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Wielkość detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_size'][challenge.technical_details.detail_size].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Sposób pobierania metalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_pick'][challenge.technical_details.detail_pick].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Czy detal jest pozycjonowany do pobrania?</span>
                                <div class="text-gray-600"> {{ details['select_detail_position'][challenge.technical_details.detail_position].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Odległość pomiędzy miejscem pobrania i odkładania detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_range'][challenge.technical_details.detail_range].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Miejsce odłożenia detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_destination'][challenge.technical_details.detail_destination].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Ilość obsługiwanych stanowisk/linii:</span>
                                <div class="text-gray-600"> {{challenge.technical_details.number_of_lines }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Liczba zmian:</span>
                                <div class="text-gray-600"> {{ details['select_work_shifts'][challenge.technical_details.work_shifts].name }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Announcement -->
            <!-- BEGIN: Daily Sales -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div
                    class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                >
                    <h2 class="font-medium text-base mr-auto"> Szczegóły finansowe</h2>
                </div>
                <div class="px-5 py-5">
                    <table class="table" v-if="challenge.financial_before != undefined">
                        <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Przed robotyzacją</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.days')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.days" class="form-control" disabled placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shifts')}}
                                </label>
                                <input type="number" disabled v-model="challenge.financial_before.shifts" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shift_time')}}
                                </label>
                                <input type="number" disabled v-model="challenge.financial_before.shift_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.weekend_shift')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.weekend_shift" class="form-control"  disabled placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.breakfast')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.breakfast" class="form-control" placeholder="0"  disabled :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.stop_time" class="form-control" placeholder="0"  disabled :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_performance')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.operator_performance"  disabled class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.defective')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.defective" class="form-control"  disabled placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.number_of_operators')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.number_of_operators" class="form-control"  disabled placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_cost')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.operator_cost" class="form-control"  disabled placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.absence')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.absence" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" disabled />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.cycle_time')}}
                                </label>
                                <input type="number" v-model="challenge.financial_before.cycle_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Daily Sales -->
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref} from "vue";

export default {
    name: "TechnicalInformationPanel",
    props: {
        challenge: Object
    },
    setup(props) {
        const challenge = computed(() => {
            return props.challenge;
        });
        const details = require("../../../json/challenge.json");

        onMounted(() => {

        });


        return {
            challenge,
            details
        }
    }
}
</script>

<style scoped>

</style>
