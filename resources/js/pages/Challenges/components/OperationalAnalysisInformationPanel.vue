<template>
    <div class="intro-y box" style="width: 1000px;">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Analiza operacyjna {{solution.name}}
            </h2>
        </div>
        <div class="p-5" id="bordered-table">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table text-gray-100 bg-gradient-to-l from-pink-500 to-pink-900">
                        <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap"></th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Przed robotyzacją</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Po robotyzacji</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Zmiana</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="border">Czas dostępny (min)</td>
                            <td class="border">{{operational_analyses.time_available_before}}</td>
                            <td class="border">{{operational_analyses.time_available_after}}</td>
                            <td class="border">{{operational_analyses.time_available_change}}</td>
                        </tr>
                        <tr>
                            <td class="border">Czas produkcji (min)</td>
                            <td class="border">{{operational_analyses.time_production_before}}</td>
                            <td class="border">{{operational_analyses.time_production_after}}</td>
                            <td class="border">{{operational_analyses.time_production_change}}</td>
                        </tr>
                        <tr>
                            <td class="border">Produkcja (min)</td>
                            <td class="border">{{operational_analyses.production_before}}</td>
                            <td class="border">{{operational_analyses.production_after}}</td>
                            <td class="border">{{operational_analyses.production_change}}</td>
                        </tr>
                        <tr>
                            <td class="border">Czas produkcji sztuk dobrych (min)</td>
                            <td class="border">{{operational_analyses.good_arts_production_before}}</td>
                            <td class="border">{{operational_analyses.good_arts_production_after}}</td>
                            <td class="border">{{operational_analyses.good_arts_production_change}}</td>
                        </tr>
                        <tr>
                            <td class="border">AR - Współczynnik dostepności</td>
                            <td class="border">{{operational_analyses.availability_factor_before}}</td>
                            <td class="border">{{operational_analyses.availability_factor_before}}</td>
                            <td class="border">{{operational_analyses.availability_factor_before}}</td>
                        </tr>
                        <tr>
                            <td class="border">PR - Współczynnik produktywności</td>
                            <td class="border">{{operational_analyses.productivity_coefficient_before}}</td>
                            <td class="border">{{operational_analyses.productivity_coefficient_after}}</td>
                            <td class="border">{{operational_analyses.productivity_coefficient_change}}</td>
                        </tr>
                        <tr>
                            <td class="border">QR - współczynnik jakości</td>
                            <td class="border">{{operational_analyses.quality_factor_before}}</td>
                            <td class="border">{{operational_analyses.quality_factor_after}}</td>
                            <td class="border">{{operational_analyses.quality_factor_change}}</td>
                        </tr>
                        <tr>
                            <td class="border">OEE</td>
                            <td class="border">{{operational_analyses.oee_before}}</td>
                            <td class="border">{{operational_analyses.oee_after}}</td>
                            <td class="border">{{operational_analyses.oee_change}}</td>
                        </tr>
                        <tr>
                            <td class="border">Wielkość produkcji</td>
                            <td class="border">{{operational_analyses.production_volume_before}}</td>
                            <td class="border">{{operational_analyses.production_volume_after}}</td>
                            <td class="border">{{operational_analyses.production_volume_change}}</td>
                        </tr>
                        <tr>
                            <td class="border">PPH na osobę na zmianę</td>
                            <td class="border">{{operational_analyses.pph_per_person_before}}</td>
                            <td class="border">{{operational_analyses.pph_per_person_after}}</td>
                            <td class="border">{{operational_analyses.pph_per_person_change}}</td>
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
    name: "OperationalAnalysisInformationPanel",
    props: {
        solution: Object,
    },

    setup(props) {
        const operational_analyses = ref({});

        onMounted(() => {
            getOperationalAnalysis();
        });

        const getOperationalAnalysis = async() => {
            axios.post('/api/solution/operational-analyses/get', {id: props.solution.id})
                .then(response => {
                    if (response.data.success) {
                        operational_analyses.value = response.data.payload;
                    } else {

                    }
                })
        }

        return {
            operational_analyses,
        }
    }
}
</script>

<style scoped>

</style>
