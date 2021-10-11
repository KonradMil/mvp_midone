<template>
    <div class="pb-4">
    <span class="font-medium dark:text-theme-10 text-theme-1">Jeśli masz problem z obsługą platformy lub pojawił się błąd w którymś z widoków prześlij do nas zgłoszenie. Dodaj do niego zrzut ekranu z widocznym  błędem, aby ułatwić nam jego identyfikację i rozwiązanie. Postaramy się odpowiedzieć jak najszybciej.</span>
    </div>
    <div>
        <label for="crud-form-1" class="form-label">Tytuł wiadomości</label>
        <input maxlength="100"
               id="crud-form-1"
               type="text"
               class="form-control w-full"
               placeholder=""
               v-model="title"
        >
    </div>
    <div class="mt-3">
        <label for="crud-form-2" class="form-label">Czego dotyczy</label>
        <TailSelect
            id="post-form-3"
            v-model="type"
            :options="{
             locale: 'pl',
             limit: 'Nie można wybrać więcej',
             search: false,
             hideSelected: false,
             classNames: 'w-16'
            }">
            <option value="Wyzwanie">Wyzwanie</option>
            <option value="Rozwiazanie">Rozwiązanie</option>
            <option value="Oferta">Oferta</option>
            <option value="Projekt">Projekt</option>
            <option value="Stanowisko">Stanowisko</option>
            <option value="Inne">Inne</option>
        </TailSelect>
    </div>
    <div class="pt-5">
        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
            <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                {{ $t('challengesNew.description') }}
            </div>
            <div class="mt-5">
                <textarea v-model="description" class="w-full h-36 form-control" style="width: 100%;"></textarea>
            </div>
        </div>
    </div>
    <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
        <div class="mt-5">
            <div class="mt-3" v-if="images.length > 0">
                <label class="form-label"> {{ $t('challengesNew.uploadedPhotos') }}</label>
                <div class="rounded-md pt-4">
                    <div class="row flex h-full">
                        <div class=" h-full" v-for="(image, index) in images" :key="'image_' + index">
                            <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;">
                                <img class="w-full h-full"
                                     :alt="image.original_name"
                                     :src="'/' + image.path"
                                />
                                <div style="width: 94%; bottom: 0; position: relative; margin-top: 100%; margin-left: 10px; font-size: 16px; font-weight: bold;">
                                </div>
                            </div>
                            <div style="width: 94%; bottom: 0; position: relative;  margin-left: 10px; font-size: 16px; font-weight: bold;" @click="deleteImage(index)" class="cursor-pointer">USUŃ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        <button type="button" :disabled="isDisabled" class="btn btn-primary w-15" @click="saveReportRepo">Wyślij zgłoszenie</button>
    </div>

</template>

<script>
import {getCurrentInstance, onMounted, provide, ref} from "vue";
import SaveReport from "../../compositions/SaveReport";
import Dropzone from '../../global-components/dropzone/Main'
import {useToast} from "vue-toastification";

export default {
    name: "AddReport",
    components: {
      Dropzone
    },
    setup() {
        const isDisabled = ref(false);
        const title = ref('');
        const type = ref('Wyzwanie');
        const description = ref('');
        const dropzoneSingleRef = ref();
        const file = ref({});
        const toast = useToast();
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const images = ref([]);
        const files = ref([]);

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        onMounted( () => {
            const elDropzoneSingleRef = dropzoneSingleRef.value;
            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                files.value.push(JSON.parse(resp.xhr.response).payload);
                images.value.push(JSON.parse(resp.xhr.response).payload);
                file.value = JSON.parse(resp.xhr.response).payload;
                toast.success('Pomyślnie dodano plik!');
            });
            elDropzoneSingleRef.dropzone.on("error", () => {
                toast.error("Błąd");
            });
        });


        const handleCallback = (resp) => {
            emitter.emit('addreport', {obj: resp});
        };

        const deleteImage = (index) => {
            images.value.splice(index, 1);
        }

        const saveReportRepo = async () => {
            if(title.value === '' || description.value === '' || type.value==='')
            {
               toast.warning('Uzupełnij wszystkie pola!');
               isDisabled.value = true;
            } else {
                    let resp = await SaveReport({
                        title: title.value,
                        description: description.value,
                        type: type.value,
                        files : files.value
                    }, handleCallback);
                    isDisabled.value = true;
                    emitter.emit('changetab', {val: 'reports'});
                }
            setTimeout(()=>{
               isDisabled.value = false;
            }, 2000);
            title.value = '',
            description.value = '',
            type.value = 'Wyzwanie',
            files.value = null
        }

        return {
            deleteImage,
            images,
            isDisabled,
            title,
            type,
            description,
            dropzoneSingleRef,
            saveReportRepo,
            file,
            files
        }
    }
}
</script>

<style scoped>

</style>
