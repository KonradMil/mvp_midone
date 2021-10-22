<template>
    <div>
        <label for="crud-form-1" class="form-label">Tytuł wiadomości</label>
        <input maxlength="100"
               id="crud-form-1"
               type="text"
               class="form-control w-full"
               placeholder="Title"
               v-model="concept.title">
    </div>
    <div class="pt-5">
        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
            <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                {{ $t('challengesNew.description') }}
            </div>
            <div class="mt-5">
                <textarea
                    v-model="concept.description"
                    class="w-full h-36 form-control" style="width: 100%;"></textarea>
            </div>
        </div>
    </div>
    <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
        <div class="mt-5">
            <div class="mt-3 border px-4 py-4" v-if="files.length > 0">
                <label class="form-label"> Wgrane pliki</label>
                <div class="rounded-md pt-4">
                    <div class="grid grid-cols-4 h-full">
                        <div class=" h-full" v-for="(file, index) in files" :key="'file_' + index">
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
                                <button class="btn btn-outline-secondary py-1 px-2 mr-3" @click="deleteFile(index,file)">
                                    Usuń
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!--            <div class="mt-3" v-if="files.length > 0">-->
<!--                <label class="form-label"> {{ $t('challengesNew.uploadedPhotos') }}</label>-->
<!--                <div class="rounded-md pt-4">-->
<!--                    <div class="row flex h-full">-->
<!--                        <div class=" h-full" v-for="(file, index) in files" :key="'file_' + index">-->
<!--                            <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;">-->
<!--                                <img class="w-full h-full"-->
<!--                                     :alt="file.original_name"-->
<!--                                     :src="'/' + file.path"-->
<!--                                />-->
<!--                                <div style="width: 94%; bottom: 0; position: relative; margin-top: 100%; margin-left: 10px; font-size: 16px; font-weight: bold;">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div style="width: 94%; bottom: 0; position: relative;  margin-left: 10px; font-size: 16px; font-weight: bold;" @click="deleteFile(index)" class="cursor-pointer">USUŃ-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="mt-3">
                <label class="form-label"> {{ $t('challengesNew.file') }}</label>
                <div class="rounded-md pt-4">
                    <div class="flex flex-wrap px-4">
                        <Dropzone
                            style="position: relative; display: flex;"
                            ref-key="dropzoneSingleRef"
                            :options="{
                            url: '/api/report/files/store',
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
    <div class="modal-footer text-right">
        <button type="button" :disabled="isDisabled" class="btn btn-primary w-15" @click="saveConcept">Wyślij zgłoszenie</button>
    </div>

</template>

<script>
import {getCurrentInstance, onMounted, provide, ref} from "vue";
import Dropzone from '../../../../global-components/dropzone/Main'
import {useToast} from "vue-toastification";
import RequestHandler from "../../../../compositions/RequestHandler";

export default {
    name: "AddConcept",
    components: {
      Dropzone
    },
    props: {
      project: Object
    },
    setup(props) {
        const isDisabled = ref(false);
        const concept = ref({
            title : '',
            description: '',
            accepted: 0
        })
        const type = ref('Wyzwanie');
        const dropzoneSingleRef = ref();
        const toast = useToast();
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const files = ref([]);
        const user = window.Laravel.user;

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        onMounted( () => {
            const elDropzoneSingleRef = dropzoneSingleRef.value;
            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                files.value.push(JSON.parse(resp.xhr.response).payload);
                toast.success('Pomyślnie dodano plik!');
            });
            elDropzoneSingleRef.dropzone.on("error", () => {
                toast.error("Błąd");
            });
        });


        const handleCallback = (resp) => {
            emitter.emit('addreport', {obj: resp});
        };

        const deleteFile = (index) => {
            files.value.splice(index, 1);
        }

        const saveConcept = async () => {
            RequestHandler('projects/' + props.project.id + '/concept/save', 'post', {
                project_id: props.project.id,
                title: concept.value.title,
                description: concept.value.description,
                files : files.value
            }, (response) => {
                emitter.emit('addConcept', {obj: concept});
            });
        }

        // const saveReportRepo = async () => {
        //     if(concept.title.value === '' || (concept.description.value === ''))
        //     {
        //        toast.warning('Uzupełnij wszystkie pola!');
        //        isDisabled.value = true;
        //     } else {
        //             let resp = await SaveReport({
        //                 title: concept.title.value,
        //                 description: concept.description.value,
        //                 files : files.value
        //             }, handleCallback);
        //             isDisabled.value = true;
        //             emitter.emit('changetab', {val: 'reports'});
        //         }
        // }

        return {
            user,
            saveConcept,
            deleteFile,
            isDisabled,
            concept,
            type,
            dropzoneSingleRef,
            files
        }
    }
}
</script>

<style scoped>

</style>
