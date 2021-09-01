<template>
    <div class="intro-y box shadow-2xl" style="width: 1000px;">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Wizja lokalna
            </h2>
            <div class="flex items-center justify-center text-theme-9" v-if="project.project_accept_vision === 1 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.accepted')}}</div>
            <div class="flex items-center justify-center text-theme-6" v-if="project.project_accept_vision === 2 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.rejected')}}</div>
            <div class="flex items-center mr-3" v-if="project.project_accept_vision < 1 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.waitingApproval')}}</div>
            <button v-if="challenge_author_id === user.id" class="btn btn-primary" @click.prevent="acceptLocalVision">Akceptuje zmiany</button>
            <button v-if="challenge_author_id === user.id" class="btn btn-primary" @click.prevent="rejectLocalVision">Odrzucam zmiany</button>
            <div v-if="author_id === user.id" class="cursor-pointer pr-3" @click.prevent="addNewReport">
                <PlusCircleIcon/>
            </div>
            <button v-if="author_id === user.id" class="btn btn-primary w-20 mt-3" @click.prevent="saveReports">{{$t('profiles.save')}}</button>
        </div>
        <div class="p-5" id="bordered-table">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table text-gray-100 bg-gradient-to-l from-pink-500 to-pink-900">
                        <thead>
                        <tr class="text-left border-b-2 border-pink-300">
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Opis</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Przed</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Po</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="intro-x text-left border-b-2 border-pink-300" v-for="(report, index) in reports"
                            :key="index">
                            <td class="border">
                                <textarea maxlength="100"
                                          type="text"
                                          v-model="report.description"
                                          class="form-control text-gray-600"/>
                            </td>
                            <td class="border">
                                <textarea maxlength="100"
                                          type="text"
                                          v-model="report.before"
                                          class="form-control text-gray-600"/>
                            </td>
                            <td class="border">
                                <textarea maxlength="100"
                                          type="text"
                                          v-model="report.after"
                                          class="form-control text-gray-600"/>
                            </td>
                            <div v-if="author_id === user.id" class="cursor-pointer pt-4 pl-2" @click.prevent="deleteReport(index,report.id)">
                                <MinusCircleIcon/>
                            </div>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="source-code hidden">
                <button data-target="#copy-bordered-table" class="copy-code btn py-1 px-2 btn-outline-secondary"><i
                    data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code
                </button>
                <div class="overflow-y-auto mt-3 rounded-md">
                    <pre class="source-preview" id="copy-bordered-table"> <code
                        class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTagdiv class=&quot;overflow-x-auto&quot;HTMLCloseTag HTMLOpenTagtable class=&quot;table&quot;HTMLCloseTag HTMLOpenTagtheadHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTag#HTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagFirst NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagLast NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagUsernameHTMLOpenTag/thHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/theadHTMLCloseTag HTMLOpenTagtbodyHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag1HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagAngelinaHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagJolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@angelinajolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag2HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagBradHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagPittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@bradpittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag3HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagCharlieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagHunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@charliehunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/tbodyHTMLCloseTag HTMLOpenTag/tableHTMLCloseTag HTMLOpenTag/divHTMLCloseTag </code> </pre>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, getCurrentInstance, onMounted, reactive, ref} from "vue";
import {useToast} from "vue-toastification";

export default {
    name: "LocalVisionPanel",
    props: {
        challenge_id: Number,
        author_id: Number,
        challenge_author_id: Number,
        project: Object
    },

    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const reports = ref([]);
        const toast = useToast();
        const user = window.Laravel.user;
        const removeReport = async (index) => {
            reports.value.splice(index, 1);
        }

        const addNewReport = async () => {
            let report = {
                description: '',
                before: '',
                after: '',
            }
            setTimeout(function () {
                reports.value.push(report);
            }, 750)
        }
        const deleteReport = async (index,id) => {
            axios.post('/api/projects/local-vision/delete', {id: id})
                .then(response => {
                    if (response.data.success) {
                        reports.value.splice(index, 1);
                        toast.success('Usunięto poprawnie');
                    } else {

                    }
                }, removeReport)
        }
        const saveReports = async () => {
            axios.post('/api/projects/local-vision/save', {id: props.challenge_id, reports: reports.value})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zapisano poprawnie');
                    } else {

                    }
                })
        }
        const getReports = async () => {
            axios.post('/api/projects/local-vision/get', {id: props.challenge_id})
                .then(response => {
                    if (response.data.success) {
                        reports.value = response.data.payload;
                    } else {

                    }
                })
        }
        const acceptLocalVision = async () => {
            axios.post('/api/projects/local-vision/accept', {id: props.challenge_id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zapisano poprawnie');
                        emitter.emit('acceptLocalVision', {});
                    } else {

                    }
                })
        }

        onMounted(() => {
            getReports();
        });

        return {
            user,
            deleteReport,
            reports,
            addNewReport,
            removeReport,
            saveReports,
            acceptLocalVision
        }
    }
}
</script>

<style scoped>

</style>
