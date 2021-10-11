<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{ $t('models.newModel') }}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button
                    type="button"
                    class="btn box text-gray-700 dark:text-gray-300 mr-2 flex items-center ml-auto sm:ml-0"
                >
                    <EyeIcon class="w-4 h-4 mr-2"/>
                    {{ $t('models.preview') }}
                </button>
                <button
                    class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                    aria-expanded="false"
                    @click="editModelRepo"
                >
                    <SaveIcon class="w-4 h-4 mr-2"/>
                    {{ $t('global.save') }}
                </button>
            </div>
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5" v-if="model.name != undefined">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-8">
                <div class="input-group mt-2">
                    <input
                        type="text"
                        class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13"
                        :placeholder="$t('global.name')"
                        v-model="model.name"
                    />
                </div>

                <div class="post intro-y overflow-hidden box mt-5">
                    <div
                        class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600"
                        role="tablist"
                    >
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
                            @click="tab = 'desc'"
                        >
                            <FileTextIcon class="w-4 h-4 mr-2"/>
                            {{ $t('models.description') }}
                        </Tippy>
                    </div>
                    <div class="post__content tab-content">
                        <div
                            v-if="tab === 'desc'"
                            id="content"
                            class="tab-pane p-5 active"
                            role="tabpanel"
                            aria-labelledby="content-tab"
                        >
                            <div
                                class="border border-gray-200 dark:border-dark-5 rounded-md p-5"
                            >
                                <div
                                    class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"
                                >
                                    {{ $t('models.details') }}
                                </div>
                                <div class="mt-5">
                                    <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-1" class="form-label">Model file</label>
                                            <input
                                                id="input-wizard-1"
                                                type="text"
                                                class="form-control"
                                                v-model="model.model_file"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">{{ $t('models.brand') }}</label>
                                            <input
                                                id="input-wizard-2"
                                                type="text"
                                                class="form-control"
                                                v-model="model.brand"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">{{ $t('models.maxCapacity') }}</label>
                                            <input
                                                id="input-wizard-3"
                                                type="text"
                                                class="form-control"
                                                v-model="model.max_load_kg"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">{{ $t('models.maxRange') }}</label>
                                            <input
                                                id="input-wizard-4"
                                                type="text"
                                                class="form-control"
                                                v-model="model.max_range_mm"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">{{ $t('models.numAxles') }}</label>
                                            <input
                                                id="input-wizard-5"
                                                type="text"
                                                class="form-control"
                                                v-model="model.axis"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">{{ $t('models.maxSpeed') }}</label>
                                            <input
                                                id="input-wizard-6"
                                                type="text"
                                                class="form-control"
                                                v-model="model.max_speed_mms"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">Tech sheet url</label>
                                            <input
                                                id="input-wizard-7"
                                                type="text"
                                                class="form-control"
                                                v-model="model.tech_sheet"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">{{ $t('models.connectMethod') }}</label>
                                            <input
                                                id="input-wizard-8"
                                                type="text"
                                                class="form-control"
                                                v-model="model.connection_method"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">{{ $t('models.range') }}</label>
                                            <input
                                                id="input-wizard-9"
                                                type="text"
                                                class="form-control"
                                                v-model="model.range"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">{{ $t('models.reproducibility') }}</label>
                                            <input
                                                id="input-wizard-10"
                                                type="text"
                                                class="form-control"
                                                v-model="model.repetity"
                                            />
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">{{ $t('models.liftCapacity') }}</label>
                                            <input
                                                id="input-wizard-11"
                                                type="text"
                                                class="form-control"
                                                v-model="model.load"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                            <div-->
                            <!--                                class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5"-->
                            <!--                            >-->
                            <!--                                <div-->
                            <!--                                    class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"-->
                            <!--                                >-->
                            <!--                                    <ChevronDownIcon class="w-4 h-4 mr-2"/>-->
                            <!--                                    Zdjęcia-->
                            <!--                                </div>-->
                            <!--                                <div class="mt-5">-->
                            <!--                                    <div class="mt-3">-->
                            <!--                                        <label class="form-label">Wgraj zjęcia</label>-->
                            <!--                                        <div-->
                            <!--                                            class="rounded-md pt-4"-->
                            <!--                                        >-->
                            <!--                                            <div class="flex flex-wrap px-4">-->
                            <!--                                                <Dropzone-->
                            <!--                                                    style="position: relative;-->
                            <!--    display: flex;"-->
                            <!--                                                    ref-key="dropzoneSingleRef"-->
                            <!--                                                    :options="{-->
                            <!--                              url: '/api/challenge/images/store',-->
                            <!--                              thumbnailWidth: 150,-->
                            <!--                              maxFilesize: 5,-->
                            <!--                              maxFiles: 5,-->
                            <!--                              previewTemplate: '<div style=\'display: none\'></div>'-->
                            <!--                            }"-->
                            <!--                                                    class="dropzone">-->
                            <!--                                                    <div-->
                            <!--                                                        class="px-4 py-4 flex items-center cursor-pointer relative"-->
                            <!--                                                    >-->
                            <!--                                                        <ImageIcon class="w-4 h-4 mr-2"/>-->
                            <!--                                                        <span class="text-theme-1 dark:text-theme-10 mr-1"-->
                            <!--                                                        >Wgraj plik</span-->
                            <!--                                                        >-->
                            <!--                                                        lub przyciągnij i upuść-->
                            <!--                                                    </div>-->
                            <!--                                                </Dropzone>-->
                            <!--                                            </div>-->

                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Post Content -->
            <!-- BEGIN: Post Info -->
            <div class="col-span-12 lg:col-span-4">
                <div class="intro-y box p-5">
                    <div class="mt-3">
                        <label for="post-form-3" class="form-label">{{ $t('models.cat') }}</label>
                        <TailSelect
                            id="post-form-3"
                            v-model="category"
                            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz kategorie...',
                                limit: 'Nie można wybrać więcej',
                                search: false,
                                hideSelected: false,
                                classNames: 'w-full'
                                }">
                            <option disabled>{{ $t('challengesNew.selectCategories') }}</option>
                            <option v-for="(category2,index) in categories.categories" :selected="(category2 == category)? 'selected': ''" :value="category2.value">{{ category2.name }}</option>
                        </TailSelect>
                    </div>
                </div>
                <div class="intro-y box p-5" v-if="category != ''">
                    <div class="mt-3">
                        <label for="post-form-3" class="form-label">{{ $t('models.subcat') }}</label>
                        <TailSelect
                            id="post-form-3"
                            v-model="subcategory"
                            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz kategorie...',
                                limit: 'Nie można wybrać więcej',
                                search: false,
                                hideSelected: false,
                                classNames: 'w-full'
                                }">
                            <option disabled>{{ $t('challengesNew.selectCategories') }}</option>
                            <option v-for="(cat,index) in categories.categories[category].subcategories"  :selected="(cat == subcategory)? 'selected': ''" :value="cat.value">{{ cat.name }}</option>
                        </TailSelect>
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
import SaveModel from "../../compositions/SaveModel";
import {useI18n} from 'vue-i18n'
import Multiselect from '@vueform/multiselect';
import GetModel from "../../compositions/GetModel";
import EditModel from "../../compositions/EditModel";

