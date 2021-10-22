<template>
    <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9" v-if="guard === true">
        <div class="intro-y box" v-if="activeTab === 'all-concepts'">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Koncepcja stanowiska
            </h2>
            <div class="absolute top-4 left-80 cursor-pointer px-6">
                <button class="btn btn-primary mr-6">
                    Akceptuję
                </button>
            </div>
            <div class="cursor-pointer px-6">
                <button class="btn btn-outline-secondary py-1 px-2" @click.prevent="setActiveTab('addConcept')">
                    Dodaj nowa dokumentacje
                </button>
            </div>
        </div>
            <table class="table table-report -mt-2">
                <thead>
                <tr>
                    <th class="whitespace-nowrap">Plik</th>
                    <th class="whitespace-nowrap">Tytuł</th>
                    <th class="text-center whitespace-nowrap">Zgłoszono dnia</th>
                    <th class="text-center whitespace-nowrap"></th>
                </tr>
                </thead>
                <tbody>
                <Concept class="intro-x"
                         v-for="(concept, index) in concepts"
                         :key="concept.id"
                         :concept="concept">
                </Concept>
                </tbody>
            </table>
        </div>
        <div class="intro-y box px-10 py-10" v-if="activeTab === 'addConcept'">
            <AddConcept :project="project"></AddConcept>
        </div>
        <ConceptReview v-if="activeTab==='conceptReview'" :project="project" :concept="main_concept"></ConceptReview>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
import RequestHandler from "../../../../compositions/RequestHandler";
import Multiselect from '@vueform/multiselect'
import ModalCard from "../../../../components/ModalCard";
import AddConcept from "./AddConcept";
import ConceptReview from "./ConceptReview";
import Concept from "./Concept";
export default {
    name: "PositionsConceptPanel",
    components: {AddConcept, Multiselect, ModalCard, ConceptReview, Concept},
    props: {
        project: Object,
        integrator: Object,
        investor: Object,
    },
    setup(props) {

        const setActiveTab = (param) => {
            activeTab.value = param;
        }
        const activeTab = ref('all-concepts');
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        const user = window.Laravel.user;
        const showDetails = ref([]);
        const is_selected = ref(0);
        const guard = ref(false);
        const show = ref(false);
        const concepts = ref([]);
        const main_concept = ref({});
        const addNewCommunicationPlan = async () => {
        }

        const getConcepts = async (callback) => {
            RequestHandler('projects/' + props.project.id + '/concepts', 'get', {}, (response) => {
                concepts.value = response.data.concepts
                callback(response);
            });
        }

        emitter.on('addConcept', e => {
            concepts.value.push(e.obj);
            activeTab.value = 'all-concepts'
        });

        const saveCommunicationPlan = async (communicationPlan) => {
            RequestHandler('projects/' + props.project.id + '/communication/save', 'post', {
                project_id: props.project.id,
                communication_plan_id: communicationPlan.id,
                personal_occupation: communicationPlan.personal_occupation,
                personal_data: communicationPlan.personal_data,
                phone_number: communicationPlan.phone_number,
                email: communicationPlan.email,
                project_decision: communicationPlan.project_decision
            }, (response) => {
            });
        }

        emitter.on('conceptReview', e => {
            main_concept.value = e.concept;
            activeTab.value = 'conceptReview';
        });

        const modalClosed = () => {
            show.value = false;
        }

        onMounted(() => {
            getConcepts(()=>{
                guard.value = true;
            })
        });

        return {
            main_concept,
            guard,
            getConcepts,
            concepts,
            setActiveTab,
            activeTab
        }
    }
}
</script>

<style scoped>

</style>
