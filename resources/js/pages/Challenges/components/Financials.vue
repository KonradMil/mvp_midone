<template>
    <div class="p-5" id="hoverable-table">
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
                            <input type="number" v-model="financials.days" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.days')}}
                            </label>
                            <input type="number" class="form-control" placeholder="260,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.shifts')}}
                            </label>
                            <input type="number" v-model="financials.shifts" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.shifts')}}
                            </label>
                            <input type="number" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">

                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.shift_time')}}
                            </label>
                            <input type="number" v-model="financials.shift_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.shift_time')}}
                            </label>
                            <input type="number" class="form-control" placeholder="8,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">

                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.weekend_shift')}}
                            </label>
                            <input type="number" v-model="financials.weekend_shift" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.weekend_shift')}}
                            </label>
                            <input type="number" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">

                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.breakfast')}}
                            </label>
                            <input type="number" v-model="financials.breakfast" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.breakfast')}}
                            </label>
                            <input type="number" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">

                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.stop_time')}}
                            </label>
                            <input type="number" v-model="financials.stop_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.stop_time')}}
                            </label>
                            <input type="number" class="form-control" placeholder="20,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">

                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.operator_performance')}}
                            </label>
                            <input type="number" v-model="financials.operator_performance" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.operator_performance')}}
                            </label>
                            <input type="number" class="form-control" placeholder="90,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">

                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.defective')}}
                            </label>
                            <input type="number" v-model="financials.defective" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.defective')}}
                            </label>
                            <input type="number" class="form-control" placeholder="5,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.number_of_operators')}}
                            </label>
                            <input type="number" v-model="financials.number_of_operators" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.number_of_operators')}}
                            </label>
                            <input type="number" class="form-control" placeholder="2,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.operator_cost')}}
                            </label>
                            <input type="number" v-model="financials.operator_cost" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.operator_cost')}}
                            </label>
                            <input type="number" class="form-control" placeholder="4500,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.absence')}}
                            </label>
                            <input type="number" v-model="financials.absence" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.absence')}}
                            </label>
                            <input type="number" class="form-control" placeholder="12,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200">
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.cycle_time')}}
                            </label>
                            <input type="number" v-model="financials.cycle_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                        </td>
                        <td class="border">
                            <label for="input-wizard-9" class="form-label">
                                {{$t('challengesNew.cycle_time')}}
                            </label>
                            <input type="number" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";

export default {
    name: "Financials",
    props: {
        financials: Object
    },
    emits: ["update:financials"],
    setup(props, context) {
        const financials = ref({});

        watch(financials, (lab, prevLabel) => {

            context.emit("update:financials", lab);
        }, {deep: true})

        onMounted(() => {
           financials.value = props.financials;
        });

        return {
            financials
        }
    }
}
</script>

<style scoped>

</style>
