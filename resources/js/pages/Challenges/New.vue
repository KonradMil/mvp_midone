<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{ $t('challengesNew.new') }}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <!--                <button-->
                <!--                    type="button"-->
                <!--                    class="btn box text-gray-700 dark:text-gray-300 mr-2 flex items-center ml-auto sm:ml-0"-->
                <!--                >-->
                <!--                    <EyeIcon class="w-4 h-4 mr-2"/>-->
                <!--                 {{$t('challengesNew.preview')}}-->
                <!--                </button>-->
                <button v-if="challenge_id != undefined"
                    class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                    aria-expanded="false"
                    @click.prevent="$router.push({path: '/challenges/card/' + challenge_id})">
                    Powrót
                </button>
                <button v-if="challenge_id == undefined"
                        class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                        aria-expanded="false"
                        @click.prevent="$router.push({path: '/challenges'})">
                    Powrót
                </button>
                <button
                    class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                    aria-expanded="false"
                    @click.prevent="saveChallengeRepo"
                    :disabled="isDisabled">
                    <SaveIcon class="w-4 h-4 mr-2"/>
                    {{ $t('global.save') }}
                </button>
            </div>
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-8">
                <div class="input-group mt-2">
                    <div class="input-group-text">
                        <TailSelect
                            id="input-wizard-2"
                            v-model="name_lang"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option value="pl">PL</option>
                            <option value="en">ENG</option>

                        </TailSelect>
                    </div>
                    <input v-if="name_lang == 'pl'"
                           type="text"
                           class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13"
                           :placeholder="$t('global.name') + '*'"
                           v-model="name"/>
                    <input v-if="name_lang == 'en'"
                           type="text"
                           class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13"
                           :placeholder="$t('global.name') + '*'"
                           v-model="en_name"/>
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
                                    {{ $t('challengesNew.files') }}
                                </div>
                                <div class="mt-5">
                                    <div class="mt-3" v-if="images.length > 0">
                                        <label class="form-label"> {{ $t('challengesNew.uploadedFiles') }}</label>
                                        <div class="rounded-md pt-4">
                                            <div class="grid grid-cols-4 h-full">
                                                <div class=" h-full" v-for="(image, index) in images" :key="'image_' + index">
                                                    <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;">
                                                        <img v-lazy="'/' + image.path"
                                                             class="w-full h-full"
                                                             :alt="image.original_name"
                                                             :src="'/' + image.path"
                                                        />
                                                        <div style="width: 94%; bottom: 0; position: relative; margin-top: 100%; margin-left: 10px; font-size: 16px; font-weight: bold;">
                                                        </div>
                                                    </div>
                                                    <div style="width: 94%; bottom: 0; position: relative;  margin-left: 10px; font-size: 16px; font-weight: bold;" @click="deleteImage(image,index)" class="cursor-pointer">USUŃ
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label"> {{ $t('challengesNew.fileUpload') }}</label>
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
<!--                    <div>-->
<!--                        <label class="form-label">{{ $t('challengesNew.teamAccess') }}</label>-->
<!--                        <TailSelect-->
<!--                            id="post-form-5"-->
<!--                            v-model="teamsAllowed"-->
<!--                            :options="{-->
<!--                                locale: 'pl',-->
<!--                                placeholder: 'Wybierz zespoły...',-->
<!--                                limit: 'Nie można wybrać więcej',-->
<!--                                 placeholderMulti: 'Wybierz do :limit zespołów...',-->
<!--                search: false,-->
<!--                hideSelected: true,-->
<!--                hideDisabled: true,-->
<!--                multiLimit: 15,-->
<!--                multiShowCount: false,-->
<!--                multiContainer: true,-->
<!--                classNames: 'w-full'-->
<!--              }" multiple>-->
<!--                            <option selected disabled>{{ $t('challengesNew.selectTags') }}</option>-->
<!--                            <option v-for="(team,index) in user.teams" :value="team.id">{{ team.name }}</option>-->
<!--                        </TailSelect>-->
<!--                    </div>-->
                    <div class="mt-3">
                        <label for="post-form-2" class="form-label">{{ $t('challengesNew.deadlineSolutions') }}</label>
                        <Litepicker
                            id="post-form-2"
                            v-model="solution_deadline"
                            :options="{
                autoApply: false,
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
                        <label for="post-form-21" class="form-label">{{ $t('challengesNew.deadlineOffer') }}</label>
                        <Litepicker
                            id="post-form-2"
                            v-model="offer_deadline"
                            :options="{
                autoApply: false,
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
<!--                    <div class="mt-3">-->
<!--                        <label for="post-form-4" class="form-label">{{ $t('challengesNew.tags') }}</label>-->
<!--                        <TailSelect-->
<!--                            id="post-form-4"-->
<!--                            v-model="tagsSelected"-->
<!--                            :options="{-->
<!--                                locale: 'pl',-->
<!--                                placeholder: 'Wybierz tagi...',-->
<!--                                limit: 'Nie można wybrać więcej',-->
<!--                                 placeholderMulti: 'Wybierz do :limit tagów...',-->
<!--                search: false,-->
<!--                hideSelected: true,-->
<!--                hideDisabled: true,-->
<!--                multiLimit: 15,-->
<!--                multiShowCount: false,-->
<!--                multiContainer: true,-->
<!--                classNames: 'w-full'-->
<!--              }" multiple>-->
<!--                            <option selected disabled>{{ $t('challengesNew.selectTags') }}.</option>-->
<!--                            <option v-for="(tag,index) in tags" :value="index">{{ tag }}</option>-->
<!--                        </TailSelect>-->
<!--                    </div>-->
                    <!--                    <div class="form-check flex-col items-start mt-3">-->
                    <!--                        <label for="post-form-5" class="form-check-label ml-0 mb-2"-->
                    <!--                        >{{ $t('challengesNew.publish') }}</label>-->
                    <!--                        <input id="post-form-5" class="form-check-switch" v-model="publish" type="checkbox"/>-->
                    <!--                    </div>-->
                    <div class="form-check flex-col items-start mt-3">
                        <label for="post-form-6" class="form-check-label ml-0 mb-2"
                        >{{ $t('challengesNew.acceptPublic') }}</label
                        >
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


