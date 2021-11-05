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
                           v-model="name"/>
                </div>
                <div class="post intro-y box mt-5">
                    <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600" role="tablist">
                        <Tippy
                            id="content-tab"
                            tag="a"
                            content="Fill in the article content"
                            data-toggle="tab"
                            data-target="#content"
                            href="javascript:;"
                            class="w-full sm:w-40 py-4 text-center flex justify-center items-center active"
                            role="tab"
                            aria-controls="content"
                            aria-selected="true"
                            @click="tab = 'desc'">
                            <FileTextIcon class="w-4 h-4 mr-2"/>
                            {{ $t('challengesNew.description') }}
                        </Tippy>
                        <Tippy
                            id="meta-title-tab"
                            tag="a"
                            content="Adjust the meta title"
                            data-toggle="tab"
                            data-target="#meta-title"
                            href="javascript:;"
                            class="w-full sm:w-40 py-4 text-center flex justify-center items-center"
                            role="tab"
                            aria-selected="false"
                            @click="tab = 'details'">
                            <CodeIcon class="w-4 h-4 mr-2"/>
                            {{ $t('challengesNew.details') }}
                        </Tippy>
                        <Tippy
                            id="meta-title-tab"
                            tag="a"
                            content="Adjust the meta title"
                            data-toggle="tab"
                            data-target="#meta-title"
                            href="javascript:;"
                            class="w-full sm:w-40 py-4 text-center flex justify-center items-center"
                            role="tab"
                            aria-selected="false"
                            @click="tab = 'financials'">
                            <CodeIcon class="w-4 h-4 mr-2"/>
                            {{ $t('global.financials') }}
                        </Tippy>
                    </div>
                    <div class="post__content tab-content">
                        <div v-if="tab === 'desc'" id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                    <div class="w-22 mr-3">
                                        <TailSelect
                                            id="input-wizard-2"
                                            v-model="description_lang"
                                            :options="{
                                                locale: 'pl',
                                                placeholder: 'Wybierz...',
                                                limit: 'Nie można wybrać więcej',
                                                search: false,
                                                hideSelected: false,
                                                classNames: 'w-full'
                                            }">
                                            <option value="pl">PL</option>
                                            <option value="en">ENG</option>

                                        </TailSelect>
                                    </div>
                                    {{ $t('challengesNew.description') }}
                                </div>
                                <div class="mt-5">
                                    <textarea v-if="description_lang == 'pl'" v-model="description" class="w-full h-36 form-control" style="width: 100%;"></textarea>
                                    <textarea v-if="description_lang == 'en'" v-model="en_description" class="w-full h-36 form-control" style="width: 100%;"></textarea>
                                </div>
                            </div>
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                                    <ChevronDownIcon class="w-4 h-4 mr-2"/>
                                    {{ $t('challengesNew.photo') }}
                                </div>
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
                                        <label class="form-label"> {{ $t('challengesNew.uploadPhoto') }}</label>
                                        <div class="rounded-md pt-4">
                                            <div class="flex flex-wrap px-4">
                                                <Dropzone
                                                    style="position: relative;
                                                    display: flex;"
                                                    ref-key="dropzoneSingleRef"
                                                    :options="{
                              url: '/api/challenge/images/store',
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
                        </div>
                        <div v-if="tab === 'details'" id="content2" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">
                            <Details v-model:details="details" :types="categories" :selects="challengeSelects"></Details>
                        </div>
                        <div v-if="tab==='financials'" class="intro-y box mt-5">
                            <Financials v-model:financials="financials"></Financials>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Post Content -->
            <!-- BEGIN: Post Info -->
            <div class="col-span-12 lg:col-span-4">
                <div class="intro-y box p-5">
                    <div class="mt-3">
                        <label for="post-form-2" class="form-label">{{ $t('challengesNew.deadlineSolutions') }}</label>
                        <Litepicker
                            id="post-form-2"
                            v-model="solution_deadline"
                            :options="
                {
                autoApply: false,
                lang: 'pl',
                format: 'DD.MM.YYYY',
                showWeekNumbers: true,
                minDate: now,
                 buttonText: {'apply':'OK','cancel':'Anuluj'},
                dropdowns: {

                  minYear: 2021,
                  maxYear: 2023,
                  months: true,
                  years: true
                }
              }" class="form-control"/>
                    </div>
                    <div class="mt-3">
                        <label for="post-form-21" class="form-label">{{ $t('challengesNew.deadlineOffer') }}</label>
                        <Litepicker
                            id="post-form-2"
                            v-model="offer_deadline"
                            :options="{
                autoApply: false,
                minDate: now,
                showWeekNumbers: true,
                lang: 'pl',
                format: 'DD.MM.YYYY',
                showWeekNumbers: true,
                 buttonText: {'apply':'OK','cancel':'Anuluj'},
                dropdowns: {
                  minYear: 2021,
                  maxYear: 2023,
                  months: true,
                  years: true
                }
              }" class="form-control"/>
                    </div>
                    <div class="mt-3">
                        <label for="post-form-3" class="form-label">Proces</label>
                        <TailSelect
                            id="post-form-3"
                            v-model="category"
                            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz proces...',
                                limit: 'Nie można wybrać więcej',
                                search: false,
                                hideSelected: false,
                                classNames: 'w-full'
                                }">
                            <option selected disabled>{{ $t('challengesNew.selectCategories') }}</option>
                            <option v-for="(category,index) in categories" :value="index">{{ category }}</option>
                        </TailSelect>
                    </div>
                    <div class="mt-3">
                        <label for="post-form-3" class="form-label">Kategoria</label>
                        <Multiselect
                            v-model="categorytab"
                            :options="[{
                                label: 'Normalna',
                                value: 0
                            },
                            {
                                label: 'Testowa',
                                value: 1
                            }]"
                        />
                    </div>
                    <div class="form-check flex-col items-start mt-3">
                        <label for="post-form-6" class="form-check-label ml-0 mb-2">
                            {{ $t('challengesNew.acceptPublic') }}
                        </label>
                        <input id="post-form-6" v-model="allowed_publishing" class="form-check-switch" type="checkbox"/>
                    </div>
                </div>
            </div>
            <!-- END: Post Info -->
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, onMounted, provide} from "vue";
import cash from "cash-dom";
import {useToast} from "vue-toastification";
import GetTeams from "../../compositions/GetTeams";
import SaveChallenge from "../../compositions/SaveChallenge";
import GetCardChallenge from "../../compositions/GetCardChallenge";
import {useI18n} from 'vue-i18n'
import Multiselect from '@vueform/multiselect'
import router from '../../router';
import Details from "./components/Details";
import Financials from "./components/Financials";
import dayjs from "dayjs";
import RequestHandler from "../../compositions/RequestHandler";


export default {
    name: "AddEditShowroom",
    components: {Multiselect},
    props: {
        showroom_id: Number,
    },
    setup(props) {
        const {t, locale} = useI18n({useScope: 'global'})
        const toast = useToast();
        const name = ref('');
        const description = ref('');
        const id = ref();
        const user = window.Laravel.user;
        const showModal = ref(false);
        const files = ref([]);

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        const modalClosed = () => {
            showModal.value = false;
        }

        const saveShowroom = () => {

        }


        onMounted(() => {

            const elDropzoneSingleRef = dropzoneSingleRef.value;

            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                files.value.push(JSON.parse(resp.xhr.response).payload);
                toast.success('Zdjecie zostało wgrane poprawnie!');
            });
            elDropzoneSingleRef.dropzone.on("error", () => {
                toast.error("Błąd");
            });
            cash("body")
                .removeClass("error-page");

            if (props.showroom_id != undefined) {
                id.value = props.showroom_id;

            }
        });

        return {
            description,
            name,
            modalClosed,
            showModal,
            files,
            user,
            saveShowroom
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
