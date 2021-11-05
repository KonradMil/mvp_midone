<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{ $t('challengesNew.new') }}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                        aria-expanded="false"
                        @click.prevent="$router.back()">
                    Powrót
                </button>
                <button
                    class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                    aria-expanded="false"
                    @click.prevent="saveShowroom">
                    <SaveIcon class="w-4 h-4 mr-2"/>
                    {{ $t('global.save') }}
                </button>
            </div>
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-8">
                <div class="input-group mt-2">
                    <input type="text"
                           class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13"
                           :placeholder="$t('global.name') + '*'"
                           v-model="showroom.name"/>
                </div>
                <div class="post intro-y box mt-5">
                    <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600" role="tablist">
                        <a id="default-tab"
                            content="Adjust the meta title"
                            data-toggle="tab"
                            data-target="#default-tab"
                            href="javascript:;"
                            class="w-full sm:w-40 py-4 text-center flex justify-center items-center"
                            role="tab"
                            aria-selected="false"
                            @click="tab = 'default'">
                            <CodeIcon class="w-4 h-4 mr-2"/>
                            Podstawowe informacje
                        </a>
                    </div>
                    <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600" role="tablist">
                        <a id="slides-tab"
                           content="Adjust the meta title"
                           data-toggle="tab"
                           data-target="#slides-tab"
                           href="javascript:;"
                           class="w-full sm:w-40 py-4 text-center flex justify-center items-center"
                           role="tab"
                           aria-selected="false"
                           @click="tab = 'default'">
                            <CodeIcon class="w-4 h-4 mr-2"/>
                            Slajdy
                        </a>
                    </div>
                    <div class="post__content tab-content">
                        <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                    <div class="w-22 mr-3">

                                    </div>
                                    {{ $t('challengesNew.description') }}
                                </div>
                                <div class="mt-5">
                                    <textarea v-model="showroom.description" class="w-full h-36 form-control" style="width: 100%;"></textarea>
                               </div>
                                <div class="mt-5">
                                    <textarea v-model="showroom.custom_css" class="w-full h-36 form-control" style="width: 100%;"></textarea>
                                </div>
                                <div class="mt-5">
                                    <textarea v-model="showroom.custom_functions" class="w-full h-36 form-control" style="width: 100%;"></textarea>
                                </div>
                            </div>
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                    <ChevronDownIcon class="w-4 h-4 mr-2"/>
                                    {{ $t('challengesNew.photo') }}
                                </div>
                                <div class="mt-5">
                                    <div class="mt-3" v-if="files.length > 0">
                                        <label class="form-label"> {{ $t('challengesNew.uploadedPhotos') }}</label>
                                        <div class="rounded-md pt-4">
                                            <div class="row flex h-full">
                                                <div class=" h-full" v-for="(file, index) in files" :key="'image_' + index">
                                                    <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;">
                                                        <img class="w-full h-full"
                                                             :alt="file.original_name"
                                                             :src="'/' + file.path"
                                                        />
                                                        <div style="width: 94%; bottom: 0; position: relative; margin-top: 100%; margin-left: 10px; font-size: 16px; font-weight: bold;">
                                                        </div>
                                                    </div>
                                                    <div style="width: 94%; bottom: 0; position: relative;  margin-left: 10px; font-size: 16px; font-weight: bold;" @click="deleteFile(index)" class="cursor-pointer">USUŃ
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="rounded-md pt-4">
                                            <div class="flex flex-wrap px-4">
                                                <Dropzone></Dropzone>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Post Content -->
            <!-- BEGIN: Post Info -->
            <div class="col-span-12 lg:col-span-4">
                <div class="intro-y box p-5">
                    <div class="my-3">
                        <Label title="Organizacja"></Label>
                        <Input type="text" placeholder="Nazwa organizacji" v-model:val="showroom.organization"></Input>
                    </div>
                    <div class="my-3">

                    </div>
                    <div class="my-3">
                        <Label title="Kolor dominujący"></Label>
                        <Swatches @colorSelected="selectedColor" class="mt-2"></Swatches>
                    </div>
                </div>
            </div>
            <!-- END: Post Info -->
        </div>
    </div>
</template>

<script>
import {ref, onMounted, reactive} from "vue";
import cash from "cash-dom";
import {useToast} from "vue-toastification";
import {useI18n} from 'vue-i18n'
import Multiselect from '@vueform/multiselect'
import Dropzone from "../../../components-terraform/Dropzone";
import Swatches from "../../../components-terraform/Swatches";
import Label from "../../../components-terraform/Label";
import Input from "../../../components-terraform/Input";

export default {
    name: "AddEditShowroom",
    components: {Input, Swatches, Dropzone, Multiselect, Label},
    props: {
        showroom_id: Number,
    },
    setup(props) {
        const {t, locale} = useI18n({useScope: 'global'})
        const toast = useToast();
        const id = ref();
        const user = window.Laravel.user;
        const showModal = ref(false);
        const files = ref([]);
        const tab = ref('');


        const showroom = reactive({
            name: '',
            description: '',
            dominantColor: '',
            organization: '',
            custom_functions: '',
            custom_css: ''
        })

        const modalClosed = () => {
            showModal.value = false;
        }

        const saveShowroom = () => {

        }

        const deleteFile = () => {

        }

        const selectedColor = (color) => {
            showroom.dominantColor = color;
        }

        onMounted(() => {
            cash("body").removeClass("error-page");

            if (props.showroom_id != undefined) {
                id.value = props.showroom_id;
            }
        });

        return {
            modalClosed,
            showModal,
            files,
            user,
            saveShowroom,
            deleteFile,
            selectedColor,
            showroom,
            tab
        };
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
