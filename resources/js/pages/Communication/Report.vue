<template>
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
            <tr>
                <th class="whitespace-nowrap">Plik</th>
                <th class="whitespace-nowrap">Tytuł</th>
                <th class="text-center whitespace-nowrap">Zgłoszono dnia</th>
                <th class="text-center whitespace-nowrap">STATUS</th>
                <th class="text-center whitespace-nowrap">ACTIONS</th>
            </tr>
            </thead>
            <tbody>
            <tr class="intro-x"
                v-for="(report, index) in reports.list"
                :key="'team_' + index"
            >
                <td class="w-40">
                    <div class="flex">
                        <div class="w-10 h-10 image-fit zoom-in">
                            File
                            <!--                                                {{report.file.name}}-->
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
            </tbody>
        </table>
    </div>

</template>

<script>
import GetReports from "../../compositions/GetReports";
import {useToast} from "vue-toastification";


export default {
   name: "Report",
   components :{
       GetReports
   },
   setup(props, {emit}) {
       const toast = useToast();
       const reports = ref([]);

       const getReportRepositories = async () => {
           reports.value = GetReports();
       }

       onMounted(() => {
           getReportRepositories('');
       })

       return {
           reports,
       }
   }

}
</script>

<style scoped>

</style>
