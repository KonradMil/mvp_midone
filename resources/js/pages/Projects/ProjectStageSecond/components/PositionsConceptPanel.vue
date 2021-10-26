<template>
    <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9" v-if="guard === true">
        <div class="intro-y box" v-if="activeTab === 'all-concepts'">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Koncepcja stanowiska
            </h2>
            <div class="absolute top-4 left-80 cursor-pointer px-6">
                <button v-if="integrator.id === user.id" class="btn btn-primary mr-6">
                    Potwierdzam przekazanie dokumentacji
                </button>
                <button v-if="investor.id === user.id" class="btn btn-primary mr-6">
                    Potwierdzam przekazanie dokumentacji
                </button>
            </div>
            <div class="cursor-pointer px-6">
                <button class="btn btn-outline-secondary py-2 px-4" @click.prevent="setActiveTab('addConcept')">
                    Dodaj nowa dokumentacje
                </button>
            </div>
        </div>
            <table class="table table-report table-auto w-6/7">
                <thead>
                <tr>
                    <th class="whitespace-nowrap"></th>
                    <th class="text-center whitespace-nowrap"></th>
                    <th class="text-center whitespace-nowrap"></th>
                </tr>
                </thead>
                <tbody>
                <Concept class="intro-x"
                         v-for="(concept, index) in concepts"
                         :key="concept.id"
                         :concept="concept"
                         :integrator="integrator"
                         :investor="investor"
                         :project="project">
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
        const user = window.Laravel.user;
        const guard = ref(false);
        const concepts = ref([]);
        const main_concept = ref({});


        const getConcepts = async (callback) => {
            RequestHandler('projects/' + props.project.id + '/concepts', 'get', {}, (response) => {
                concepts.value = response.data.concepts
                callback(response);
            });
        }

        emitter.on('addConcept', e => {
            activeTab.value = 'all-concepts'
            getConcepts();
        });

        emitter.on('backToAllConcepts', e => {
            activeTab.value = 'all-concepts'
        });
        emitter.on('conceptReview', e => {
            main_concept.value = e.concept;
            activeTab.value = 'conceptReview';
        });

        onMounted(() => {
            getConcepts(()=>{
                guard.value = true;
            })
        });

        return {
            user,
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
