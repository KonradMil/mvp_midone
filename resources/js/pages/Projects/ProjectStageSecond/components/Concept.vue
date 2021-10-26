<template>
    <tr>
        <td class="">
            <div class="font-medium whitespace-nowrap">{{ concept.title }}</div>
        </td>
        <td class="text-center flex">
            <Tippy
                v-if="concept.accepted === 0"
                tag="a"
                class="dark:text-gray-300 text-gray-600"
                content="Akceptuj">
                <button class="btn btn-primary mr-3 btn-sm max-h-9" @click.prevent="acceptConcept">
                    Akceptuję
                </button>
            </Tippy>
            <Tippy
                v-if="concept.accepted === 0"
                tag="a"
                class="dark:text-gray-300 text-gray-600"
                content="Odrzuć">
                <button class="btn btn-primary btn-sm max-h-9" @click.prevent="rejectConcept">
                    Odrzucam
                </button>
            </Tippy>
            <p v-if="concept.accepted === 1" class="intro-x text-theme-9">{{ $t('challengesMain.accepted') }}</p>
            <p v-if="concept.accepted === 2" class="intro-x text-theme-6">{{ $t('challengesMain.rejected') }}</p>
        </td>
        <td class="table-report__action w-56">
            <div class="flex justify-center items-center">
                <Tippy
                    tag="a"
                    class="dark:text-gray-300 text-gray-600"
                    content="Podgląd">
                    <button class="btn btn-primary btn-sm max-h-9" @click.prevent="showReview">
                        Podgląd
                    </button>
                </Tippy>
            </div>
        </td>
    </tr>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import RequestHandler from "../../../../compositions/RequestHandler";
import Multiselect from '@vueform/multiselect'
import ModalCard from "../../../../components/ModalCard";

export default {
    name: "Concept",
    components: {Multiselect, ModalCard},
    props: {
        concept: Object,
        project: Object,
        integrator: Object,
        investor: Object,
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const user = window.Laravel.user;
        const showDetails = ref([]);
        const is_selected = ref(0);
        const guard = ref(false);
        const show = ref(false);
        const addNewCommunicationPlan = async () => {
            let communicationPlan = {
                personal_occupation: '',
                personal_data: '',
                phone_number: '',
                email: 0,
                project_decision: 2
            }
            setTimeout(function () {
                if(user.id === props.integrator.id){
                    integratorCommunicationPlans.value.unshift(communicationPlan);
                } else {
                    investorCommunicationPlans.value.unshift(communicationPlan);
                }
            }, 500)
        }
        const deleteCommunicationPlan = async (communicationPlan) => {
            RequestHandler('projects/' + props.project.id + '/communication/' + communicationPlan.id + '/delete', 'post', {
                project_id: props.project.id,
                id: communicationPlan.id,
            }, (response) => {
                if(user.value.id === props.integrator.id){
                    integratorCommunicationPlans.value.splice(integratorCommunicationPlans.value.indexOf(communicationPlan), 1);
                } else {
                    investorCommunicationPlans.value.splice(investorCommunicationPlans.value.indexOf(communicationPlan), 1);
                }
            });
        }

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

        const acceptConcept = async () => {
            RequestHandler('projects/' + props.project.id + '/concept/accept', 'post', {
                project_id: props.project.id,
                concept_id: props.concept.id,
            }, (response) => {
                props.concept.accepted = 1;
            });
        }

        const rejectConcept = async () => {
            RequestHandler('projects/' + props.project.id + '/concept/reject', 'post', {
                project_id: props.project.id,
                concept_id: props.concept.id,
            }, (response) => {
                props.concept.accepted = 2;
            });
        }

        const showReview = async () => {
            emitter.emit('conceptReview', {concept: props.concept});
        }

        const modalClosed = () => {
            show.value = false;
        }

        onMounted(() => {

        });

        return {
            acceptConcept,
            rejectConcept,
            showReview,
            showDetails,
            modalClosed,
            show,
            guard,
            is_selected,
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
