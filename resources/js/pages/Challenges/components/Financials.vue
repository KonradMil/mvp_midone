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
                            <input type="number" v-model="financials.days" @input="checkLength(financials.days, 'days')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.shifts" @input="checkLength(financials.shifts, 'shifts')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.shift_time" @input="checkLength(financials.shift_time, 'shiftTime')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.weekend_shift" @input="checkLength(financials.weekend_shift, 'weekendShift')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.breakfast" @input="checkLength(financials.breakfast, 'breakfast')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.stop_time" @input="checkLength(financials.stop_time, 'stopTime')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.operator_performance" @input="checkLength(financials.operator_performance, 'operatorPerformance')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.defective" @input="checkLength(financials.defective, 'defective')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.number_of_operators" @input="checkLength(financials.number_of_operators, 'numberOfOperators')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.operator_cost" @input="checkLength(financials.operator_cost, 'operatorCost')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.absence" @input="checkLength(financials.absence, 'absence')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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
                            <input type="number" v-model="financials.cycle_time" @input="checkLength(financials.cycle_time, 'cycleTime')" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
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

        const checkLength = (object, type) => {
            if(type === 'days'){
                if(object < 0){
                    props.financials.days = 0;
                }else if(object > 366){
                    props.financials.days = 366;
                }
            } else if(type === 'shifts'){
                if(object < 0){
                    props.financials.shifts = 0;
                }else if(object > 10){
                    props.financials.shifts = 10;
                }
            } else if(type === 'weekendShift'){
                if(object < 0){
                    props.financials.weekend_shift = 0;
                }else if(object > 10){
                    props.financials.weekend_shift = 10;
                }
            }else if(type === 'shiftTime'){
                if(object < 0){
                    props.financials.shift_time = 0;
                }else if(object > 24){
                    props.financials.shift_time = 24;
                }
            } else if(type === 'breakfast'){
                if(object < 0){
                    props.financials.breakfast = 0;
                }else if(object > 60){
                    props.financials.breakfast = 60;
                }
            } else if(type === 'stopTime'){
                if(object < 0){
                    props.financials.stop_time = 0;
                }else if(object > 100){
                    props.financials.stop_time = 100;
                }
            } else if(type === 'operatorPerformance'){
                if(object < 0){
                    props.financials.operator_performance = 0;
                }else if(object > 100){
                    props.financials.operator_performance = 100;
                }
            } else if(type === 'defective') {
                if(object < 0){
                    props.financials.defective = 0;
                }else if(object > 100){
                    props.financials.defective = 100;
                }
            } else if(type === 'numberOfOperators'){
                if(object < 0){
                    props.financials.number_of_operators = 0;
                }else if(object > 1000){
                    props.financials.number_of_operators = 1000;
                }
            } else if(type === 'operatorCost'){
                if(object < 0){
                    props.financials.operator_cost = 0;
                }
            } else if(type === 'absence'){
                if(object < 0){
                    props.financials.absence = 0;
                } else if(object > 100){
                    props.financials.absence = 100;
                }
            } else if(type === 'cycleTime'){
                if(object < 0){
                    props.financials.cycle_time = 0;
                } else if(object > 60){
                    props.financials.cycle_time = 60;
                }
            }

        }

        watch(financials, (lab, prevLabel) => {

            context.emit("update:financials", lab);
        }, {deep: true})

        onMounted(() => {
           financials.value = props.financials;
        });

        return {
            checkLength,
            financials
        }
    }
}
</script>

<style scoped>

</style>
