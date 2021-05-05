<template>
    <div>
        <label for="crud-form-1" class="form-label">Title</label>
        <input id="crud-form-1"
               type="text"
               class="form-control w-full"
               placeholder="Input text"
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
                                     }"
        >
            <option value="Wyzwanie">Wyzwanie</option>
            <option value="Rozwiazanie">Rozwiązanie</option>
            <option value="Oferta">Oferta</option>
            <option value="Projekt">Projekt</option>
            <option value="Stanowisko">Stanowisko</option>
            <option value="Inne">Inne</option>
        </TailSelect>
    </div>
    <div class="pt-5">
        <div
            class="border border-gray-200 dark:border-dark-5 rounded-md p-5"
        >
            <div
                class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"
            >
                {{ $t('challengesNew.description') }}
            </div>
            <div class="mt-5">
                <textarea v-model="description" style="width: 100%;"></textarea>
            </div>
        </div>
    </div>
    <div
        class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5"
    >
        <div class="mt-5">
            <div class="mt-3">
                <label class="form-label"> {{ $t('challengesNew.file') }}</label>
                <div
                    class="rounded-md pt-4"
                >
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
                            <div
                                class="px-4 py-4 flex items-center cursor-pointer relative"
                            >
                                <ImageIcon class="w-4 h-4 mr-2"/>
                                <span class="text-theme-1 dark:text-theme-10 mr-1"
                                >{{ $t('challengesNew.file') }}</span
                                >
                                {{ $t('challengesNew.fileUpload') }}
                            </div>
                        </Dropzone>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer text-right">
        <button type="button" class="btn btn-primary w-20" @click="saveReportRepo">Send</button>
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
        const title = ref('');
        const type = ref('');
        const description = ref('');
        const dropzoneSingleRef = ref();
        const file = ref({});
        const toast = useToast();
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        onMounted( () => {
            const elDropzoneSingleRef = dropzoneSingleRef.value;
            console.log(elDropzoneSingleRef);
            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                console.log(resp.xhr.response);
                file.value = JSON.parse(resp.xhr.response).payload;
                toast.success('Success!');
            });
            elDropzoneSingleRef.dropzone.on("error", () => {
                toast.error("Błąd");
            });
        });


        const handleCallback = (resp) => {
            console.log(resp);
            emitter.emit('addreport', {obj: resp});
        };

        const saveReportRepo = async () => {
           let resp = await SaveReport({
                title: title.value,
                description: description.value,
                type: type.value,
                file_id : file.value.id
            }, handleCallback);
            console.log(resp);
            // emitter.emit('addreport', {obj: resp});

        }

        return {
            title,
            type,
            description,
            dropzoneSingleRef,
            saveReportRepo,
            file
        }
    }
}
</script>

<style scoped>

</style>
