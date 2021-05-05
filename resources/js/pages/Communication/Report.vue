<template>
    <tr>
        <td class="w-40">
            <div class="flex">
                <div class="w-10 h-10 image-fit zoom-in" v-if="report.files.length != '0'">
                    {{ report.files[0].original_name }}
                </div>
            </div>
        </td>
        <td>
            <a href="" class="font-medium whitespace-nowrap">{{ report.title }}</a>
            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{report.type}}</div>
        </td>
        <td class="text-center">{{ $dayjs(report.created_at).format('DD.MM.YYYY HH:mm') }}</td>
        <td class="w-40">
            <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ report.description }} </div>
        </td>
        <td class="table-report__action w-56">
            <div class="flex justify-center items-center">
                <a class="flex items-center mr-3" href="javascript:" @click.prevent="$router.push({path: '/report/show/' + report.id })"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Podgląd </a>
                <a @click.prevent="del(report)" class="flex items-center text-theme-6" href="" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
            </div>
        </td>
    </tr>

</template>

<script>


import DeleteReport from '../../compositions/DeleteReport';
import {useToast} from "vue-toastification";

export default {
    name: "Report",
    props: {
        report: Object
    },
    setup(props, {emit}) {
        const toast = useToast();

        const del = async (report) => {
            axios.post('api/report/user/delete', {id: report.id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        toast.success(response.data.message);
                        console.log(report);

                    } else {
                        // toast.error(response.data.message);
                    }
                })

        }

        return {
            del
        }
    }

}
</script>

<style scoped>

</style>
