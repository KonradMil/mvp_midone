<template>
    <div class="intro-y box shadow-2xl" style="width: 1000px;">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Analiza operacyjna {{solution.name}}
            </h2>
        </div>
        <div class="p-5" id="bordered-table">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table text-gray-800">
                        <thead>
                        <tr class="text-left border-b-2">
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap"></th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Przed robotyzacją</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Po robotyzacji</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-left border-b-2">
                            <td class="border">Koszt pracy na stanowisku na godzinę za osobę</td>
                            <td class="border">{{financial_analyses.cost_per_hour_before}}</td>
                            <td class="border">{{financial_analyses.cost_per_hour_after}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Koszt pracy na stanowisku rok</td>
                            <td class="border">{{financial_analyses.cost_per_year_before}}</td>
                            <td class="border">{{financial_analyses.cost_per_year_after}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Koszt pracy na sztukę produkcji</td>
                            <td class="border">{{financial_analyses.cost_per_piece_before}}</td>
                            <td class="border">{{financial_analyses.cost_per_piece_after}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Miesieczna redukcja koszty obsługi stanowiska (ludzie)</td>
                            <td class="border">{{financial_analyses.monthly_reduction_before}}</td>
                            <td class="border">{{financial_analyses.monthly_reduction_after}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Obniżka TKW na sztukę produkcji</td>
                            <td class="border">{{financial_analyses.tkw_reduction_before}}</td>
                            <td class="border">{{financial_analyses.tkw_reduction_after}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Roczna oszczędność finansowa (dodatkowy zysk brutto)</td>
                            <td class="border">{{financial_analyses.additional_savings_before}}</td>
                            <td class="border">{{financial_analyses.additional_savings_after}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Capex</td>
                            <td class="border">{{financial_analyses.capex}}</td>
                            <td class="border">{{financial_analyses.capex}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Koszt kapitału (zakładany automatycznie)</td>
                            <td class="border">{{financial_analyses.timeframe}}</td>
                            <td class="border">{{financial_analyses.timeframe}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Zakładany okres analizy</td>
                            <td class="border">{{financial_analyses.monthly_savings_before}}</td>
                            <td class="border">{{financial_analyses.monthly_savings_before}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Średnia oszczędność miesięczna</td>
                            <td class="border">{{financial_analyses.pph_per_person_before}}</td>
                            <td class="border">{{financial_analyses.pph_per_person_after}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">Okres zwrotu prosty</td>
                            <td class="border">{{financial_analyses.simple_payback}}</td>
                            <td class="border">{{financial_analyses.simple_payback}}</td>
                        </tr>
                        <tr class="text-left border-b-2">
                            <td class="border">NPV</td>
                            <td class="border">{{financial_analyses.npv}}</td>
                            <td class="border">{{financial_analyses.npv}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="source-code hidden">
                <button data-target="#copy-bordered-table" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
                <div class="overflow-y-auto mt-3 rounded-md">
                    <pre class="source-preview" id="copy-bordered-table"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTagdiv class=&quot;overflow-x-auto&quot;HTMLCloseTag HTMLOpenTagtable class=&quot;table&quot;HTMLCloseTag HTMLOpenTagtheadHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTag#HTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagFirst NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagLast NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagUsernameHTMLOpenTag/thHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/theadHTMLCloseTag HTMLOpenTagtbodyHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag1HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagAngelinaHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagJolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@angelinajolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag2HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagBradHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagPittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@bradpittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag3HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagCharlieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagHunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@charliehunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/tbodyHTMLCloseTag HTMLOpenTag/tableHTMLCloseTag HTMLOpenTag/divHTMLCloseTag </code> </pre>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref} from "vue";

export default {
    name: "FinancialAnalysisInformationPanel",
    props: {
        solution: Object,
    },

    setup(props) {
        const financial_analyses = ref({});

        onMounted(() => {

            getFinancialAnalysis();
        });

        const getFinancialAnalysis = async() => {
            axios.post('/api/solution/financial-analyses/get', {id: props.solution.id})
                .then(response => {
                    if (response.data.success) {


                        financial_analyses.value = response.data.payload;


                    } else {

                    }
                })
        }

        return {
            financial_analyses,
        }
    }
}
</script>

<style scoped>

</style>
