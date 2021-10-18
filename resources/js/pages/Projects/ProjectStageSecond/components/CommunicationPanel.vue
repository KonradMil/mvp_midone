<template>
    <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9">
        <div v-if="user.type === 'integrator'" class="intro-y box">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Stworzenie planu komunikacji integratora
                </h2>
                <div class="absolute top-4 left-80 cursor-pointer px-6">
                    <button class="btn btn-primary mr-6" @click.prevent="show=true">
                        Akceptuję
                    </button>
                </div>
                <div class="cursor-pointer px-6">
                    <button class="btn btn-outline-secondary py-1 px-2" @click.prevent="addNewCommunicationPlan">
                        Dodaj
                    </button>
                </div>
            </div>
            <div id="faq-accordion-1" class="accordion p-5 max-h-96 overflow-auto">
                <div class="intro-y accordion-item" v-for="communicationPlan in communicationPlans" :key="communicationPlan.id">
                    <div id="faq-accordion-content-5" class="accordion-header">
                        <button class="accordion-button collapsed mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2">
                            <p v-if="communicationPlan.type !== ''">{{ communicationPlan.type }} </p>
                            <p v-else> Uzupełnij </p>
                        </button>
                        <div class="absolute top-0 right-0 cursor-pointer px-6 pt-2">
                            <button class="intro-x btn btn-outline-secondary py-1 px-2" @click.prevent="addNewCommunicationPlan(communicationPlan)">
                                Usuń
                            </button>
                        </div>
                    </div>
                    <div id="faq-accordion-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-2" data-bs-parent="#faq-accordion-1">
                        <div class="intro-y accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                            <div id="faq-accordion-2" class="intro-y accordion p-5">
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-2" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2">
                                            Definicja stanowiska
                                        </button>
                                        <div class="absolute top-0 right-0 cursor-pointer px-6 pt-2">
                                            <button class="intro-x btn btn-outline-secondary py-1 px-2" @click.prevent="addNewCommunicationPlan(communicationPlan)">
                                                Zapisz
                                            </button>
                                        </div>
                                    </div>
                                    <div id="faq-accordion-2-collapse-2" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-2" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <input
                                                v-model="communicationPlan.type"
                                                id="regular-form-2"
                                                type="text"
                                                class="form-control w-1/3"
                                                placeholder="Dane personalne">
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-3" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-3" aria-expanded="false" aria-controls="faq-accordion-collapse-3">
                                            Dane personalne
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-3" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-3" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <input
                                                v-model="communicationPlan.personal_data"
                                                id="regular-form-3"
                                                type="text"
                                                class="form-control w-1/3"
                                                placeholder="Numer telefonu">
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-4" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-3" aria-expanded="false" aria-controls="faq-accordion-collapse-3">Numer telefonu</button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-4" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-3" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <input
                                                v-model="communicationPlan.number"
                                                id="regular-form-4"
                                                type="text"
                                                class="form-control w-1/3"
                                                placeholder="Numer telefonu">
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-5" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4"> E-mail </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <input
                                                v-model="communicationPlan.mail"
                                                id="regular-form-5"
                                                type="text"
                                                class="form-control w-1/3"
                                                placeholder="E-mail">
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-6" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4">Decyzyjność w projekcie</button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-6" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                             <select
                                                 :disabled="communicationPlan.type==='Manager projektu'"
                                                 v-model="communicationPlan.decision"
                                                 class="tom-select w-1/5 tomselected h-10 border">
                                                 <option value="1" selected="true">Tak</option>
                                                 <option value="2">Nie</option>
                                             </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="user.type === 'investor'" class="intro-y box">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Stworzenie planu komunikacji inwestora
                </h2>
                <div class="absolute top-4 left-80 cursor-pointer px-6">
                    <button class="btn btn-primary mr-6" @click.prevent="show=true">
                        Akceptuję
                    </button>
                </div>
                <div class="cursor-pointer px-6">
                    <button class="btn btn-outline-secondary py-1 px-2" @click.prevent="addNewCommunicationPlan">
                        Dodaj
                    </button>
                </div>
            </div>
            <div id="faq-accordion-3" class="accordion p-5 max-h-96 overflow-auto">
                <div class="intro-y accordion-item" v-for="communicationPlan in communicationPlans" :key="communicationPlan.id">
                    <div id="faq-accordion-content-6" class="accordion-header">
                        <button class="accordion-button collapsed mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2">
                            <p v-if="communicationPlan.type !== ''">{{ communicationPlan.type }} </p>
                            <p v-else> Uzupełnij </p>
                        </button>
                        <div class="absolute top-0 right-0 cursor-pointer px-6 pt-2">
                            <button class="intro-x btn btn-outline-secondary py-1 px-2" @click.prevent="addNewCommunicationPlan(communicationPlan)">
                                Usuń
                            </button>
                        </div>
                    </div>
                    <div id="faq-accordion-collapse-6" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-2" data-bs-parent="#faq-accordion-1">
                        <div class="intro-y accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                            <div id="faq-accordion-4" class="intro-y accordion p-5">
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-3-content-6" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2">
                                            Definicja stanowiska
                                        </button>
                                        <div class="absolute top-0 right-0 cursor-pointer px-6 pt-2">
                                            <button class="intro-x btn btn-outline-secondary py-1 px-2" @click.prevent="addNewCommunicationPlan(communicationPlan)">
                                                Zapisz
                                            </button>
                                        </div>
                                    </div>
                                    <div id="faq-accordion-2-collapse-2" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-2" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <input
                                                v-model="communicationPlan.type"
                                                id="regular-form-2"
                                                type="text"
                                                class="form-control w-1/3"
                                                placeholder="Dane personalne">
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-3" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-3" aria-expanded="false" aria-controls="faq-accordion-collapse-3">
                                            Dane personalne
                                        </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-3" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-3" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <input
                                                v-model="communicationPlan.personal_data"
                                                id="regular-form-3"
                                                type="text"
                                                class="form-control w-1/3"
                                                placeholder="Numer telefonu">
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-4" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-3" aria-expanded="false" aria-controls="faq-accordion-collapse-3">Numer telefonu</button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-4" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-3" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <input
                                                v-model="communicationPlan.number"
                                                id="regular-form-4"
                                                type="text"
                                                class="form-control w-1/3"
                                                placeholder="Numer telefonu">
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-5" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4"> E-mail </button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <input
                                                v-model="communicationPlan.mail"
                                                id="regular-form-5"
                                                type="text"
                                                class="form-control w-1/3"
                                                placeholder="E-mail">
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y accordion-item">
                                    <div id="faq-accordion-2-content-6" class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4">Decyzyjność w projekcie</button>
                                    </div>
                                    <div id="faq-accordion-2-collapse-6" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-bs-parent="#faq-accordion-1">
                                        <div class="accordion-body text-gray-700 dark:text-gray-600 leading-relaxed">
                                            <select
                                                :disabled="communicationPlan.type==='Manager projektu'"
                                                v-model="communicationPlan.decision"
                                                class="tom-select w-1/5 tomselected h-10 border">
                                                <option value="1" selected="true">Tak</option>
                                                <option value="2">Nie</option>
                                            </select>
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
    <ModalCard :show="show" @closed="modalClosed">
        <h3 class="intro-y text-lg font-medium mt-5">
            Potwierdzam zgodność danych. Potwierdzam, że osoby wskazane do reprezentacji mają prawo do zawierania umów oraz zaciagania zobowiązań.
        </h3>
        <div class="intro-y box p-5 mt-12 sm:mt-5" style="text-align: center;">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                <button class="btn btn-primary shadow-md mr-2">Tak</button>
                <button class="btn btn-primary shadow-md mr-2">Anuluj</button>
            </div>
        </div>
    </ModalCard>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
