<template>
    <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9">
        <div class="intro-y box">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Stworzenie planu zarządzania ryzykiem
                </h2>
                <div class="absolute top-4 left-80 cursor-pointer px-6">
                    <button class="btn btn-primary mr-6" @click.prevent="show=true">
                        Podglad macierzy ryzyka
                    </button>
                </div>
                <div class="cursor-pointer px-6">
                    <button @click.prevent="addNewRisk" class="btn btn-outline-secondary py-1 px-2">
                        Dodaj
                    </button>
                </div>
            </div>
            <div id="faq-accordion-1" class="accordion p-5 max-h-96 overflow-auto">
                <div class="intro-y accordion-item" v-for="risk in riskRecords" :key="risk.id">
                    <div id="faq-accordion-content-1" class="accordion-header">
                        <button class="accordion-button collapsed truncate" style="width: 50em;" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2">
                            <p v-if="risk.risk_description !== ''">{{ risk.risk_description }} </p>
                            <p v-else> Uzupełnij opis </p>
                        </button>
                        <div class="absolute top-0 right-0 cursor-pointer px-6 pt-2">
                            <button class="intro-x btn btn-outline-secondary py-1 px-2" @click.prevent="deleteRisk(risk)">
                                Usuń
                            </button>
                        </div>
                    </div>
                    <div id="faq-accordion-collapse-1" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-2" data-bs-parent="#faq-accordion-1">
                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                            <div id="faq-accordion-2" class="accordion p-5">
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-2" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2">
                                            Opis ryzyka
                                        </button>
                                        <div class="absolute top-0 right-0 cursor-pointer px-6 pt-2">
                                            <button class="intro-x btn btn-outline-secondary py-1 px-2" @click.prevent="saveRisk(risk)">
                                                Zapisz
                                            </button>
                                        </div>
                                    </div>
                                    <div id="faq-accordion-2-collapse-2" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-2" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <textarea v-model="risk.risk_description"
                                                      class="form-control"
                                                      placeholder="Type your comments"
                                                      minlength="10">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-3" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-3" aria-expanded="false" aria-controls="faq-accordion-collapse-3">
                                            Obszar ryzyka
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-3" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-3" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <textarea v-model="risk.risk_area" class="form-control" placeholder="Type your comments" minlength="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-4" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4">
                                            Prawdopodobieństwo zdarzenia
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-4" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed w-1/4">
                                            <Multiselect
                                                v-model="risk.event_probability"
                                                max="1"
                                                :placeholder="risk.event_probability === null ? 'Wybierz...' : risk.event_probability"
                                                :options="[{
                                                   label: 'do 25%',
                                                   value: 0
                                                 },
                                                  {
                                                   label: 'do 50%',
                                                   value: 1
                                                },
                                                 {
                                                   label: 'do 75%',
                                                   value: 2
                                                },
                                                 {
                                                   label: 'ponad 75%',
                                                   value: 3
                                                }
                                                 ]"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-5" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4">
                                            Wpływ na koszt
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed w-1/4">
                                            <Multiselect
                                                v-model="risk.cost_impact"
                                                :placeholder="risk.cost_impact === null ? 'Wybierz...' : risk.cost_impact"
                                                :options="[{
                                                 label: 'Mały',
                                                 value: 0
                                                 },
                                                  {
                                                   label: 'Istotny',
                                                   value: 1
                                                },
                                                 {
                                                   label: 'Krytyczny',
                                                   value: 2
                                                }
                                                 ]"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-5" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4">
                                            Wpływ na harmonogram
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed w-1/4">
                                            <Multiselect
                                                v-model="risk.schedule_impact"
                                                :placeholder="risk.schedule_impact === null ? 'Wybierz...' : risk.schedule_impact"
                                                :options="[{
                                                 label: 'Mały',
                                                 value: 0
                                                 },
                                                  {
                                                   label: 'Istotny',
                                                   value: 1
                                                },
                                                 {
                                                   label: 'Krytyczny',
                                                   value: 2
                                                }
                                                 ]"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-6" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4">
                                            Wpływ na jakość realizacji
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-6" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed w-1/4">
                                            <Multiselect
                                                v-model="risk.quality_implementation_impact"
                                                :placeholder="risk.quality_implementation_impact === null ? 'Wybierz...' : risk.quality_implementation_impact"
                                                :options="[{
                                                 label: 'Mały',
                                                 value: 0
                                                 },
                                                  {
                                                   label: 'Istotny',
                                                   value: 1
                                                },
                                                 {
                                                   label: 'Krytyczny',
                                                   value: 2
                                                }
                                                 ]"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-7" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4">
                                            Sposób ograniczenia ryzyka
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-7" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <textarea v-model="risk.risk_limitations" class="form-control" placeholder="Type your comments" minlength="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-8" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4">
                                            Komentarz Iwestora
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-8" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <textarea v-model="risk.comment_investor" class="form-control" placeholder="Type your comments" minlength="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-9" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4">
                                            Komentarz Integratora
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-9" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <textarea v-model="risk.comment_integrator" class="form-control" placeholder="Type your comments" minlength="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ModalMatrix :show="show" @closed="modalClosed">
        <table class="table text-gray-800 mt-3">
                        <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Opis ryzyka</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Obszar ryzyka</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Prawdopodobieństwo zdarzenia</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Wpływ na koszt</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Wpływ na harmonogram</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Wpływ na jakość realizacji</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Sposób ograniczenia ryzyka</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Komentarz Integratora</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Komentarz Inwestora</th>
                        </tr>
                        </thead>
                        <tbody v-for="risk in riskRecords" :key="risk.id">
                        <tr>
                            <td class="border truncate" style="max-width: 10em;">{{risk.risk_description}}</td>
                            <td class="border truncate" style="max-width: 10em;">{{risk.risk_area}}</td>
                            <td v-if="risk.event_probability === 0" class="border" style="background-color: green;"></td>
                            <td v-if="risk.event_probability === 1" class="border" style="background-color: green;"></td>
                            <td v-if="risk.event_probability === 2" class="border" style="background-color: yellow;"></td>
                            <td v-if="risk.event_probability === 3" class="border" style="background-color: red;"></td>
                            <td v-if="risk.cost_impact === 0" style="background-color: green;" class="border"></td>
                            <td v-if="risk.cost_impact === 1" style="background-color: yellow;" class="border"></td>
                            <td v-if="risk.cost_impact === 2" style="background-color: red;" class="border"></td>
                            <td v-if="risk.schedule_impact === 0" style="background-color: green;" class="border"></td>
                            <td v-if="risk.schedule_impact === 1" style="background-color: yellow;" class="border"></td>
                            <td v-if="risk.schedule_impact === 2" style="background-color: red;" class="border"></td>
                            <td v-if="risk.quality_implementation_impact === 0" style="background-color: green;" class="border"></td>
                            <td v-if="risk.quality_implementation_impact === 1" style="background-color: yellow;" class="border"></td>
                            <td v-if="risk.quality_implementation_impact === 2" style="background-color: red;" class="border"></td>
                            <td class="border truncate" style="max-width: 10em;">{{risk.risk_limitations}}</td>
                            <td class="border truncate" style="max-width: 10em;">{{risk.comment_integrator}}</td>
                            <td class="border truncate" style="max-width: 10em;">{{risk.comment_investor}}</td>
                        </tr>
                        </tbody>
                    </table>
    </ModalMatrix>
