<template>
    <div class="mt-2">

        <p class="alert alert-warning show">Przed wprowadzeniem zmian upewnij się, że kursor znajduje się we właściwym polu.</p><br>

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
                        <tbody>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.days')}}
                                </label>
                                <input type="number" v-model="financial_before.days" class="form-control" placeholder="260,00" :placeholder="$t('challengesNew.days')" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.days')}}
                                </label>
                                <input v-if="(financial_after!=undefined) " type="number" v-model="financial_after.days" class="form-control" placeholder="260,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined" type="number" class="form-control" placeholder="260,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shifts')}}
                                </label>
                                <input type="number" v-model="financial_before.shifts" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shifts')}}
                                </label>
                                <input v-if="financial_after!=undefined"  type="number"  v-model="financial_after.shifts" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'" />
                                <input v-if="financial_after ==undefined"  type="number"  class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shift_time')}}
                                </label>
                                <input type="number" v-model="financial_before.shift_time" class="form-control" placeholder="8,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shift_time')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number"  v-model="financial_after.shift_time" class="form-control" placeholder="8,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined" type="number"  class="form-control" placeholder="8,00" :aria-label="$t('challengesNew.numberSupported')"/>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.weekend_shift')}}
                                </label>
                                <input type="number" v-model="financial_before.weekend_shift" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.weekend_shift')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number"  v-model="financial_after.weekend_shift" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'" />
                                <input v-if="financial_after==undefined" type="number" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.breakfast')}}
                                </label>
                                <input type="number" v-model="financial_before.breakfast" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.breakfast')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number"  v-model="financial_after.breakfast" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined" type="number"  class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')"/>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>
                                <input type="number" v-model="financial_before.stop_time" class="form-control" placeholder="20,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number"  v-model="financial_after.stop_time" class="form-control" placeholder="20,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined" type="number" class="form-control" placeholder="20,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_performance')}}
                                </label>
                                <input type="number" v-model="financial_before.operator_performance" class="form-control" placeholder="90,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_performance')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number"  v-model="financial_after.operator_performance" class="form-control" placeholder="90,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined" type="number" class="form-control" placeholder="90,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.defective')}}
                                </label>
                                <input type="number" v-model="financial_before.defective" class="form-control" placeholder="5,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.defective')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number"  v-model="financial_after.defective" class="form-control" placeholder="5,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"  type="number" class="form-control" placeholder="5,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.number_of_operators')}}
                                </label>
                                <input type="number" v-model="financial_before.number_of_operators" class="form-control" placeholder="2,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.number_of_operators')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number" v-model="financial_after.number_of_operators" class="form-control" placeholder="2,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined" type="number" class="form-control" placeholder="2,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr><tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_cost')}}
                                </label>
                                <input type="number" v-model="financial_before.operator_cost" class="form-control" placeholder="4500,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_cost')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number"  v-model="financial_after.operator_cost" class="form-control" placeholder="4500,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined" type="number"   class="form-control" placeholder="4500,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr><tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.absence')}}
                                </label>
                                <input type="number" v-model="financial_before.absence" class="form-control" placeholder="12,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.absence')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number"  v-model="financial_after.absence" class="form-control" placeholder="12,00" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined" type="number"  class="form-control" placeholder="12,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr><tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.cycle_time')}}
                                </label>
                                <input type="number" v-model="financial_before.cycle_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.cycle_time')}}
                                </label>
                                <input v-if="financial_after!=undefined" type="number" v-model="financial_after.cycle_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined" type="number"  class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
import {onMounted, ref} from "vue";
// import Multiselect from '@vueform/multiselect'

export default {
    name: "FinancialDialog",
    // components: {Multiselect},
    props: {
        financial_before: Object,
        financial_after: Object,
        type: String
    },
    setup(props) {
        const user = window.Laravel.user;


        onMounted(() => {

        });

        return {
            user
        }
    }
}
</script>

<style scoped>

</style>