import RequestHandler from "../../../../compositions/RequestHandler";
import Multiselect from '@vueform/multiselect'
import ModalCard from "../../../../components/ModalCard";

export default {
    name: "CommunicationPanel",
    components: {Multiselect, ModalCard},
    props: {
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        const user = window.Laravel.user;
        const showDetails = ref([]);
        const communicationPlans = ref([
            {
                type: 'Manager projektu',
                personal_data: '',
                number: '',
                mail: '',
                decision: true,
            },
            {
                type: 'Kontakt do spraw technicznych',
                personal_data: '',
                number: '',
                mail: '',
                decision: true,
            },
            {
                type: 'Kontakt do spraw administracyjnych',
                personal_data: '',
                number: '',
                mail: '',
                decision: true,
            },
            {
                type: 'Kontakt eskalacyjny',
                personal_data: '',
                number: '',
                mail: '',
                decision: true,
            }
        ]);
        const is_selected = ref(0);
        const guard = ref(false);
        const block = ref(false);
        const date = ref('');
        const inputValue = ref('');
        const inputEvents = ref('');
        const show = ref(false);
        const addNewCommunicationPlan = async () => {
            block.value = true;
            let person = {
                type: '',
                personal_data: '',
                number: '',
                mail: 0,
                decision: ''
            }
            setTimeout(function () {
                communicationPlans.value.unshift(person);
            }, 500)
            setTimeout(function () {
                block.value = false;
            }, 2000);
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

        const modalClosed = () => {
            show.value = false;
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
            showDetails,
            modalClosed,
            show,
            inputValue,
            inputEvents,
            date,
            block,
            guard,
            is_selected,
            communicationPlans,
            user,
            deleteDeadline,
            addNewCommunicationPlan,
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