const toast = useToast();

export default {
    name: "AddChallenge",
    components: {Financials, Details, Multiselect},
    props: {
        challenge_id: Number,
    },
    setup(props) {
        const {t, locale} = useI18n({useScope: 'global'})
        const toast = useToast();
        const isDisabled = ref(false);
        const category = ref();
        const categorytab = ref(0);
        const showModal = ref(false);
        const tab = ref('desc');
        const categories = ref();
        const tags = ref();
        const tagsSelected = ref();
        const details = ref({
            select_work_shifts: '',
            select_number_of_lines: '',
            select_detail_destination: '',
            select_detail_range: '',
            select_detail_position: '',
            select_detail_pick: '',
            select_detail_size: '',
            select_detail_material: '',
            select_pick_quality: '',
            select_detail_weight: ''
        });

        const solution_deadline = ref("");
        const offer_deadline = ref("");
        const challengeSelects = ref();
        const images = ref([]);
        const teams = ref([]);
        const teamsAllowed = ref([]);
        const description = ref('');
        const description_lang = ref(locale.value);
        const en_description = ref('');
        const name = ref('');
        const en_name = ref('');
        const name_lang = ref(locale.value);
        const allowed_publishing = ref(false);
        const publish = ref(false);
        const dropzoneSingleRef = ref();
        const user = window.Laravel.user;
        const financials = ref({
            days: 260,
            shifts: 4,
            shift_time: 8,
            weekend_shift: 0,
            breakfast: 30,
            stop_time: 20,
            operator_performance: 90,
            defective: 5,
            number_of_operators: 2,
            operator_cost: 4500,
            absence: 12,
            cycle_time: 0
        });
        const id = ref(null);
        const canDeleteImage = ref(false);
        const types = require("../../json/types.json");
        const tagss = require("../../json/tagsChallenge.json");
        const sels = require("../../json/challenge.json");

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });
        const modalClosed = () => {
            showModal.value = false;
        }
        // const getTeamsRepositories = async () => {
        //     teams.value = GetTeams();
        //
        // }

        const handleCallback = (resp) => {

            if(id.value != undefined && id.value != null) {
                toast.success('Zapisano poprawnie.');
                router.push({path: '/challenges'})
                setTimeout(()=>{
                    isDisabled.value=false;
                },5000);
            } else {
                toast.success('Dodałeś wyzwanie !');
                isDisabled.value=false;
                router.push({path: '/studio/challenge/' + resp.id})
            }
        };

        const saveChallengeRepo = async () => {
            if (name.value == undefined || name.value == '') {
                toast.error("Nazwa jest wymagana.");
            } else if (category.value == undefined || category.value == null) {
                toast.error("Typ procesu jest wymagany");
            } else {
                let resp = await SaveChallenge({
                    id: props.challenge_id,
                    name: name.value,
                    description: description.value,
                    type: category.value,
                    category: categorytab.value,
                    solution_deadline: solution_deadline.value,
                    offer_deadline: offer_deadline.value,
                    allowed_publishing: allowed_publishing.value,
                    detail_weight: details.value.select_detail_weight,
                    pick_quality: details.value.select_pick_quality,
                    detail_material: details.value.select_detail_material,
                    detail_size: details.value.select_detail_size,
                    detail_pick: details.value.select_detail_pick,
                    detail_position: details.value.select_detail_position,
                    detail_range: details.value.select_detail_range,
                    detail_destination: details.value.select_detail_destination,
                    number_of_lines: details.value.select_number_of_lines,
                    work_shifts: details.value.select_work_shifts,
                    // teams: teamsAllowed.value,
                    tags: tagsSelected.value,
                    images: images.value,

                    days: financials.value.days,
                    shifts: financials.value.shifts,
                    shift_time: financials.value.shift_time,
                    weekend_shift: financials.value.weekend_shift,
                    breakfast: financials.value.breakfast,
                    stop_time: financials.value.stop_time,
                    operator_performance: financials.value.operator_performance,
                    defective: financials.value.defective,
                    number_of_operators: financials.value.number_of_operators,
                    operator_cost: financials.value.operator_cost,
                    absence: financials.value.absence,
                    cycle_time: financials.value.cycle_time,


                }, handleCallback);
                // emitter.emit('changestudio', {val: 'challenge'});
                isDisabled.value = true;
            }

        }

        const deleteImage = (image,index) => {
            if(canDeleteImage.value === true){
                RequestHandler('challenges/' + props.challenge_id + '/file/delete', 'post', {
                    file_id: image.id,
                }, (response) => {
                    images.value.splice(index, 1);
                });
            } else {
                images.value.splice(index, 1);
            }
        }

        onMounted(() => {
            categories.value = types;
            tags.value = tagss;
            challengeSelects.value = sels;
            const elDropzoneSingleRef = dropzoneSingleRef.value;

            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                images.value.push(JSON.parse(resp.xhr.response).payload);
                toast.success('Plik został wgrany poprawnie!');
            });
            elDropzoneSingleRef.dropzone.on("error", () => {
                toast.error("Błąd");
            });
            cash("body")
                .removeClass("error-page");

            if (props.challenge_id != undefined) {
                id.value = props.challenge_id;
                getChallengeCardRepositories();
                canDeleteImage.value = true;
                // getTeamsRepositories();
            }
        });


        const getChallengeCardRepositories = async () => {
            await axios.post('/api/challenge/user/get/card', {id: props.challenge_id})
                .then(response => {
                    if (response.data.success) {
                        name.value = response.data.payload.name;
                        description.value = response.data.payload.description;
                        category.value = String(response.data.payload.type);
                        categorytab.value = String(response.data.payload.category);
                        solution_deadline.value = dayjs.unix(response.data.payload.solution_deadline).format('DD.MM.YYYY');
                        offer_deadline.value = dayjs.unix(response.data.payload.offer_deadline).format('DD.MM.YYYY');
                        allowed_publishing.value = response.data.payload.allowed_publishing;
                        details.value.select_detail_weight = response.data.payload.technical_details.detail_weight;
                        details.value.select_pick_quality = response.data.payload.technical_details.pick_quality;
                        details.value.select_detail_material = response.data.payload.technical_details.detail_material;
                        details.value.select_detail_size = response.data.payload.technical_details.detail_size;
                        details.value.select_detail_pick = response.data.payload.technical_details.detail_pick;
                        details.value.select_detail_position = response.data.payload.technical_details.detail_position;
                        details.value.select_detail_range = response.data.payload.technical_details.detail_range;
                        details.value.select_detail_destination = response.data.payload.technical_details.detail_destination;
                        details.value.select_number_of_lines = response.data.payload.technical_details.number_of_lines;
                        details.value.select_work_shifts = response.data.payload.technical_details.work_shifts;
                        // teams.value = response.data.payload.teams;
                        // tags: tagsSelected.value,
                        images.value = response.data.payload.files;

                        financials.value.days = response.data.payload.financial_before.days;
                        financials.value.shifts = response.data.payload.financial_before.shifts;
                        financials.value.shift_time = response.data.payload.financial_before.shift_time;
                        financials.value.weekend_shift = response.data.payload.financial_before.weekend_shift;
                        financials.value.breakfast = response.data.payload.financial_before.breakfast;
                        financials.value.stop_time = response.data.payload.financial_before.stop_time;
                        financials.value.operator_performance = response.data.payload.financial_before.operator_performance;
                        financials.value.defective = response.data.payload.financial_before.defective;
                        financials.value.number_of_operators = response.data.payload.financial_before.number_of_operators;
                        financials.value.operator_cost = response.data.payload.financial_before.operator_cost;
                        financials.value.absence = response.data.payload.financial_before.absence;
                        financials.value.cycle_time = response.data.payload.financial_before.cycle_time;
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        return {
            canDeleteImage,
            categories,
            category,
            tags,
            teams,
            teamsAllowed,
            description,
            name,
            allowed_publishing,
            publish,
            solution_deadline,
            offer_deadline,
            tab,
            challengeSelects,
            details,
            modalClosed,
            showModal,
            images,
            saveChallengeRepo,
            name_lang,
            en_name,
            description_lang,
            en_description,
            financials,
            deleteImage,
            tagsSelected,
            isDisabled,
            user,
            categorytab
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
