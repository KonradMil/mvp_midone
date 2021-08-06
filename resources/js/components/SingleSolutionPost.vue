<template>
    <div  :class="(solution.selected == 1)? 'selected-solution': '' ">
        <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4" :class="(solution.rejected == 1)? 'rejected-solution': '' ">
            <div class="w-10 h-10 flex-none image-fit">
                <img
                    alt="Icewall Tailwind HTML Admin Template"
                    class="rounded-full"
                    :src="'/' + solution.screenshot_path"
                />
            </div>
            <div class="ml-3 mr-auto" @click="$router.push({path: '/studio/solution/' + solution.id});">
                <a href="" class="font-medium">{{ solution.name }} <span v-if="solution.selected == 1" style="color: #930f68;"> - {{$t('challengesMain.accepted')}}</span><span v-if="solution.rejected == 1" style="color: #1a202c;"> - {{$t('challengesMain.rejected')}}</span></a>
            </div>
            <!--        <div class="dropdown ml-3">-->
            <!--            <a href="javascript:;"-->
            <!--                class="dropdown-toggle w-5 h-5 text-gray-600 dark:text-gray-300"-->
            <!--                aria-expanded="false">-->
            <!--                <MoreVerticalIcon class="w-5 h-5"/>-->
            <!--            </a>-->
            <!--            <div class="dropdown-menu w-40">-->
            <!--                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">-->
            <!--                    <a href=""-->
            <!--                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">-->
            <!--                        <Edit2Icon class="w-4 h-4 mr-2"/>-->
            <!--                        {{$t('challengesMain.editPost')}}-->
            <!--                    </a>-->
            <!--                    <a href=""-->
            <!--                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">-->
            <!--                        <TrashIcon class="w-4 h-4 mr-2"/>-->
            <!--                        {{$t('challengesMain.deletePost')}}-->
            <!--                    </a>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
        </div>
        <div class="p-5 border-t border-gray-200 dark:border-dark-5" >
            <div class="h-40 xxl:h-56 image-fit">
                <img @click="$router.push({name: 'challengeStudio', params: {id: solution.id, type: 'solution', canEditSolution: canEditSolution}});"
                     alt="Icewall Tailwind HTML Admin Template"
                     class="rounded-md"
                     :src="'/' + solution.screenshot_path"
                />
            </div>
            <a href="" class="block font-medium text-base mt-5"></a>
            <div class="text-gray-700 dark:text-gray-600 mt-2" style="word-break: break-all; max-height: 100px; overflow-y: scroll;">
                {{ solution.description }}
            </div>
            <div class="mt-2" v-if="canAccept && type!=='archive'">
                <button class="btn btn-primary shadow-md mr-2" @click="acceptSolution" v-if="solution.selected != 1  && solution.archive != 1 && acceptChallengeSolutions">{{$t('challengesMain.acceptSolution')}}</button>
                <button class="btn btn-primary shadow-md mr-2" @click="rejectSolution" v-if="solution.rejected != 1  && solution.archive != 1 && acceptChallengeSolutions">{{$t('challengesMain.rejectSolution')}}</button>
            </div>
            <div class="mt-2" v-if="canEdit || inTeam && type!=='archive'">
