<template>
    <div class="intro-y box p-5">
        <div class="absolute top-0 right-0">
            <button class="btn btn-outline-secondary py-3 px-4" @click.prevent="backToAll">
                Wróć
            </button>
        </div>
        <div>
            <label for="crud-form-1" class="form-label font-medium">Definicja stanowiska</label>
            <div>{{concept.title}}</div>
        </div>
        <div class="pt-5">
            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                    {{$t('challengesNew.description')}}
                </div>
                <div class="mt-5 mb-3 pb-4">
                    <p class="w-auto h-36 font-serif break-words">{{concept.description}}</p>
                </div>
            </div>
        </div>
        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
            <div class="mt-5">
                <div class="mt-3" v-if="concept.files.length > 0">
                    <label class="form-label"> Pliki</label>
                    <div class="rounded-md pt-4">
                        <div class="row flex h-full">
                            <div class=" h-full" v-for="(file, index) in concept.files" :key="'file_' + index">
                                <Tippy class="dark:text-gray-300 text-gray-600"
                                       :content="file.original_name">
                                <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;">
                                    <img class="w-full h-full"
                                         :alt="file.original_name"
                                         :src="'/' + file.path"/>
                                    <div style="width: 94%; bottom: 0; position: relative; margin-top: 100%; margin-left: 10px; font-size: 16px; font-weight: bold;">
                                    </div>
                                </div>
                                </Tippy>
                                <div style="width: 94%; bottom: 0; position: relative;  margin-left: 10px; font-size: 16px; font-weight: bold;"
                                     class="cursor-pointer px-6">
                                    <button v-if="user.id === concept.author_id && concept.accepted !== 2" class="btn btn-outline-secondary py-1 px-2 mr-3" @click="deleteFile(index,file)">
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
                <div class="mt-3" v-else>
                    <span class="font-medium dark:text-theme-10 text-theme-1">Brak plików</span>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <ConceptQuestionPanel :concept="1" :concept_id="concept.id" :project="project" :type="'concept'"></ConceptQuestionPanel>
        </div>
    </div>
</template>
<script>
import {getCurrentInstance, onMounted, provide, ref} from "vue";
import Dropzone from '../../../../global-components/dropzone/Main'
import Avatar from "../../../../components/avatar/Avatar";
import ConceptQuestionPanel  from "./ConceptQuestionPanel";
import RequestHandler from "../../../../compositions/RequestHandler";

export default {
    name: "ConceptReview",
    components: {
        Avatar,
        Dropzone,
        ConceptQuestionPanel,
    },
    props : {
        project: Object,
        concept: Object
    },
    setup(props, {emit}) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const user =ref({});
        const reports = ref([]);
        const files = ref([]);
        const dropzoneSingleRef = ref();
        const guard = ref(false);
        const images = ref([]);

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        const backToAll = () => {
            emitter.emit('backToAllConcepts', {});
        }

        const downloadFile = async (url,name) => {
            window.open('/' + url, '_blank').focus();
        }

        const deleteFile = (index,file) => {
            RequestHandler('projects/' + props.project.id + '/file/delete', 'post', {
                concept_id: props.concept.id,
                file_id: file.id,
            }, (response) => {
                props.concept.files.splice(index, 1);
            });
        }

        onMounted(function () {
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })
        return {
            backToAll,
            deleteFile,
            images,
            downloadFile,
            guard,
            user,
            reports,
            files
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
