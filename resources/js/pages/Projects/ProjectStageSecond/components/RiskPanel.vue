<template>
    <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9">
        <div class="intro-y box">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Stworzenie planu zarządzania ryzykiem
                </h2>
                <div class="cursor-pointer px-6">
                    <button @click.prevent="addNewRisk" class="btn btn-outline-secondary py-1 px-2">
                        Dodaj
                    </button>
                </div>
            </div>
            <div id="faq-accordion-1" class="accordion p-5 max-h-96 overflow-auto">
                <div class="intro-y accordion-item" v-for="risk in riskRecords" :key="risk.id">
                    <div id="faq-accordion-content-1" class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2">
                            <p v-if="risk.riskDescription !== ''">{{ risk.riskDescription }} </p>
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
                                            <button class="intro-x btn btn-outline-secondary py-1 px-2" @click.prevent="addNewCommunicationPlan(communicationPlan)">
                                                Zapisz
                                            </button>
                                        </div>
                                    </div>
                                    <div id="faq-accordion-2-collapse-2" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-2" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <textarea v-model="risk.riskDescription"
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
                                            <textarea v-model="risk.riskArea" class="form-control" placeholder="Type your comments" minlength="10"></textarea>
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
                                                v-model="risk.eventProbability"
                                                max="1"
                                                :placeholder="risk.eventProbability === null ? 'Wybierz...' : risk.eventProbability"
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
                                                v-model="risk.costImpact"
                                                :placeholder="risk.costImpact === null ? 'Wybierz...' : risk.costImpact"
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
                                                v-model="risk.qualityImplementationImpact"
                                                :placeholder="risk.qualityImplementationImpact === null ? 'Wybierz...' : risk.qualityImplementationImpact"
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
                                            <textarea v-model="risk.riskLimitations" class="form-control" placeholder="Type your comments" minlength="10"></textarea>
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
                                            <textarea v-model="risk.commentInvestor" class="form-control" placeholder="Type your comments" minlength="10"></textarea>
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
                                            <textarea v-model="risk.commentIntegrator" class="form-control" placeholder="Type your comments" minlength="10"></textarea>
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
</template>

<script>
import {computed, getCurrentInstance, onMounted, reactive, ref, watch} from "vue";
import {useToast} from "vue-toastification";
import RequestHandler from "../../../../compositions/RequestHandler";
import Multiselect from '@vueform/multiselect'

export default {
    name: "RiskPanel",
    components: {Multiselect},
    props: {
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        const user = window.Laravel.user;
        const deadlines = ref([]);
        const showDetails = ref([]);
        const is_selected = ref(0);
        const guard = ref(false);
        const block = ref(false);
        const date = ref('');
        const inputValue = ref('');
        const inputEvents = ref('');
        const newDate = new Date();
        const riskRecords = ref([]);
        const probability = require('../../../../json/probability_values.json');
        const impact = require('../../../../json/impact_values.json');


        const addNewRisk = async () => {
            let risk = {
                riskArea: '',
                riskDescription: '',
                eventProbability: '',
                costImpact: '',
                scheduleImpact: '',
                qualityImplementationImpact: '',
                riskLimitations: '',
                commentIntegrator: '',
                commentInvestor: ''
            }
            setTimeout(function () {
                riskRecords.value.unshift(risk);
            }, 500)
        }
        const deleteDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/delete', 'post', {
                project_id: props.project.id,
                id: deadline.id,
            }, (response) => {
                deadlines.value.splice(deadlines.value.indexOf(deadline), 1);
            });
        }

        const saveMembers = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/save_members', 'post', {
                project_id: props.project.id,
                id: deadline.id,
                members: deadline.members
            }, (response) => {
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        const saveDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/save', 'post', {
                date: deadline.date,
                time: deadline.time
            }, (response) => {
                // if (deadline.members === '') {
                //     deadlines.value.unshift(deadline);
                // }
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        const getDeadlines = async (callback) => {
            RequestHandler('projects/' + props.project.id + '/visit-date', 'get', {}, (response) => {
               deadlines.value = response.data.deadlines
                callback(response);
            });
        }
        const acceptDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/accept', 'post', {
                project_id: props.project.id,
                id: deadline.id,
            }, (response) => {
                deadline.accepted = 1;
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        const acceptVisitDate = async () => {
            axios.post('/api/projects/visit-date/end', {id: props.project.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zaakceptowano');
                        emitter.emit('acceptLocalVision', {});
                    } else {

                    }
                })
                .catch(function (error) {
                    let resData = error.response.data;
                    if (error.response.status === 400) {
                        for (let i in resData.errors) {
                            for (let k in resData.errors[i].messages) {
                                toast.error(resData.errors[i].messages[k]);
                            }
                        }
                    }
                });
        }

        const rejectDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/reject', 'post', {
                project_id: props.project.id,
                id: deadline.id,
            }, (response) => {
                deadline.accepted = 2;
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        const cancelDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/cancel', 'post', {
                project_id: props.project.id,
                id: deadline.id,
            }, (response) => {
                deadline.status = 1;
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        onMounted(() => {
            getDeadlines(function () {
                guard.value = true;
            });
        });

        return {
            probability,
            impact,
            riskRecords,
            newDate,
            inputValue,
            inputEvents,
            date,
            block,
            guard,
            is_selected,
            showDetails,
            deadlines,
            user,
            deleteDeadline,
            addNewRisk,
            saveDeadline,
            acceptDeadline,
            rejectDeadline,
            acceptVisitDate,
            cancelDeadline,
            saveMembers
        }
    }
}
</script>

<style scoped>

</style>
