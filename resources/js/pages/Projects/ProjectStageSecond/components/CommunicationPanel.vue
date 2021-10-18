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
                            <button class="intro-x btn btn-outline-secondary py-1 px-2" @click.prevent="deleteCommunicationPlan(communicationPlan)">
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
                                            <button class="intro-x btn btn-outline-secondary py-1 px-2" @click.prevent="saveCommunicationPlan(communicationPlan)">
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
                            <p v-if="communicationPlan.personalOccupation !== ''">{{ communicationPlan.personalOccupation }} </p>
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
                                                v-model="communicationPlan.personalOccupation"
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
                                                v-model="communicationPlan.personalData"
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
                                                v-model="communicationPlan.phoneNumber"
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
                                                v-model="communicationPlan.email"
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
                                                :disabled="communicationPlan.personalOccupation==='Manager projektu'"
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
        project: Object
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        const user = window.Laravel.user;
        const showDetails = ref([]);
        const communicationPlans = ref([
            {
                personalOccupation: 'Manager projektu',
                personalData: '',
                phoneNumber: '',
                email: '',
                decision: true,
            },
            {
                personalOccupation: 'Kontakt do spraw technicznych',
                personalData: '',
                phoneNumber: '',
                email: '',
                decision: true,
            },
            {
                personalOccupation: 'Kontakt do spraw administracyjnych',
                personalData: '',
                phoneNumber: '',
                email: '',
                decision: true,
            },
            {
                personalOccupation: 'Kontakt eskalacyjny',
                personalData: '',
                phoneNumber: '',
                email: '',
                decision: true,
            }
        ]);
        const is_selected = ref(0);
        const guard = ref(false);
        const show = ref(false);
        const addNewCommunicationPlan = async () => {
            let communicationPlan = {
                personalOccupation: '',
                personalData: '',
                phoneNumber: '',
                email: 0,
                decision: ''
            }
            setTimeout(function () {
                communicationPlans.value.unshift(communicationPlan);
            }, 500)
        }
        const deleteCommunicationPlan = async (communicationPlan) => {
            RequestHandler('projects/' + props.project.id + '/communication/' + communicationPlan.id + '/delete', 'post', {
                project_id: props.project.id,
                id: communicationPlan.id,
            }, (response) => {
                communicationPlans.value.splice(communicationPlans.value.indexOf(communicationPlan), 1);
            });
        }

        const saveCommunicationPlan = async (communicationPlan) => {
            RequestHandler('projects/' + props.project.id + '/communication/' + communicationPlan.id + '/save-communication', 'post', {
                project_id: props.project.id,
                id: communicationPlan.id,
                personalOccupation: communicationPlan.personalOccupation,
                personalData: communicationPlan.personalData,
                phoneNumber: communicationPlan.phoneNumber,
                email: communicationPlan.email,
            }, (response) => {
            });
        }

        const getCommunicationPlans = async (callback) => {
            RequestHandler('projects/' + props.project.id + '/communications', 'get', {}, (response) => {
               communicationPlans.value = response.data.communications
                callback(response);
            });
        }

        const modalClosed = () => {
            show.value = false;
        }

        onMounted(() => {
            getCommunicationPlans(function () {
                guard.value = true;
            });
        });

        return {
            showDetails,
            modalClosed,
            show,
            guard,
            is_selected,
            communicationPlans,
            user,
            deleteCommunicationPlan,
            addNewCommunicationPlan,
            saveCommunicationPlan,
        }
    }
}
</script>

<style scoped>

</style>