<!--                <button class="btn btn-primary shadow-md mr-2" @click="$router.push({path: '/studio/solution/' + solution.id});" v-if="challenge.stage == 1 && !(solution.selected == 1 || solution.rejected == 1) && solution.archive != 1">{{$t('models.edit')}}</button>-->
                <button class="btn btn-primary shadow-md mr-2" @click="$router.push({name: 'challengeStudio', params: {id: solution.id, type: 'solution', canEditSolution: canEditSolution}})" v-if="challenge.stage == 1 && !(solution.selected == 1 || solution.rejected == 1) && solution.archive != 1 && canEditSolution">{{$t('models.edit')}}</button>
                <button class="btn btn-primary shadow-md mr-2" @click="deleteSolution" v-if="challenge.stage == 1 && solution.selected != 1 && solution.archive != 1 && canDeleteSolution">{{$t('models.delete')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="solution.status == 0 && challenge.stage == 1 &&  solution.archive != 1 && canPublishSolution" @click="publishSolution">{{$t('challengesMain.publish')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="solution.status == 1 && !(solution.selected == 1 || solution.rejected == 1) && solution.archive != 1 && canPublishSolution" @click="unpublishSolution">{{$t('challengesMain.unpublish')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="canEdit && solution.archive != 1" @click="switchTab">{{$t('teams.teams')}}</button>
                <button class="btn btn-primary shadow-md mr-2" v-if="solution.archive != 1" @click="showAddFileModal(solution.id)">Dodaj plik</button>
            </div>
            <div class="mt-2" v-if="user.type == 'integrator' && solution.selected == 1 && type!=='archive' && addSolutionOffer">
                <button v-if="solution.archive != 1" class="btn btn-primary shadow-md mr-2" @click="addOffer">{{$t('challengesMain.addOffer')}}</button>
            </div>
        </div>
        <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5">
            <Tippy
                tag="a"
                href=""
                class="intro-x w-8 h-8 flex items-center justify-center rounded-full border border-gray-400 dark:border-dark-5 dark:bg-dark-5 dark:text-gray-300 text-gray-600 mr-2"
                content="Bookmark">
                <BookmarkIcon class="w-3 h-3"/>
            </Tippy>
            <div class="intro-x flex mr-2">
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
                :solution_archive="solution.archive"
                type="solution"
            />
        </div>
    </div>
    <ModalFile :show="show" @closed="modalClosed">
        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
            <div class="mt-5">
<!--                <div class="mt-3" v-if="images.length > 0">-->
<!--                    <label class="form-label"> {{ $t('challengesNew.uploadedPhotos') }}</label>-->
<!--                    <div class="rounded-md pt-4">-->
<!--                        <div class="row flex h-full">-->
<!--                            <div class=" h-full" v-for="(image, index) in images" :key="'image_' + index">-->
<!--                                <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;">-->
<!--                                    <img class="w-full h-full"-->
<!--                                         :alt="image.original_name"-->
<!--                                         :src="'/' + image.path"-->
<!--                                    />-->
<!--                                    <div style="width: 94%; bottom: 0; position: relative; margin-top: 100%; margin-left: 10px; font-size: 16px; font-weight: bold;">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div style="width: 94%; bottom: 0; position: relative;  margin-left: 10px; font-size: 16px; font-weight: bold;" @click="deleteImage(index)" class="cursor-pointer">USUŃ-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="mt-3">
                    <label class="form-label"> {{ $t('challengesNew.file') }}</label>
                    <div class="rounded-md pt-4">
                        <div class="flex flex-wrap px-4">
                            <Dropzone
                                style="position: relative;
                                                    display: flex;"
                                ref-key="dropzoneSingleRef"
                                :options="{
                              url: '/api/solution/images/store',
                              thumbnailWidth: 150,
                              maxFilesize: 5,
                              maxFiles: 5,
                              previewTemplate: '<div style=\'display: none\'></div>'
                            }"
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
        </div>
    </ModalFile>

    <!--    <TeamsPanelSolution v-if="activeTab && (solution.author_id === user.id)" :solution="solution"/>-->
</template>

<script>
import CommentSection from "./social/CommentSection";
import {computed, getCurrentInstance, onMounted, provide, ref} from "vue";
import router from "../router";
import {useToast} from "vue-toastification";
import TeamsPanelSolution from "../pages/Challenges/components/TeamsPanel";
import ModalFile from "./ModalFile";

export default {
    name: "SingleSolutionPost",
    components: {CommentSection, TeamsPanelSolution, ModalFile},
    props: {
        index: Number,
        challenge: Object,
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
        canPublishSolution: Boolean
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
        const images = ref([]);

        const modalClosed = () => {
            show.value = false;
        }

        const showAddFileModal = (id) => {
                show.value = !show.value;
            }

        const switchTab = () => {
            console.log('Switch2244444');
            console.log(props.solution + ' its props solution');
            emitter.emit("activeTab", {name: 'teams', who: 'solution', solution: props.solution});
        }

        const teams = computed(() => {
            return props.solution.teams3
        }, () => {

        });

        onMounted(() => {
            checkTeam();
            const elDropzoneSingleRef = dropzoneSingleRef.value;
            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                images.value.push(JSON.parse(resp.xhr.response).payload);
                toast.success('Zdjecie zostało wgrane poprawnie!');
            });
            elDropzoneSingleRef.dropzone.on("error", () => {
                toast.error("Błąd");
            });
        });

        const addOffer = () => {
            emitter.emit('selectedSolution', {id: solution.id});
        }

        const checkTeam = () => {
            console.log({user_id: user.id, challenge_id: props.solution.id});
            axios.post('/api/solution/check-team', {user_id: user.id, solution_id: props.solution.id})
                .then(response => {
                    console.log("response.data")
                    console.log(response.data)
                    if (response.data.success) {
                        inTeam.value = response.data.payload || (user.id == props.solution.author_id);
                    } else {

                    }
                })
        }

        const like = async (solution) => {
            axios.post('/api/solution/user/like', {id: solution.id})
                .then(response => {
                    console.log(response.data);
                    if (response.data.success) {
                        solution.liked = true;
                        console.log('HOW MANY LIKES');
                        emitter.emit('liked', {id: solution.id})
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }
        const dislike = async (solution) => {
            axios.post('/api/solution/user/dislike', {id: solution.id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        solution.liked = false;
                        console.log('HOW MANY DISLIKES');
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
            await axios.post('/api/solution/delete', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Rozwiązanie zostało usunięte');
                        emitter.emit('deletesolution', {index: props.index, id: solution.id});
                        // router.push({name: 'challenges'});
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const publishSolution = () => {
            axios.post('/api/solution/publish', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        solution.status = 1;
                        toast.success('Rozwiązanie zostało opublikowane');
                        emitter.emit("isPublic", {isPublic: true});
                    } else {
                        // toast.error(response.data.message);
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
                        // toast.error(response.data.message);
                    }
                })
        }

        const unpublishSolution = () => {
            axios.post('/api/solution/unpublish', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        solution.status = 0;
                        toast.success('Rozwiązanie jest teraz prywatne');
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        return {
            images,
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
