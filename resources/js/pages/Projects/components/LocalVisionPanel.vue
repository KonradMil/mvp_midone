<template>
    <div class="intro-y" style="width: 1200px;">
    <div class="intro-y box shadow-2xl md:w-1/2 lg:w-1/2 xl:w-1/2 2xl:w-full sm:w-1/2 max-w-5xl" v-if="guard === true">
        <div class="intro-y flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Wizja lokalna
            </h2>
            <div class="flex items-center justify-center text-theme-1" style="margin-right: 500px;"
                 v-if="project.accept_local_vision === 1"><i data-feather="check-square" class="w-4 h-4 mr-2"></i>Zakończono
                etap
            </div>
            <button
                v-if="(user.id === integrator.id || user.id === investor.id) && project.accept_local_vision < 1 && check === true"
                class="btn btn-primary mr-6 mt-3" @click.prevent="acceptLocalVision">Zakończ etap
            </button>
            <button v-if="challenge.selected[0].author_id === user.id && project.accept_local_vision !== 1"
                    class="btn btn-primary w-15 mt-3 mr-3" @click.prevent="addNewReport">
                Dodaj raport
            </button>
            <div :data-count=projectFiles.length
                 class="dropdown-toggle notification notification--bullet cursor-pointer"
                 role="button"
                 aria-expanded="false">
                <button class="btn btn-primary w-15 mt-3 mr-1" v-if="user.id === integrator.id || user.id === investor.id" @click="showAddFileModal">Pliki</button>
            </div>
        </div>
        <div class="intro-y inbox box mt-5 overflow-y-auto" style="max-height: 521px; overflow-x: hidden;">
            <transition-group tag="ul" name="list">
            <li v-for="report in reports" :key="report.id">
                <div class="intro-y">
                    <div :class="(showDetails[report.id] === true) ? 'inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-200 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1 md:w-1/2 lg:w-1/2 xl:w-1/2 2xl:w-full sm:w-1/2 max-w-5xl' : 'inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1 md:w-1/2 lg:w-1/2 xl:w-1/2 2xl:w-full sm:w-1/2 max-w-5xl'">
                        <div class="flex px-5 py-3 pb-5">
                            <div @click="showDetails[report.id] = !showDetails[report.id]" class="w-72 flex-none flex items-center mr-5" v-if="report.author !== undefined">
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="W trakcie podejmowania decyzji">
                                    <EditIcon v-if="report.accepted === 0" class="w-5 h-5 mr-2 ml-2 text-red-600"/>
                                </Tippy>
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Zaakceptowano">
                                    <CheckCircleIcon v-if="report.accepted === 1"
                                                     class="w-6 h-6 mr-2 ml-2 text-green-600"/>
                                </Tippy>
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Odrzucono">
                                    <XCircleIcon v-if="report.accepted === 2" class="w-6 h-6 mr-2 ml-2 text-red-600"/>
                                </Tippy>
                                <div class="w-6 h-6 flex-none image-fit relative ml-5">
                                    <Avatar :src="'/s3/avatars/' + report.author.avatar"
                                            :username="report.author.name + ' ' + report.author.lastname" :size="30"
                                            color="#FFF" background-color="#5e50ac"/>
                                </div>
                                <div class="inbox__item--sender truncate ml-3">{{ report.author.name }}
                                    {{ report.author.lastname }}
                                </div>
                            </div>
                            <div @click="showDetails[report.id] = !showDetails[report.id]" class="w-64 sm:w-auto truncate pt-3 pl-6" style="max-width: 200px;">
                                <span class="inbox__item--highlight" v-if="report.author_id >= 1">{{
                                        report.description
                                    }}</span>
                                <span class="inbox__item--highlight" v-else>Uzupełnij raport!</span>
                            </div>
                            <div @click="showDetails[report.id] = !showDetails[report.id]" class="inbox__item--time whitespace-nowrap ml-auto pl-10 pr-4 pt-3">
                                <p class="text-theme-9" v-if="report.accepted === 1">
                                    {{ $t('challengesMain.accepted') }}</p>
                                <p class="text-theme-6" v-if="report.accepted === 2">
                                    {{ $t('challengesMain.rejected') }}</p>
                                <p v-if="report.accepted === 0">{{ $t('challengesMain.waitingApproval') }}</p>
                            </div>
                            <div class="pt-1 flex"
                                 v-if="report.author_id !== '' && investor.id === user.id && report.accepted === 0">
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Akceptuj">
                                    <button class="btn btn-primary mr-3 btn-sm max-h-9" @click.prevent="acceptReport(report)">
                                        Akceptuję zmiany
                                    </button>
                                </Tippy>
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Odrzuć">
                                    <button class="btn btn-primary btn-sm max-h-9" @click.prevent="rejectReport(report)">
                                        Odrzucam zmiany
                                    </button>
                                </Tippy>
                            </div>
                            <div class="pt-1" v-if="integrator.id === user.id && report.accepted < 1 && report.author_id >= 1">
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Usuń">
                                    <button class="btn btn-primary btn-sm" @click.prevent="deleteReport(report)">Usuń
                                    </button>
                                </Tippy>
                            </div>
                        </div>
                    </div>
                </div>
                <ul v-if="showDetails[report.id] === true" class="intro-y pt-4 pl-5">
                    <li class="intro-y">
                        <div class="sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                            <div class="flex px-5 py-3 pb-5">
                                <label for="input-wizard-1" class="form-label" style="width: 750px;">
                                    Czego dotyczy
                                    <textarea
                                        maxlength="400"
                                        style="height: 100px;"
                                        :disabled="integrator.id !== user.id || report.accepted === 1 || report.accepted === 2 && project.accept_local_vision !== 1"
                                        type="text"
                                        v-model="report.description"
                                        class="mt-3 w-full px-3 py-2 text-gray-700 border rounded-lg border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-700 focus:border-transparent"/>
                                </label>
                            </div>
                        </div>
                    </li>
                    <li class="intro-y">
                        <div class="sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                            <div class="flex px-5 py-3 pb-5">
                                <label for="input-wizard-1" class="form-label" style="width: 750px;">
                                    Stan początkowy
                                    <textarea
                                        maxlength="400"
                                        style="height: 100px;"
                                        :disabled="integrator.id !== user.id || report.accepted === 1 || report.accepted === 2 && project.accept_local_vision !== 1"
                                        type="text"
                                        v-model="report.before"
                                        class="mt-3 w-full px-3 py-2 text-gray-700 border rounded-lg border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-700 focus:border-transparent"/>
                                </label>
                            </div>
                        </div>
                    </li>
                    <li class="intro-y">
                        <div class="sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                            <div class="flex px-5 py-3 pb-5">
                                <label for="input-wizard-1" class="form-label" style="width: 750px;">
                                    Stan końcowy
                                    <textarea
                                        maxlength="400"
                                        style="height: 100px;"
                                        :disabled="integrator.id !== user.id || report.accepted === 1 || report.accepted === 2 && project.accept_local_vision !== 1"
                                        type="text"
                                        v-model="report.after"
                                        class="mt-3 w-full px-3 py-2 text-gray-700 border rounded-lg border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-700 focus:border-transparent"/>
                                </label>
                            </div>
                            <button v-if="integrator.id === user.id && report.accepted < 1"
                                    class="btn btn-primary mr-3 btn-sm" style="margin-left: 25px; margin-bottom: 20px;"
                                    @click.prevent="saveReport(report)">Zapisz
                            </button>
                        </div>
                    </li>
                    <li class="intro-y"
                        v-if="(report.comment !== '' && integrator.id === user.id) || investor.id === user.id">
                        <div class="sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                            <div class="flex px-5 py-3 pb-5">
                                <label for="input-wizard-1" class="form-label" style="width: 750px;">
                                    Komentarz inwestora
                                    <textarea
                                        maxlength="400"
                                        style="height: 100px;"
                                        :disabled="investor.id !== user.id || report.accepted === 1 || report.accepted === 2 && project.accept_local_vision !== 1"
                                        v-model="report.comment"
                                        type="text"
                                        :class="(report.comment === null && report.accepted === 0 && user.id === investor.id) ? 'mt-3 w-full px-3 py-2 text-gray-700 border rounded-lg border border-transparent focus:outline-none ring-2 ring-pink-700 border-transparent' : 'mt-3 w-full px-3 py-2 text-gray-700 border rounded-lg border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-700 focus:border-transparent'"/>
                                </label>
                            </div>
                            <button v-if="investor.id === user.id && report.accepted === 0"
                                    class="btn btn-primary mr-3 btn-sm" style="margin-left: 25px; margin-bottom: 20px;"
                                    @click.prevent="saveComment(report)">Zapisz
                            </button>
                        </div>
                    </li>
                </ul>
            </li>
            </transition-group>
            <div v-if="reports.length === 0" class="text-theme-1 dark:text-theme-10 font-medium pl-6 py-3 pb-4"
                 style="font-size: 16px;">
                Nie ma jeszcze żadnych raportów.
            </div>
        </div>
    </div>
    </div>
    <ModalFile :show="show" @closed="modalClosed">
        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
            <div class="mt-5">
                <div class="mt-3 border px-4 py-4" v-if="projectFiles.length > 0">
                    <label class="form-label"> Wgrane pliki</label>
                    <div class="rounded-md pt-4">
                        <div class="grid grid-cols-4 h-full">
                            <div class=" h-full" v-for="(file, index) in projectFiles" :key="'file_' + index">
                                <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;">
                                    <img
                                        v-lazy="'/' + file.path"
                                        class="w-full h-full"
                                        :alt="file.original_name"/>
                                    <div style="width: 94%; bottom: 0; position: relative; margin-top: 100%; margin-left: 10px; font-size: 16px; font-weight: bold;">
                                    </div>
                                </div>
                                <div style="width: 94%; bottom: 0; position: relative;  margin-left: 10px; font-size: 16px; font-weight: bold;"
                                     class="cursor-pointer px-6">
                                    <button v-if="user.id === file.author_id" class="btn btn-outline-secondary py-1 px-2 mr-3" @click="deleteFile(index,file)">
                                        Usuń
                                    </button>
                                    <button class="btn btn-outline-secondary py-1 px-2" @click="downloadFile(file.path, file.name)">
                                        Pobierz
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3" v-if="projectFiles.length <= 0">
                    <span class="font-medium dark:text-theme-10 text-theme-1">Brak plików</span>
                </div>
                <div class="mt-3" v-if="user.id === integrator.id || user.id === investor.id && project.accept_local_vision !== 1">
                    <label class="form-label"> {{ $t('challengesNew.file') }}</label>
                    <div class="rounded-md pt-4">
                        <div class="flex flex-wrap px-4">
                            <Dropzone
                                style="position: relative;
                                                    display: flex;"
                                ref-key="dropzoneSingleRef"
                                :options="{
                                url: '/api/challenge/images/store',
                                thumbnailWidth: 150,
                                maxFilesize: 8,
                                maxFiles: 8,
                                previewTemplate: '<div style=\'display: none\'></div>'}"
                                class="dropzone">
                                <div class="px-4 py-4 flex items-center cursor-pointer relative">
                                    <ImageIcon class="w-4 h-4 mr-2"/>
                                    <span class="text-theme-1 dark:text-theme-10 mr-1">
                                        {{ $t('challengesNew.file') }}
                                    </span>
                                    {{ $t('challengesNew.fileUpload') }}
                                </div>
                            </Dropzone>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="user.id === integrator.id  || user.id === investor.id && project.accept_local_vision !== 1" class="flex flex-col lg:flex-row items-center p-5" style="justify-content: center;">
                <button class="btn btn-outline-secondary py-1 px-2" @click="saveFiles">
                    {{ $t('global.save') }}
                </button>
            </div>
        </div>
    </ModalFile>
