<template>
    <tr>
        <td class="w-40 truncate">
            <div class="flex" v-if="concept.files !== undefined">
                <div class="w-10 h-10 image-fit" v-if="concept.files.length !== '0'">
                    {{ concept.files[0].original_name }}
                </div>
            </div>
        </td>
        <td>
            <div class="font-medium whitespace-nowrap">{{ concept.title }}</div>
            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{concept.type}}</div>
        </td>
        <td class="text-center">{{ $dayjs(concept.created_at).format('DD.MM.YYYY HH:mm') }}</td>
        <td class="table-report__action w-56">
            <div class="flex justify-center items-center">
                <a class="flex items-center mr-3" href="javascript:" @click.prevent="showReview"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Podgląd </a>
            </div>
        </td>
    </tr>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
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
        const toast = useToast();
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

        const showReview = async () => {
            emitter.emit('conceptReview', {concept: props.concept});
        }

        const modalClosed = () => {
            show.value = false;
        }

        onMounted(() => {

        });

        return {
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
