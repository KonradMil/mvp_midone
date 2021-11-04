<template>
    <div  :class="(solution.selected == 1)? 'selected-solution': '' ">
        <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4" :class="(solution.rejected == 1)? 'rejected-solution': '' ">
              <span v-if="user.type === 'investor' && check === 'true'" class="numberCircle clrGreen absolute top-3 right-3">
                  <span>
                      {{ index + 1}}
                  </span>
              </span>
            <div class="w-10 h-10 flex-none image-fit">
                <img
                    alt="DBR77"
                    class="rounded-full"
                    :src="'/' + props.solution.screenshot_path"/>
            </div>
            <div class="ml-3 mr-auto" @click="goTo('normalSolution')">
                <a href="" class="font-medium">{{ props.solution.name }} <span v-if="props.solution.selected == 1" style="color: #5e50ac;"> - {{$t('challengesMain.accepted')}}</span><span v-if="props.solution.rejected == 1" style="color: #1a202c;"> - {{$t('challengesMain.rejected')}}</span></a>
            </div>
        </div>
        <div class="p-5 border-t border-gray-200 dark:border-dark-5" >
            <div class="h-40 xxl:h-56 image-fit">
                <img @click="goTo('anotherSolution')"
                     alt="DBR77"
                     class="rounded-md"
                     :src="'/' + props.solution.screenshot_path"/>
            </div>
            <a href="" class="block font-medium text-base mt-5"></a>
            <div class="text-gray-700 dark:text-gray-600 mt-2" style="word-break: break-all; max-height: 100px; overflow-y: scroll;">
                {{ props.solution.description }}
            </div>
            <div class="mt-2 md:flex" v-if="canAccept && type!=='archive'">
                <button class="btn btn-primary shadow-md mr-2" @click="acceptSolution" v-if="solution.selected != 1  && solution.archive != 1 && acceptChallengeSolutions">{{$t('challengesMain.acceptSolution')}}</button>
                <button class="btn btn-primary shadow-md mr-2" @click="rejectSolution" v-if="solution.rejected != 1  && solution.archive != 1 && acceptChallengeSolutions">{{$t('challengesMain.rejectSolution')}}</button>
                <div :data-count=solutionFiles.length
                     class="dropdown-toggle notification notification--bullet cursor-pointer"
                     role="button"
                     aria-expanded="false">
                    <button class="btn btn-primary shadow-md mr-2" v-if="solution.archive !== 1 && acceptChallengeSolutions" @click="showAddFileModal">Pliki</button>
                </div>
            </div>
            <div class="mt-2 md:flex" v-if="canEdit || inTeam && type !=='archive' && type !== 'all'">
                <button class="btn btn-primary shadow-md mr-2" @click="$router.push({name: 'challengeStudio', params: {id: solution.id, type: 'solution', canEditSolution: canEditSolution}})" v-if="challenge.stage == 1 && !(solution.selected == 1 || solution.rejected == 1) && solution.archive != 1 && canEditSolution">{{$t('models.edit')}}</button>
                <button class="btn btn-primary shadow-md mr-2" @click="deleteSolution" v-if="challenge.stage == 1 && solution.selected != 1 && solution.archive != 1 && canDeleteSolution">{{$t('models.delete')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="solution.status == 0 && challenge.stage == 1 &&  solution.archive != 1 && canPublishSolution" @click="publishSolution">{{$t('challengesMain.publish')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="solution.status == 1 && !(solution.selected == 1 || solution.rejected == 1) && solution.archive != 1 && canPublishSolution" @click="unpublishSolution">{{$t('challengesMain.unpublish')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="canEdit && solution.archive != 1" @click="switchTab">{{$t('teams.teams')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="solution.archive !== 1 && user.type === 'integrator' && solution.selected === 1 && type!=='archive' && addSolutionOffer" @click="addOffer">{{$t('challengesMain.addOffer')}}</button>
                <div :data-count=solutionFiles.length
                     class="dropdown-toggle notification notification--bullet cursor-pointer"
                     role="button"
                     aria-expanded="false">
                    <button class="btn btn-primary shadow-md mr-2" v-if="canEdit && solution.archive != 1" @click="showAddFileModal">Pliki</button>
                </div>
            </div>
            <div class="mt-2 md:flex" v-if="type === 'all'">
                <button class="btn btn-primary shadow-md mr-2" @click="$router.push({name: 'challengeStudio', params: {id: solution.id, type: 'solution', canEditSolution: true}})" v-if="!(solution.selected == 1 || solution.rejected == 1) && solution.status !== 1">{{$t('models.edit')}}</button>
                <button class="btn btn-primary shadow-md mr-2" @click="deleteSolution" v-if="solution.selected != 1 && solution.status !== 1">{{$t('models.delete')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="solution.status == 0" @click="publishSolution">{{$t('challengesMain.publish')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="solution.status == 1 && !(solution.selected == 1 || solution.rejected == 1)" @click="unpublishSolution">{{$t('challengesMain.unpublish')}}</button>
                <button class="btn btn-primary shadow-md mr-2" @click="switchTab">{{$t('teams.teams')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="solution.selected === 1" @click="addOffer">{{$t('challengesMain.addOffer')}}</button>
                <div :data-count=solutionFiles.length
                     class="dropdown-toggle notification notification--bullet cursor-pointer"
                     role="button"
                     aria-expanded="false">
                    <button class="btn btn-primary shadow-md mr-2" @click="showAddFileModal">Pliki</button>
                </div>
            </div>
        </div>
        <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5">
            <div v-if="type === 'all' || type === 'archive'" class="w-10 h-10 flex-none image-fit">
                <img
                    alt="DBR77"
                    class="rounded-full"
                    :src="'/' + props.solution.challenge.screenshot_path"/>
            </div>
            <div v-if="type === 'all' || type === 'archive'" class="ml-3 mr-auto">
                <div class="font-medium">{{ props.solution.challenge.name }}</div>
            </div>
            <Tippy v-if="!solution.liked && solution.archive != 1"
                   @click.prevent="like(solution)"
                   tag="a" href=""
                   class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-auto"
                   content="Like">
                <ThumbsUpIcon class="w-3 h-3"/>
            </Tippy>
            <Tippy v-if="solution.liked && solution.archive != 1"
                   @click.prevent="dislike(solution)"
                   tag="a" href=""
                   class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 ml-auto"
                   content="Unlike">
                <ThumbsUpIcon class="w-3 h-3"/>
            </Tippy>
        </div>
        <div class="px-5 pt-3 pb-5 border-t border-gray-200 dark:border-dark-5">
            <CommentSection
                :object="solution"
                :user="user"
                :type_solution="type"
                type="solution"
            />
        </div>
    </div>
    <ModalFile :show="show" @closed="modalClosed">
        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
            <div class="mt-5">
                <div class="mt-3 border px-4 py-4" v-if="solutionFiles.length > 0">
                    <label class="form-label"> Wgrane pliki</label>
                    <div class="rounded-md pt-4">
                        <div class="grid grid-cols-4 h-full">
                            <div class=" h-full" v-for="(file, index) in solutionFiles" :key="'file_' + index">
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
                                    <button v-if="user.id === props.solution.author_id && props.solution.status !== 1" class="btn btn-outline-secondary py-1 px-2 mr-3" @click="deleteFile(index,file)">
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
                <div class="mt-3" v-if="solutionFiles.length <= 0 && user.id !== props.solution.author_id">
                    <span class="font-medium dark:text-theme-10 text-theme-1">Brak plików</span>
                </div>
                <div class="mt-3" v-if="user.id === props.solution.author_id && props.solution.status !== 1">
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
            <div v-if="user.id === props.solution.author_id && props.solution.status !== 1" class="flex flex-col lg:flex-row items-center p-5" style="justify-content: center;">
                <button class="btn btn-outline-secondary py-1 px-2" @click="saveFiles">
                    {{ $t('global.save') }}
                </button>
            </div>
        </div>
    </ModalFile>
</template>

<script>
import CommentSection from "./social/CommentSection";
import {computed, getCurrentInstance, onMounted, provide, ref} from "vue";
import router from "../router";
import {useToast} from "vue-toastification";
import TeamsPanelSolution from "../pages/Challenges/components/TeamsPanel";
import ModalFile from "./ModalFile";
import RequestHandler from "../compositions/RequestHandler";

export default {
    name: "SingleSolutionPost",
    components: {CommentSection, TeamsPanelSolution, ModalFile},
    props: {
        index: Number,
        challenge: {
            type: Object,
            default: ''
        },
        user: Object,
        solution: Object,
        canAccept: Boolean,
        canEdit: Boolean,
        activeTab: String,
        type: String,
        acceptChallengeSolutions: Boolean,
        canDeleteSolution: Boolean,
        canEditSolution: Boolean,
        addSolutionOffer: Boolean,
        canPublishSolution: Boolean,
        check: String
    },
    setup(props,context) {
        const toast = useToast();
        const solution = props.solution;
        const user = window.Laravel.user;
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const activeTab = ref(false);
        const inTeam = ref(false);
        const show = ref(false);
        const dropzoneSingleRef = ref();
        const solutionFiles = ref([]);
        const guard = ref(false);
        const images = ref([]);
        const isPublishSolution = ref('true');

        const modalClosed = () => {
            show.value = false;
        }

        const showAddFileModal = (id) => {
                show.value = !show.value;
            if(user.id === props.solution.author_id && props.solution.status !== 1) {
                refreshDropzone();
            }
        }

        const switchTab = () => {
            emitter.emit("activeTab", {name: 'teams', who: 'solution', solution: props.solution});
        }

        const teams = computed(() => {
            return props.solution.teams;
        }, () => {

        });

        const saveFiles = async () => {
            RequestHandler('solution/' + props.solution.id + '/files/save', 'post', {
                solutionFiles: solutionFiles.value
            }, (response) => {
            });
        }

        const refreshDropzone = async () => {
            const elDropzoneSingleRef = dropzoneSingleRef.value;
            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                solutionFiles.value.push(JSON.parse(resp.xhr.response).payload);
                images.value.push(JSON.parse(resp.xhr.response).payload);
                toast.success('Plik został wgrany poprawnie!');
            });
            elDropzoneSingleRef.dropzone.on("error", () => {
                toast.error("Maksymalnie można wgrać 8 plików!");
            });
        }

        const downloadFile = async (url,name) => {
            window.open('/' + url, '_blank').focus();
        }

        onMounted(() => {
            getSolutionFiles();
            checkTeam();
        });

        const addOffer = () => {
            emitter.emit('selectedSolution', {id: solution.id});
        }

        const checkTeam = () => {
            axios.post('/api/solution/check-team', {user_id: user.id, solution_id: props.solution.id})
                .then(response => {
                    if (response.data.success) {
                        inTeam.value = response.data.payload || (user.id == props.solution.author_id);
                    } else {

                    }
                })
        }

        const like = async (solution) => {
            axios.post('/api/solution/user/like', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        solution.liked = true;
                        emitter.emit('liked', {id: solution.id})
                    } else {
                    }
                })
        }
        const dislike = async (solution) => {
            axios.post('/api/solution/user/dislike', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        solution.liked = false;
                        emitter.emit('disliked', {id: solution.id})
                    } else {
                    }
                })
        }

        const acceptSolution = () => {
            axios.post('/api/solution/accept', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Rozwiązanie zostało zaakceptowane');
                        props.solution.selected = 1;
                        props.solution.rejected = 0;
                        emitter.emit("check", {check: true});
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const deleteSolution = async() => {
             axios.post('/api/solution/delete', {id: props.solution.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Rozwiązanie zostało usunięte');
                        emitter.emit('deletesolution', {solution: solution});
                    } else {
                    }
                })
        }

        const publishSolution = () => {
            axios.post('/api/solution/publish', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        props.solution.status = 1;
                              solution.status = 1;
                        toast.success('Rozwiązanie zostało opublikowane');
                        emitter.emit("isPublic", {isPublic: true});
                    } else {
                    }
                })
        }

        const getSolutionFiles = () => {
            axios.post('/api/solution/files/get', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        solutionFiles.value = response.data.payload;
                    } else {
                    }
                })
        }

        const rejectSolution = () => {
            axios.post('/api/solution/reject', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Rozwiązanie zostało odrzucone');
                        props.solution.rejected = 1;
                        props.solution.selected = 0;
                    } else {
                    }
                })
        }

        const unpublishSolution = () => {
            axios.post('/api/solution/unpublish', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        solution.status = 0;
                        props.solution.status = 0;
                        toast.success('Rozwiązanie jest teraz prywatne');
                    } else {
                    }
                })
        }

        const deleteFile = (index,file) => {
            RequestHandler('solution/file/delete', 'post', {
                solution_id: props.solution.id,
                file_id: file.id,
            }, (response) => {
                solutionFiles.value.splice(index, 1);
            });
        }

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        const goTo = async(link) => {
            if(link === 'normalSolution' && props.solution.status !== 1){
                console.log('normalSolution')
                await router.push({path: '/studio/solution/' + props.solution.id})
            } else if(link === 'anotherSolution' && props.solution.status !== 1){
                console.log('anotherSolution')
                await router.push({name: 'challengeStudio', params: {id: props.solution.id, type: 'solution', canEditSolution: props.canEditSolution}})
            } else if(props.solution.status === 1){
                console.log('publishSolution')
                await router.push({name: 'challengeStudio', params: {id: props.solution.id, type: 'solution', canEditSolution: props.canEditSolution, isPublishSolution: isPublishSolution.value}})
            }
        }

        return {
            isPublishSolution,
            goTo,
            downloadFile,
            getSolutionFiles,
            images,
            guard,
            saveFiles,
            solutionFiles,
            deleteFile,
            dropzoneSingleRef,
            showAddFileModal,
            modalClosed,
            show,
            switchTab,
            teams,
            activeTab,
            solution,
            user,
            like,
            dislike,
            props,
            acceptSolution,
            deleteSolution,
            unpublishSolution,
            publishSolution,
            rejectSolution,
            addOffer,
            inTeam,
        }
    }
}
</script>

<style scoped>

</style>
