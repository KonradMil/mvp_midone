<template>
    <div>
        <div v-bind="getRootProps()">
            <input v-bind="getInputProps()" >
            <p v-if="isDragActive">Drop the files here ...</p>
            <div class="px-4 py-4 flex items-center cursor-pointer relative">
                <ImageIcon class="w-4 h-4 mr-2"/>
                <span class="text-theme-1 dark:text-theme-10 mr-1">
                                                            {{ $t('challengesNew.file') }}
                                                        </span>
                {{ $t('challengesNew.fileUpload') }}
            </div>
        </div>
<!--        <button @click="open">Otwórz</button>-->
    </div>
</template>

<script>
import { useDropzone } from 'vue3-dropzone'
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
        function onDrop(acceptFiles, rejectReasons) {
            console.log(acceptFiles)
            console.log(rejectReasons)
        }

        const { getRootProps, getInputProps, ...rest } = useDropzone({ onDrop })


        const saveFiles = (files) => {
            const formData = new FormData();
            for (let x = 0; x < files.length; x++) {
                formData.append("images[]", files[x]);
            }

            axios.post(props.url, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                   emit('uploaded', response);
                })
                .catch((err) => {
                    console.error(err);
                });
        };

        return {
            getRootProps,
            getInputProps,
            ...rest,
            saveFiles
        }
    }
}
</script>