</template>

<script>
import {computed, getCurrentInstance, onMounted, provide, reactive, ref, watch} from "vue";
import {useToast} from "vue-toastification";
import Avatar from "../../../components/avatar/Avatar";
import RequestHandler from "../../../compositions/RequestHandler";
import ModalFile from "../../../components/ModalFile";

export default {
    name: "LocalVisionPanel",
    props: {
        challenge_id: Number,
        author_id: Number,
        challenge_author_id: Number,
        project: Object,
        challenge: Object,
        integrator: Object,
        investor: Object,
    },
    components: {
        Avatar, ModalFile
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const reports = ref([]);
        const toast = useToast();
        const user = window.Laravel.user;
        const showDetails = ref([]);
        const guard = ref(false);
        const rejects = ref([]);
        const check = ref(false);
        const show = ref(false);
        const projectFiles = ref([]);
        const dropzoneSingleRef = ref();


        const removeReport = async (index) => {
            reports.value.splice(index, 1);
        }

        const addNewReport = async () => {
            let report = {
                id: 0,
                description: '',
                before: '',
                after: '',
                accepted: 0,
                comment: '',
                author_id: '',
            }
            setTimeout(function () {
                reports.value.unshift(report);
            }, 500)
        }

        const deleteReport = async (report) => {
            showDetails.value[report.id] = false;
            RequestHandler('projects/' + props.project.id + '/local-vision/' + report.id + '/delete', 'post', {
                project_id: props.project.id,
                id: report.id,
            }, (response) => {
                reports.value.splice(reports.value.indexOf(report), 1);
                getReports();
            });
        }

        const saveReport = async (report) => {
            RequestHandler('projects/' + props.project.id + '/local-vision/save', 'post', {
                project_id: props.project.id,
                report_id: report.id,
                description: report.description,
                before: report.before,
                after: report.after,
                accepted: report.accepted,
            }, (response) => {
                report.author_id = user.id;
                showDetails.value[report.id] = false;
                getReports();
            });
        }

        const saveComment = async (report) => {
            RequestHandler('projects/' + props.project.id + '/local-vision/' + report.id + '/save_comment', 'post', {
                project_id: props.project.id,
                id: report.id,
                comment: report.comment
            }, (response) => {
                showDetails.value[report.id] = false;
                setTimeout(function (){
                    if(rejects.value.indexOf(report) !== -1){
                        rejectReport(report);
                    }
                }, 500)
                setTimeout(function (){
                    getReports();
                }, 500)
            });
        }

        const saveReports = async (report) => {
            axios
                .post('/api/projects/local-vision/save', {id: props.challenge_id, reports: reports.value})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zapisano poprawnie');
                        report.author_id = user.id;
                        showDetails.value[report.id] = false;
                        getReports();
                    } else {

                    }
                })
                .catch(function (error) {
                    let resData = error.response.data;
                    if (error.response.status === 400) {
                        for (let i in resData.errors) {
                            for (let k in resData.errors[i].messages) {
                                toast.error(resData.errors[i].messages[k]);
                            }
                        }
                    }
                });
        }

        const getFiles = async (callback) => {
            RequestHandler('projects/' + props.project.id + '/files', 'get', {}, (response) => {
                projectFiles.value = response.data.projectFiles
                callback(response);
            });
        }

        const getReports = async (callback) => {
            RequestHandler('projects/' + props.project.id + '/local-vision', 'get', {}, (response) => {
                reports.value = response.data.reports,
                check.value = response.data.check,
                callback(response);
            });
        }

        const acceptLocalVision = async () => {
            RequestHandler('projects/' + props.project.id + '/local-vision/end', 'post', {
                project_id: props.project.id,
            }, (response) => {
                props.project.accept_local_vision = 1;
                emitter.emit('acceptLocalVision', {})
            });
        }
        const rejectLocalVision = async () => {
            axios.post('/api/projects/local-vision/reject', {id: props.challenge_id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Odrzucono');
                        emitter.emit('rejectLocalVision', {});
                    } else {

                    }
                })
                .catch(function (error) {
                    let resData = error.response.data;
                    if (error.response.status === 400) {
                        for (let i in resData.errors) {
                            for (let k in resData.errors[i].messages) {
                                toast.error(resData.errors[i].messages[k]);
                            }
                        }
                    }
                });
        }

        const acceptReport = async (report) => {
            RequestHandler('projects/' + props.project.id + '/local-vision/' + report.id + '/accept', 'post', {
                project_id: props.project.id,
                id: report.id,
            }, (response) => {
                report.accepted = 1;
                showDetails.value[report.id] = false;
                getReports();
            });
        }

        const rejectReport = async (report) => {
            if (report.comment === null || report.comment === ''){
                if(rejects.value.indexOf(report) === -1){
                    rejects.value.push(report);
                }
                toast.warning('Przy odrzuceniu raportu konieczny jest komentarz!')
                showDetails.value[report.id] = !showDetails.value[report.id];
            } else {
                RequestHandler('projects/' + props.project.id + '/local-vision/' + report.id + '/reject', 'post', {
                    project_id: props.project.id,
                    id: report.id,
                }, (response) => {
                    report.accepted = 2;
                    showDetails.value[report.id] = false;
                    getReports();
                });
            }
        }

        const saveFiles = async () => {
            RequestHandler('projects/' + props.project.id + '/files/save', 'post', {
                projectFiles: projectFiles.value
            }, (response) => {
            });
        }

        const deleteFile = (index,file) => {
            RequestHandler('projects/' + props.project.id + '/file/delete', 'post', {
                file_id: file.id,
            }, (response) => {
                projectFiles.value.splice(index, 1);
            });
        }

        const showAddFileModal = (id) => {
            show.value = !show.value;
        }

        const modalClosed = () => {
            show.value = false;
        }

        const downloadFile = async (url,name) => {
            window.open('/' + url, '_blank').focus();
        }

        onMounted(() => {
            getReports(function () {
                getFiles(()=>{
                    guard.value = true;
                });
            });
            const elDropzoneSingleRef = dropzoneSingleRef.value;
            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                projectFiles.value.push(JSON.parse(resp.xhr.response).payload);
                toast.success('Zdjecie zostało wgrane poprawnie!');
                });
                elDropzoneSingleRef.dropzone.on("error", () => {
                    toast.error("Maksymalnie można wgrać 8 plików!");
                });
        });

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        return {
            saveFiles,
            downloadFile,
            deleteFile,
            projectFiles,
            showAddFileModal,
            modalClosed,
            show,
            check,
            rejects,
            guard,
            showDetails,
            rejectReport,
            acceptReport,
            user,
            deleteReport,
            reports,
            addNewReport,
            removeReport,
            saveReports,
            saveReport,
            saveComment,
            acceptLocalVision,
            rejectLocalVision
        }
    }
}
</script>

<style scoped>

.list-leave-from {
    opacity: 1;
    transform: scale(1);
}
.list-leave-to {
    opacity: 0;
    transform: scale(0.6);
}
.list-leave-active {
    transition: all 0.4s ease;
}


</style>