</template>

<script>
import {computed, getCurrentInstance, onMounted, reactive, ref, watch} from "vue";
import {useToast} from "vue-toastification";
import RequestHandler from "../../../../compositions/RequestHandler";
import Multiselect from '@vueform/multiselect'
import ModalMatrix from "../../../../components/ModalMatrix";

export default {
    name: "RiskPanel",
    components: {Multiselect, ModalMatrix},
    props: {
        project: Object
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        const user = window.Laravel.user;
        const showDetails = ref([]);
        const guard = ref(false);
        const riskRecords = ref([]);
        const probability = require('../../../../json/probability_values.json');
        const impact = require('../../../../json/impact_values.json');
        const show = ref(false);

        const addNewRisk = async () => {
            let risk = {
                risk_area: '',
                risk_description: '',
                event_probability: '',
                cost_impact: '',
                schedule_impact: '',
                quality_implementation_impact: '',
                risk_limitations: '',
                comment_integrator: '',
                comment_investor: ''
            }
            setTimeout(function () {
                riskRecords.value.unshift(risk);
            }, 500)
        }
        const deleteRisk = async (risk) => {
            RequestHandler('projects/' + props.project.id + '/risk/' + risk.id + '/delete', 'post', {
                project_id: props.project.id,
                id: risk.id,
            }, (response) => {
                riskRecords.value.splice(riskRecords.value.indexOf(risk), 1);
            });
        }

        const saveRisk = async (risk) => {
            RequestHandler('projects/' + props.project.id + '/risk/save', 'post', {
                project_id: props.project.id,
                risk_id: risk.id,
                risk_area: risk.risk_area,
                risk_description: risk.risk_description,
                event_probability: risk.event_probability,
                cost_impact: risk.cost_impact,
                schedule_impact: risk.schedule_impact,
                quality_implementation_impact: risk.quality_implementation_impact,
                risk_limitations: risk.risk_limitations,
                comment_integrator: risk.comment_integrator,
                comment_investor: risk.comment_investor
            }, (response) => {
            });
        }

        const getRisks = async (callback) => {
            RequestHandler('projects/' + props.project.id + '/risks', 'get', {}, (response) => {
                riskRecords.value = response.data.risks
                callback(response);
            });
        }

        const modalClosed = () => {
            show.value = false;
        }

        onMounted(() => {
            getRisks(function () {
                guard.value = true;
            });
        });

        return {
            modalClosed,
            show,
            probability,
            impact,
            riskRecords,
            guard,
            showDetails,
            user,
            deleteRisk,
            addNewRisk,
            saveRisk,
        }
    }
}
</script>

<style scoped>

</style>
