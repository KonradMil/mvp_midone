<template>
    <div class="flex-initial pl-2">
        <div class="mt-3" v-if="props.type !== 'solution'">
            <label for="modal-form-3" class="form-label">Solution deadline</label>
            <input
                id="modal-form-3"
                type="text"
                class="form-control"
                placeholder=""
                v-model="c.solution_deadline"
            />
        </div>
        <div class="mt-3" v-if="props.type !== 'solution'">
            <label for="modal-form-4" class="form-label">Offer deadline</label>
            <input
                id="modal-form-4"
                type="text"
                class="form-control"
                placeholder=""
                v-model="c.offer_deadline"
            />
        </div>
        <div class="mt-3">
            <label for="modal-form-1" class="form-label">Tytuł</label>
            <input
                id="modal-form-1"
                type="text"
                class="form-control"
                placeholder=""
                maxlength = "60"
                v-model="c.name"
                :disabled="((props.type === 'solution') && (user.type === 'investor'))"
            />
        </div>
        <div class="mt-3">
            <label for="modal-form-2" class="form-label">Opis</label>
            <textarea
                style="height: 200px;"
                id="modal-form-2"
                class="form-control"
                v-model="c.description"
                :disabled="((props.type === 'solution') && (user.type === 'investor'))"
            />
        </div>
        <div class="mt-3" v-if="props.type === 'solution'">
            <label for="modal-form-2" class="form-label">Pliki</label>
<!--            <Dropzone-->
<!--                style="position: relative;-->
<!--                                                    display: flex;"-->
<!--                ref-key="dropzoneSingleRef"-->
<!--                :options="{-->
<!--                              url: '/api/solution/images/store',-->
<!--                              thumbnailWidth: 150,-->
<!--                              maxFilesize: 5,-->
<!--                              maxFiles: 5,-->
<!--                              previewTemplate: '<div style=\'display: none\'></div>'-->
<!--                            }"-->
<!--                class="dropzone">-->
<!--                <div class="px-4 py-4 flex items-center cursor-pointer relative">-->
<!--                    <ImageIcon class="w-4 h-4 mr-2"/>-->
<!--                    <span class="text-theme-1 dark:text-theme-10 mr-1">-->
<!--                                                            {{ $t('challengesNew.file') }}-->
<!--                                                        </span>-->
<!--                    {{ $t('challengesNew.fileUpload') }}-->
<!--                </div>-->
<!--            </Dropzone>-->
        </div>
        <div class="mt-3" v-if="images.length > 0 && props.type === 'solution'">
            <label class="form-label"> {{ $t('challengesNew.uploadedPhotos') }}</label>
            <div class="rounded-md pt-4">
                <div class="flex flex-col h-full">
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
    </div>
</template>

<script>
import {onMounted, provide, ref, watch} from "vue";
import Multiselect from '@vueform/multiselect'
import cash from "cash-dom";
import Dropzone from '../../../../global-components/dropzone/Main'
import {useStore} from "../../../../store";
import {useToast} from "vue-toastification";


const store = useStore();

export default {
    name: "DescriptionDialog",
    props: {
        object: Object,
        type: String
    },
    components: {

    },
    setup(props, context) {
        const c = ref({description: '', name: '', solution_deadline: '', offer_deadline: ''});
        const user = window.Laravel.user;
        const toast = useToast();
        const types = require("../../../../json/types.json");
        const images = ref([]);
        // const dropzoneSingleRef = ref();

        watch(c, (ca, prevLabel) => {
            context.emit("update:object", ca);
        }, {deep: true})

        const deleteImage = (index) => {
            images.value.splice(index, 1);
        }

        // provide("bind[dropzoneSingleRef]", el => {
        //     dropzoneSingleRef.value = el;
        // });

        onMounted(() => {
            c.value = props.object
            // const elDropzoneSingleRef = dropzoneSingleRef.value;
            //     elDropzoneSingleRef.dropzone.on("success", (resp) => {
            //         images.value.push(JSON.parse(resp.xhr.response).payload);
            //         toast.success('Zdjecie zostało wgrane poprawnie!');
            //     });
            //     elDropzoneSingleRef.dropzone.on("error", () => {
            //         toast.error("Błąd");
            //     });


            // if (props.object.name != undefined && props.object.name != '') {
            //     c.value.name = props.object.name;
            // } else {
            //     c.value.name = '';
            // }
            // if (props.object.description != undefined && props.object.description != '') {
            //     c.value.description = props.object.description;
            // } else {
            //     c.value.description = '';
            // }
            // if (props.object.solution_deadline != undefined && props.object.solution_deadline != '') {
            //     c.value.solution_deadline = props.object.solution_deadline;
            // } else {
            //     c.value.solution_deadline = '';
            // }
            // if (props.object.offer_deadline != undefined && props.object.offer_deadline != '') {
            //     c.value.offer_deadline = props.object.offer_deadline;
            // } else {
            //     c.value.offer_deadline = '';
            // }
        });

        return {
            deleteImage,
            // dropzoneSingleRef,
            images,
            user,
            c,
            types,
            props
        }
    }
}
</script>

<style scoped>

</style>
