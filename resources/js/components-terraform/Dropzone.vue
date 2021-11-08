<template>
    <div style="border: 3px dashed #5e50ac;">
        <div v-bind="getRootProps()">
            <input v-bind="getInputProps()">
            <p v-if="isDragActive" style="">Upuść pliki tutaj</p>
            <div class="px-10 py-10 flex items-center cursor-pointer relative">
                <ImageIcon class="w-4 h-4 mr-2"/>
                <span class="text-theme-1 dark:text-theme-10 mr-1">
                    {{ $t('challengesNew.file') }}
                </span>
                {{ $t('challengesNew.fileUpload') }}
            </div>
        </div>
    </div>
</template>

<script>
import {useDropzone} from 'vue3-dropzone'
import {ref} from "vue"

export default {
    name: 'Dropzone',
    props: {
        url: {
            type: String,
            default: '/api/save/file'
        }
    },
    emits: ['uploaded'],
    setup(props, {emit}) {
        const filesUploaded = ref([]);

        function onDrop(acceptFiles, rejectReasons) {
            saveFiles(acceptFiles);
        }

        const {getRootProps, getInputProps, ...rest} = useDropzone({onDrop})

        const saveFiles = (files) => {
            const formData = new FormData();
            for (let x = 0; x < files.length; x++) {
                formData.append("images[]", files[x]);
            }

            axios.post(props.url, formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }).then((response) => {
                filesUploaded.value = response.data;
                emit('uploaded', response.data);
            }).catch((err) => {
                console.error(err);
            });
        };

        return {
            getRootProps,
            getInputProps,
            ...rest,
            saveFiles,
            filesUploaded
        }
    }
}
</script>
