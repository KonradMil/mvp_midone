<template>
    <div
        class="intro-y box mt-5">
        <div class="p-5" id="hoverable-table">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Przed robotyzacją</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Po robotyzacji</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Różnica</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="hover:bg-gray-200">
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.days')}}
                                </label>
                                <input type="number" v-model="days" class="form-control" placeholder="260,00" :placeholder="$t('challengesNew.days')" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.days')}}
                                </label>
                                <input type="number" class="form-control" placeholder="260,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shifts')}}
                                </label>
                                <input type="number" v-model="shifts" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shifts')}}
                                </label>
                                <input type="number" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shift_time')}}
                                </label>
                                <input type="number" v-model="shift_time" class="form-control" placeholder="8,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.shift_time')}}
                                </label>
                                <input type="number" class="form-control" placeholder="8,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.weekend_shift')}}
                                </label>
                                <input type="number" v-model="weekend_shift" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.weekend_shift')}}
                                </label>
                                <input type="number" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.breakfast')}}
                                </label>
                                <input type="number" v-model="breakfast" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.breakfast')}}
                                </label>
                                <input type="number" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>
                                <input type="number" v-model="stop_time" class="form-control" placeholder="20,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.stop_time')}}
                                </label>
                                <input type="number" class="form-control" placeholder="20,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_performance')}}
                                </label>
                                <input type="number" v-model="operator_performance" class="form-control" placeholder="90,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_performance')}}
                                </label>
                                <input type="number" class="form-control" placeholder="90,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.defective')}}
                                </label>
                                <input type="number" v-model="defective" class="form-control" placeholder="5,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.defective')}}
                                </label>
                                <input type="number" class="form-control" placeholder="5,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr>
                        <tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.number_of_operators')}}
                                </label>
                                <input type="number" v-model="number_of_operators" class="form-control" placeholder="2,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.number_of_operators')}}
                                </label>
                                <input type="number" class="form-control" placeholder="2,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr><tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_cost')}}
                                </label>
                                <input type="number" v-model="operator_cost" class="form-control" placeholder="4500,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.operator_cost')}}
                                </label>
                                <input type="number" class="form-control" placeholder="4500,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr><tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.absence')}}
                                </label>
                                <input type="number" v-model="absence" class="form-control" placeholder="12,00" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.absence')}}
                                </label>
                                <input type="number" class="form-control" placeholder="12,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr><tr class="hover:bg-gray-200">

                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.cycle_time')}}
                                </label>
                                <input type="number" v-model="cycle_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                            </td>
                            <td class="border">
                                <label for="input-wizard-9" class="form-label">
                                    {{$t('challengesNew.cycle_time')}}
                                </label>
                                <input type="number" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                            </td>
                            <td class="border">0</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="source-code hidden">
                <button data-target="#copy-hoverable-table" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
                <div class="overflow-y-auto mt-3 rounded-md">
                    <pre class="source-preview" id="copy-hoverable-table"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTagdiv class=&quot;overflow-x-auto&quot;HTMLCloseTag HTMLOpenTagtable class=&quot;table&quot;HTMLCloseTag HTMLOpenTagtheadHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTag#HTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagFirst NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagLast NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagUsernameHTMLOpenTag/thHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/theadHTMLCloseTag HTMLOpenTagtbodyHTMLCloseTag HTMLOpenTagtr class=&quot;hover:bg-gray-200&quot;HTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag1HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagAngelinaHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagJolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag0HTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtr class=&quot;hover:bg-gray-200&quot;HTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag2HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagBradHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagPittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@bradpittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtr class=&quot;hover:bg-gray-200&quot;HTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag3HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagCharlieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagHunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@charliehunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/tbodyHTMLCloseTag HTMLOpenTag/tableHTMLCloseTag HTMLOpenTag/divHTMLCloseTag </code> </pre>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {onMounted, ref} from "vue";
// import Multiselect from '@vueform/multiselect'

export default {
    name: "FinancialAnalysisDialog",
    // components: {Multiselect},
    props: {
        object: Object,
        financial: Object,
        id: Number
    },
    setup(props) {
        const sels = require("../../../../json/challenge.json");

        const t = ref('');
        // const select_detail_pick = ref();
        const select_work_shifts = ref();
        const work = ref();

        console.log('Financial.ID!!!!' + props.technical.id);
        const challengeSelects = ref();
        onMounted(() => {
            challengeSelects.value = sels;
            // t.value = props.technical
            // select_detail_pick.value = sels.select_detail_pick.find(i => i.value === object.detail_pick).name
            // c.value = props.object

        });

        return {
            sels,
            select_work_shifts,
            t,
            // select_detail_pick,
        }
    }
}
</script>

<style scoped>

</style>
