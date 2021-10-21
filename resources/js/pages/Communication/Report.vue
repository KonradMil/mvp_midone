<template>
    <tr>
        <td class="w-40 truncate">
            <div class="flex" v-if="rep.files != undefined">
                <div class="w-10 h-10 image-fit" v-if="rep.files.length != '0'">
                    {{ rep.files[0].original_name }}
                </div>
            </div>
        </td>
        <td>
            <div class="font-medium whitespace-nowrap">{{ rep.title }}</div>
            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{rep.type}}</div>
        </td>
        <td class="text-center">{{ $dayjs(rep.created_at).format('DD.MM.YYYY HH:mm') }}</td>
        <td class="table-report__action w-56">
            <div class="flex justify-center items-center">
                <a class="flex items-center mr-3" href="javascript:" @click.prevent="showReview"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Podgląd </a>
            </div>
        </td>
    </tr>
</template>

<script>
import {useToast} from "vue-toastification";
import {getCurrentInstance, onMounted, ref} from "vue";
import ReportReview from "./ReportReview";

export default {
    name: "Report",
    components: {ReportReview},
    props: {
        report: Object,
        ind: Number
    },
    setup(props, {emit}) {
        const isDisabled = ref(false);
        const toast = useToast();
        const rep = ref({});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const details = ref(false);

        const del = async (report_id) => {delete
            axios.post('api/report/user/delete', {id: report_id})
                .then(response => {
                    if (response.data.success) {
                        toast.success(response.data.message);
                        emitter.emit('deletereport', {index: props.ind});
                        isDisabled.value = true;
                    } else {
                        toast.warning('Nie możesz usunąć!');
                        isDisabled.value = true;
                    }
                    setTimeout(() =>{
                       isDisabled.value = false;
                    }, 2000);
                })

        }

        const showReview = async () => {
            emitter.emit('reportReview', {report: props.report});
        }

        onMounted( () => {
           rep.value = props.report;
        });

        return {
            showReview,
            details,
            isDisabled,
            del,
            rep
        }
    }

}
</script>

<style scoped>

</style>
