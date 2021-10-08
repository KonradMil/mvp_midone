<template>
    <div class="flex">
        <!-- BEGIN: Content -->
        <div class="content">
            <div class="grid grid-cols-12 gap-6 mt-8">
                <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
                    <h2 class="intro-y text-lg font-medium mr-auto mt-2">
                    </h2>
                    <!-- BEGIN: Inbox Menu -->
                    <div class="intro-y box bg-theme-1 p-5 mt-6">
                        <button type="button" class="btn text-gray-700 dark:text-gray-300 w-full bg-white dark:bg-theme-1 mt-1 pr-9" @click.prevent="activeTab =    'report'"> <i class="w-4 h-4 mr-2" data-feather="edit-3"></i>{{$t('communication.reportError')}}</button>
                        <div class="border-t border-theme-3 dark:border-dark-5 mt-6 pt-6 text-white">
                    <div class="flex items-center px-3 py-2 mt-2 rounded-md cursor-pointer justify-center" :class="(activeTab === 'reports') ? 'bg-theme-20 dark:bg-dark-1 font-medium' : ''" @click.prevent="activeTab = 'reports'">
                                {{$t('communication.reports')}}
                            </div>
                        </div>
                    </div>
                    <!-- END: Inbox Menu -->
                </div>
                <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
                    <!-- BEGIN: Inbox Filter -->
                    <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
                        <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-gray-700 dark:text-gray-300" data-feather="search"></i>
                            <div class="inbox-filter dropdown absolute inset-y-0 mr-3 right-0 flex items-center" data-placement="bottom-start">
                                <i class="dropdown-toggle w-4 h-4 cursor-pointer text-gray-700 dark:text-gray-300" role="button" aria-expanded="false" data-feather="chevron-down"></i>
                                <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                                    <div class="dropdown-menu__content box p-5">
                                        <div class="grid grid-cols-12 gap-4 gap-y-3">
                                            <div class="col-span-6">
                                                <label for="input-filter-1" class="form-label text-xs">From</label>
                                                <input id="input-filter-1" type="text" class="form-control flex-1" placeholder="example@gmail.com">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-2" class="form-label text-xs">To</label>
                                                <input id="input-filter-2" type="text" class="form-control flex-1" placeholder="example@gmail.com">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-3" class="form-label text-xs">Subject</label>
                                                <input id="input-filter-3" type="text" class="form-control flex-1" placeholder="Important Meeting">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-4" class="form-label text-xs">Has the Words</label>
                                                <input id="input-filter-4" type="text" class="form-control flex-1" placeholder="Job, Work, Documentation">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-5" class="form-label text-xs">Doesn't Have</label>
                                                <input id="input-filter-5" type="text" class="form-control flex-1" placeholder="Job, Work, Documentation">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-6" class="form-label text-xs">Size</label>
                                                <select id="input-filter-6" class="form-select flex-1">
                                                    <option>10</option>
                                                    <option>25</option>
                                                    <option>35</option>
                                                    <option>50</option>
                                                </select>
                                            </div>
                                            <div class="col-span-12 flex items-center mt-3">
                                                <button class="btn btn-secondary w-32 ml-auto">Create Filter</button>
                                                <button class="btn btn-primary w-32 ml-2">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Inbox Filter -->
                    <!-- BEGIN: Inbox Content -->
                    <div class="intro-y inbox box mt-5">
                        <div class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                            <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-gray-200 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                <div class="dropdown ml-1" data-placement="bottom-start">
                                    <a class="dropdown-toggle w-5 h-5 block dark:text-gray-300" href="javascript:;" aria-expanded="false"> <i data-feather="chevron-down" class="w-5 h-5"></i> </a>
                                    <div class="dropdown-menu w-32">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2"> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">All</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">None</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Read</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Unread</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Starred</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Unstarred</a> </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="refresh-cw"></i> </a>
                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="more-horizontal"></i> </a>
                            </div>
                            <div class="flex items-center sm:ml-auto">

                            </div>
                        </div>
                        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible" :class="(activeTab==='reports')? '':'hidden'">
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
                                <Report class="intro-x"
                                        v-for="(report, index) in reports.list"
                                        :key="'report_' + index"
                                        :ind="index"
                                        :report="report">
                                </Report>
                                </tbody>
                            </table>
                        </div>
                        <ReportReview v-if="activeTab==='reportReview'" :report="report"></ReportReview>
                        <div class="intro-y box p-5" :class="(activeTab==='report')? '':'hidden'">
                            <AddReport></AddReport>
                        </div>
                    </div>
                    <!-- END: Inbox Content -->
                </div>
            </div>
        </div>

       <!-- END: Content -->
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, provide, ref, watch} from "vue";
import cash from "cash-dom";
import GetUsers from '../../compositions/GetUsers'
import GetNotifications from '../../compositions/GetNotifications'
import GetTeams from '../../compositions/GetTeams';
import GetReports from '../../compositions/GetReports';
import {useStore} from "../../store";
import Avatar from "../../components/avatar/Avatar";
import Modal from "../../components/Modal";
import Report from "./Report";
import AddReport from "./AddReport";
import ReportReview from "./ReportReview";
import Notifications from "./NotificationsOld";
import Teams from "./Teams";

const store = useStore();

export default {
    name: "Communication",
    props :{
        activeTab: String,
    },
    components: {
        Teams,
        Report,
        Avatar,
        Modal,
        Notifications,
        GetTeams,
        GetUsers,
        GetReports,
        AddReport,
        ReportReview
    },
    setup(props, {emit}) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const showDetails = ref([]);
        const users = ref([]);
        const user =ref({});
        const notifications = ref([]);
        const show = ref(false);
        const showTeams = ref(false);
        const activeTab = ref('reports');
        const teams = ref([]);
        const reports = ref([]);
        const report_id = ref(null);
        const reportReview = ref(false);
        const report = ref();

        emitter.on('changetab', e => {
            activeTab.value = e.val;
        });

        emitter.on('deletereport', e => {
           reports.value.list.splice(e.index, 1);
        });
        emitter.on('deleteteam', e => {
            teams.value.list.splice(e.index, 1);
        });

        emitter.on('addreport', e => {
            reports.value.list.push(e.obj);
        });

        emitter.on('reportReview', e => {
            report.value = e.report;
            activeTab.value = 'reportReview';
        });


        const GetReportsRepositiories = async () => {
            reports.value = GetReports();
        }
        const GetUsersRepositories = async () => {
            users.value = GetUsers();
        }
        const showAddTeams = () => {
            showTeams.value = !showTeams.value;
        }
        const showAddToTeamModal = () => {
               show.value = !show.value;
            }
        const modalClosed = () => {
            show.value = false;
        }
        const GetTeamsRepositiories = async () => {
            teams.value = GetTeams();
        }
        const GetNotificationsReposistories = async() => {
            notifications.value = GetNotifications();
        }
        onMounted( () => {
            GetUsersRepositories('');
            GetNotificationsReposistories('');
            GetTeamsRepositiories('');
            GetReportsRepositiories();

            cash("body")
                .removeClass("error-page")
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })
        return {
            report,
            reportReview,
            users,
            teams,
            user,
            showDetails,
            notifications,
            show,
            showAddToTeamModal,
            showTeams,
            showAddTeams,
            modalClosed,
            activeTab,
            reports,
            report_id,
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>

<style scoped>

</style>
