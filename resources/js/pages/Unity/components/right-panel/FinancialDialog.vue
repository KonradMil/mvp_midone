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
                        <tbody>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.days')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.days"
                                       class="form-control"
                                       placeholder="260,00"
                                       @input="checkLength(financial_before.days, 'days', 'before')"
                                       :placeholder="$t('challengesNew.days')"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.days')}}
                                </label>
                                <input v-if="(financial_after!=undefined) "
                                       type="number" v-model="financial_after.days"
                                       class="form-control"
                                       placeholder="260,00"
                                       @input="checkLength(financial_after.days, 'days', 'after')"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"
                                       type="number" class="form-control"
                                       placeholder="260,00"
                                       :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shifts')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.shifts"
                                       @input="checkLength(financial_before.shifts, 'shifts', 'before')"
                                       class="form-control"
                                       placeholder="30,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shifts')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       v-model="financial_after.shifts"
                                       @input="checkLength(financial_after.shifts, 'shifts', 'after')"
                                       class="form-control"
                                       placeholder="30,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'" />
                                <input v-if="financial_after ==undefined"
                                       type="number"
                                       class="form-control"
                                       placeholder="30,00"
                                       :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shift_time')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.shift_time"
                                       @input="checkLength(financial_before.shift_time, 'shiftTime', 'before')"
                                       class="form-control"
                                       placeholder="8,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shift_time')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       v-model="financial_after.shift_time"
                                       @input="checkLength(financial_after.shift_time, 'shiftTime', 'after')"
                                       class="form-control"
                                       placeholder="8,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"
                                       type="number"
                                       class="form-control"
                                       placeholder="8,00"
                                       :aria-label="$t('challengesNew.numberSupported')"/>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.weekend_shift')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.weekend_shift"
                                       @input="checkLength(financial_before.weekend_shift, 'weekendShift', 'before')"
                                       class="form-control"
                                       placeholder="0"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.weekend_shift')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       v-model="financial_after.weekend_shift"
                                       @input="checkLength(financial_after.weekend_shift, 'weekendShift', 'after')"
                                       class="form-control"
                                       placeholder="0"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'" />
                                <input v-if="financial_after==undefined"
                                       type="number"
                                       class="form-control"
                                       placeholder="0"
                                       :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.breakfast')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.breakfast"
                                       @input="checkLength(financial_before.breakfast, 'breakfast', 'before')"
                                       class="form-control"
                                       placeholder="30,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.breakfast')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       v-model="financial_after.breakfast"
                                       @input="checkLength(financial_after.breakfast, 'breakfast', 'after')"
                                       class="form-control"
                                       placeholder="30,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"
                                       type="number"
                                       class="form-control"
                                       placeholder="30,00"
                                       :aria-label="$t('challengesNew.numberSupported')"/>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.stop_time"
                                       @input="checkLength(financial_before.stop_time, 'stopTime', 'before')"
                                       class="form-control"
                                       placeholder="20,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       v-model="financial_after.stop_time"
                                       @input="checkLength(financial_after.stop_time, 'stopTime', 'after')"
                                       class="form-control"
                                       placeholder="20,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"
                                       type="number"
                                       class="form-control"
                                       placeholder="20,00"
                                       :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_performance')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.operator_performance"
                                       @input="checkLength(financial_before.operator_performance, 'operatorPerformance', 'before')"
                                       class="form-control"
                                       placeholder="90,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_performance')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       @input="checkLength(financial_after.operator_performance, 'operatorPerformance', 'after')"
                                       v-model="financial_after.operator_performance"
                                       class="form-control"
                                       placeholder="90,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"
                                       type="number"
                                       class="form-control"
                                       placeholder="90,00"
                                       :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.defective')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.defective"
                                       @input="checkLength(financial_before.defective, 'defective', 'before')"
                                       class="form-control"
                                       placeholder="5,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.defective')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       v-model="financial_after.defective"
                                       @input="checkLength(financial_after.defective, 'defective', 'after')"
                                       class="form-control"
                                       placeholder="5,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"
                                       type="number"
                                       class="form-control"
                                       placeholder="5,00"
                                       :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.number_of_operators')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.number_of_operators"
                                       @input="checkLength(financial_before.number_of_operators, 'numberOfOperators', 'before')"
                                       class="form-control"
                                       placeholder="2,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.number_of_operators')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       @input="checkLength(financial_after.number_of_operators, 'numberOfOperators', 'after')"
                                       v-model="financial_after.number_of_operators"
                                       class="form-control"
                                       placeholder="2,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"
                                       type="number" class="form-control"
                                       placeholder="2,00"
                                       :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr><tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_cost')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.operator_cost"
                                       @input="checkLength(financial_before.operator_cost, 'operatorCost', 'before')"
                                       class="form-control"
                                       placeholder="4500,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_cost')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       v-model="financial_after.operator_cost"
                                       @input="checkLength(financial_after.operator_cost, 'operatorCost', 'after')"
                                       class="form-control"
                                       placeholder="4500,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input
                                    v-if="financial_after==undefined"
                                    type="number"
                                    class="form-control"
                                    placeholder="4500,00"
                                    :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr><tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.absence')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.absence"
                                       @input="checkLength(financial_before.absence, 'absence', 'before')"
                                       class="form-control"
                                       placeholder="12,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.absence')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       v-model="financial_after.absence"
                                       @input="checkLength(financial_after.absence, 'absence', 'after')"
                                       class="form-control"
                                       placeholder="12,00"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"
                                       type="number"
                                       class="form-control"
                                       placeholder="12,00"
                                       :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                        </tr><tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.cycle_time')}}
                                </label>
                                <input type="number"
                                       v-model="financial_before.cycle_time"
                                       @input="checkLength(financial_before.cycle_time, 'cycleTime', 'before')"
                                       class="form-control"
                                       placeholder="0"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="type=='solution'"/>
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.cycle_time')}}
                                </label>
                                <input v-if="financial_after!=undefined"
                                       type="number"
                                       v-model="financial_after.cycle_time"
                                       @input="checkLength(financial_after.cycle_time, 'cycleTime', 'after')"
                                       class="form-control"
                                       placeholder="0"
                                       :aria-label="$t('challengesNew.numberSupported')"
                                       :disabled="user.type=='investor'"/>
                                <input v-if="financial_after==undefined"
                                       type="number"
                                       class="form-control"
                                       placeholder="0"
                                       :aria-label="$t('challengesNew.numberSupported')" />
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

        const checkLength = (object, type, status) => {
            console.log(object,type,status)
            console.log('object,type,status');
            if (type === 'days') {
                console.log(type)
                if (object < 0) {
                    console.log(object)
                    if(status === 'before'){
                        console.log(status)
                        props.financial_before.days = 0;
                    } else if(status === 'after'){
                        console.log(status)
                        props.financial_after.days = 0;
                    }
                } else if (object > 366) {
                    if(status === 'before'){
                        props.financial_before.days = 366;
                    } else if(status === 'after'){
                        props.financial_after.days = 366;
                    }
                }
            } else if (type === 'shifts') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.shifts = 0;
                    } else if(status === 'after'){
                        props.financial_after.shifts = 0;
                    }
                } else if (object > 100) {
                    if(status === 'before'){
                        props.financial_before.shifts = 100;
                    } else if(status === 'after'){
                        props.financial_after.shifts = 100;
                    }
                }
            } else if (type === 'weekendShift') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.weekend_shift = 0;
                    } else if(status === 'after'){
                        props.financial_after.weekend_shift = 0;
                    }
                } else if (object > 100) {
                    if(status === 'before'){
                        props.financial_before.weekend_shift = 100;
                    } else if(status === 'after'){
                        props.financial_after.weekend_shift = 100;
                    }
                }
            } else if (type === 'shiftTime') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.shift_time = 0;
                    } else if(status === 'after'){
                        props.financial_after.shift_time = 0;
                    }
                } else if (object > 24) {
                    if(status === 'before'){
                        props.financial_before.shift_time = 24;
                    } else if(status === 'after'){
                        props.financial_after.shift_time = 24;
                    }
                }
            } else if (type === 'breakfast') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.breakfast = 0;
                    } else if(status === 'after'){
                        props.financial_after.breakfast = 0;
                    }
                } else if (object > 60) {
                    if(status === 'before'){
                        props.financial_before.breakfast = 60;
                    } else if(status === 'after'){
                        props.financial_after.breakfast = 60;
                    }
                }
            } else if (type === 'stopTime') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.stop_time = 0;
                    } else if(status === 'after'){
                        props.financial_after.stop_time = 0;
                    }
                } else if (object > 100) {
                    if(status === 'before'){
                        props.financial_before.stop_time = 100;
                    } else if(status === 'after'){
                        props.financial_after.stop_time = 100;
                    }
                }
            } else if (type === 'operatorPerformance') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.operator_performance = 0;
                    } else if(status === 'after'){
                        props.financial_after.operator_performance = 0;
                    }
                } else if (object > 100) {
                    if(status === 'before'){
                        props.financial_before.operator_performance = 100;
                    } else if(status === 'after'){
                        props.financial_after.operator_performance = 100;
                    }
                }
            } else if (type === 'defective') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.defective = 0;
                    } else if(status === 'after'){
                        props.financial_after.defective = 0;
                    }
                } else if (object > 100) {
                    if(status === 'before'){
                        props.financial_before.defective = 100;
                    } else if(status === 'after'){
                        props.financial_after.defective = 100;
                    }
                }
            } else if (type === 'numberOfOperators') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.number_of_operators = 100;
                    } else if(status === 'after'){
                        props.financial_after.number_of_operators = 100;
                    }
                } else if (object > 1000) {
                    if(status === 'before'){
                        props.financial_before.number_of_operators = 1000;
                    } else if(status === 'after'){
                        props.financial_after.number_of_operators = 1000;
                    }
                }
            } else if (type === 'operatorCost') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.operator_cost = 0;
                    } else if(status === 'after'){
                        props.financial_after.operator_cost = 0;
                    }
                }
            } else if (type === 'absence') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.absence = 0;
                    } else if(status === 'after'){
                        props.financial_after.absence = 0;
                    }
                } else if (object > 100) {
                    if(status === 'before'){
                        props.financial_before.absence = 100;
                    } else if(status === 'after'){
                        props.financial_after.absence = 100;
                    }
                }
            } else if (type === 'cycleTime') {
                if (object < 0) {
                    if(status === 'before'){
                        props.financial_before.cycle_time = 0;
                    } else if(status === 'after'){
                        props.financial_after.cycle_time = 0;
                    }
                } else if (object > 60) {
                    if(status === 'before'){
                        props.financial_before.cycle_time = 60;
                    } else if(status === 'after'){
                        props.financial_after.cycle_time = 60;
                    }
                }
            }
        }

        onMounted(() => {

        });

        return {
            checkLength,
            user
        }
    }
}
</script>

<style scoped>

</style>