const toast = useToast();

export default {
    name: "ModelEdit",
    components: {Multiselect},
    props: {
        id: Number
    },
    setup(props, {emit}) {
        const {t, locale} = useI18n({useScope: 'global'})
        const toast = useToast();
        const tab = ref('desc');
        const showModal = ref(false);
        const images = ref([]);
        const name = ref('');
        const category = ref('');
        const subcategory = ref('');
        const model_file = ref('');
        const brand = ref('');
        const model = ref('');
        const max_load_kg = ref('');
        const max_range_mm = ref('');
        const max_speed_mms = ref('');
        const axis = ref('');
        const tech_sheet = ref('');
        const connection_method = ref('');
        const range = ref('');
        const repetity = ref('');
        const load = ref('');
        // const dropzoneSingleRef = ref();
        const categories = ref([]);
        const types = require("../../json/model_categories.json");
        const model_id = ref(null);
        // const models = ref([]);

        // provide("bind[dropzoneSingleRef]", el => {
        //     dropzoneSingleRef.value = el;
        // });
        const modalClosed = () => {
            showModal.value = false;
        }
        const getModelRepositiories = async () => {
            GetModel(model_id.value, (res) => {

                model.value = res.payload;
                category.value = res.payload.category;
                subcategory.value = res.payload.subcategory;
            })
        }
        // const saveModelRepo = async () => {
        //     SaveModel({
        //         name: name.value,
        //         category: category.value,
        //         subcategory: subcategory.value,
        //         model_file: model_file.value,
        //         brand: brand.value,
        //         model: model.value,
        //         max_load_kg: max_load_kg.value,
        //         max_range_mm: max_range_mm.value,
        //         max_speed_mms: max_speed_mms.value,
        //         axis: axis.value,
        //         tech_sheet: tech_sheet.value,
        //         connection_method: connection_method.value,
        //         range: range.value,
        //         repetity: repetity.value,
        //         load: load.value
        //     });
        // }
        const editModelRepo = async () => {
            model.value.subcategory = subcategory.value;
            model.value.category = category.value;
            EditModel(model.value, model.value.id );
        }

        onMounted(() => {
            model_id.value = props.id;
            getModelRepositiories();
            categories.value = types;
            // const elDropzoneSingleRef = dropzoneSingleRef.value;
            // elDropzoneSingleRef.dropzone.on("success", (resp) => {
            //     images.value.push(JSON.parse(resp.xhr.response).payload);
            //
            // });
            // elDropzoneSingleRef.dropzone.on("error", () => {
            //     toast.error("Błąd");
            // });
            cash("body")
                .removeClass("error-page");
        });
        return {
            categories,
            category,
            name,
            tab,
            modalClosed,
            showModal,
            images,
            editModelRepo,
            subcategory,
            load,
            repetity,
            range,
            connection_method,
            tech_sheet,
            max_speed_mms,
            axis,
            max_range_mm,
            max_load_kg,
            model,
            brand,
            model_file
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
