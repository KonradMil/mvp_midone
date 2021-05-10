<template>
    <div
        class="border border-gray-200 dark:border-dark-5 rounded-md p-5"
    >
        <div class="mt-5">
            <div
                class="px-5 sm:px-10pt-2"
            >
                <!--                <div class="font-medium text-base">Profile Settings</div>-->
                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-1" class="form-label">
                            {{$t('challengesNew.maxWeight')}}
                        </label>
                        <TailSelect
                            id="input-wizard-1"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in challengeSelects.select_detail_weight"
                                    :value="det.value">{{ det.name }}
                            </option>

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-2" class="form-label">
                            {{$t('challengesNew.quality')}}
                        </label>
                        <TailSelect
                            id="input-wizard-2"
                            v-model="select_pick_quality"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>Wybierz...</option>
<!--                            <option v-for="(det,index) in challengeSelects.select_pick_quality"-->
<!--                                    :value="det.value">{{ det.name }}-->
<!--                            </option>-->

                        </TailSelect>

                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-3" class="form-label">{{$t('challengesNew.detail')}}</label>
                        <TailSelect
                            id="input-wizard-3"
                            v-model="select_detail_material"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>{{$t('challengesNew.select')}}</option>
<!--                            <option-->
<!--                                v-for="(det,index) in challengeSelects.select_detail_material"-->
<!--                                :value="det.value">{{ det.name }}-->
<!--                            </option>-->

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-4" class="form-label">{{$t('challengesNew.size')}}</label>
                        <TailSelect
                            id="input-wizard-4"
                            v-model="select_detail_size"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>{{$t('challengesNew.select')}}</option>
<!--                            <option v-for="(det,index) in challengeSelects.select_detail_size"-->
<!--                                    :value="det.value">{{ det.name }}-->
<!--                            </option>-->

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">
                            {{$t('challengesNew.way')}}
                        </label>
                        <TailSelect
                            id="input-wizard-5"
                            v-model="select_detail_pick"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled> {{$t('challengesNew.select')}}</option>
<!--                            <option v-for="(det,index) in challengeSelects.select_detail_pick"-->
<!--                                    :value="det.value">{{ det.name }}-->
<!--                            </option>-->

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">
                            {{$t('challengesNew.position')}}
                        </label>
                        <TailSelect
                            id="input-wizard-6"
                            v-model="select_detail_position"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled> {{$t('challengesNew.select')}}</option>
<!--                            <option-->
<!--                                v-for="(det,index) in challengeSelects.select_detail_position"-->
<!--                                :value="det.value">{{ det.name }}-->
<!--                            </option>-->

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-7" class="form-label">
                            {{$t('challengesNew.distance')}}
                        </label>
                        <TailSelect
                            id="input-wizard-7"
                            v-model="select_detail_range"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled> {{$t('challengesNew.select')}}</option>
<!--                            <option v-for="(det,index) in challengeSelects.select_detail_range"-->
<!--                                    :value="det.value">{{ det.name }}-->
<!--                            </option>-->

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-8" class="form-label">
                            {{$t('challengesNew.place')}}
                        </label>
                        <TailSelect
                            id="input-wizard-8"
                            v-model="select_detail_destination"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled> {{$t('challengesNew.select')}}</option>
<!--                            <option-->
<!--                                v-for="(det,index) in challengeSelects.select_detail_destination"-->
<!--                                :value="det.value">{{ det.name }}-->
<!--                            </option>-->

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6" >
                        <label for="input-wizard-9" class="form-label">
                            {{$t('challengesNew.numberSupported')}}
                        </label>
                        <TailSelect
                            id="input-wizard-9"
                            v-model="select_number_of_lines"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', openAbove: false, animate: false, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>{{$t('challengesNew.select')}}</option>
<!--                            <option-->
<!--                                v-for="(det,index) in challengeSelects.select_number_of_lines"-->
<!--                                :value="det.value">{{ det.name }}-->
<!--                            </option>-->

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-10" class="form-label">{{$t('challengesNew.changeNumber')}}</label>
                        <Multiselect
                            class="w-full h-8 z-50"
                            mode="single"
                            label="name"
                            max="1"
                            placeholder="Wybierz"
                            valueProp="value"
                        />


                        <!--                                                <TailSelect-->
                        <!--                                                    id="input-wizard-10"-->
                        <!--                                                    v-model="select_work_shifts"-->
                        <!--                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
                        <!--                                                >-->


                        <!--                                                </TailSelect>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <label for="modal-form-3" class="form-label">Solution deadline</label>
        <input
            id="modal-form-3"
            type="text"
            class="form-control"
            placeholder=""
            v-model="c.solution_deadline"
        />
    </div>
    <div class="mt-3">
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
            v-model="c.name"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Opis</label>
        <textarea
            id="modal-form-2"
            class="form-control"
            v-model="c.description"
        />
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import { useI18n } from 'vue-i18n'
import {useToast} from "vue-toastification";
import SaveChallenge from "../../../../compositions/SaveChallenge";
import Multiselect from '@vueform/multiselect'

export default {
    name: "DescriptionDialog",
    components: {Multiselect},
    props: {
        object: Object
    },
    setup(props, context) {
        const c = ref({description: '', name: '', solution_deadline: '', offer_deadline: ''});
        const { t, locale } = useI18n({ useScope: 'global' })
        const toast = useToast();
        const category = ref();
        const showModal = ref(false);
        const tab = ref('desc');
        const categories = ref();
        const tags = ref();
        const tagsSelected = ref();
        const solution_deadline = ref("");
        const offer_deadline = ref("");
        const challengeSelects = ref();
        const select_work_shifts = ref();
        const select_number_of_lines = ref();
        const select_detail_destination = ref();
        const select_detail_range = ref();
        const select_detail_position = ref();
        const select_detail_pick = ref();
        const select_detail_size = ref();
        const select_detail_material = ref();
        const select_pick_quality = ref();
        const select_detail_weight = ref();
        const images = ref([]);
        const teams = ref([]);
        const teamsAllowed = ref([]);
        const description = ref('');
        const name = ref('');
        const allowed_publishing = ref(false);
        const publish = ref(false);
        const types = require("../../../../json/types.json");
        const tagss = require("../../../../json/tagsChallenge.json");
        const sels = require("../../../../json/challenge.json");

        const saveChallengeRepo = async () => {
            SaveChallenge({
                name: name.value,
                description: description.value,
                type: category.value,
                solution_deadline: solution_deadline.value,
                offer_deadline: offer_deadline.value,
                allowed_publishing: allowed_publishing.value,
                detail_weight: select_detail_weight.value,
                pick_quality: select_pick_quality.value,
                detail_material: select_detail_material.value,
                detail_size: select_detail_size.value,
                detail_pick: select_detail_pick.value,
                detail_position: select_detail_position.value,
                detail_range: select_detail_range.value,
                detail_destination: select_detail_destination.value,
                number_of_lines: select_number_of_lines.value,
                work_shifts: select_work_shifts.value,
                teams: teamsAllowed.value,
                tags: tagsSelected.value,
                images: images.value
            });
        }
        watch(c, (ca, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:comment", ca);
        }, {deep: true})
        onMounted(() => {
            categories.value = types;
            tags.value = tagss;
            challengeSelects.value = sels;
            saveChallengeRepo('');
            if (props.object.name != undefined && props.object.name != '') {
                c.value.name = props.object.name;
            } else {
                c.value.name = '';
            }

            if (props.object.description != undefined && props.object.description != '') {
                c.value.description = props.object.description;
            } else {
                c.value.description = '';
            }
            if (props.object.solution_deadline != undefined && props.object.solution_deadline != '') {
                c.value.solution_deadline = props.object.solution_deadline;
            } else {
                c.value.solution_deadline = '';
            }
            if (props.object.offer_deadline != undefined && props.object.offer_deadline != '') {
                c.value.offer_deadline = props.object.offer_deadline;
            } else {
                c.value.offer_deadline = '';
            }
        });

        return {
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
            select_work_shifts,
            select_number_of_lines,
            select_detail_destination,
            select_detail_range,
            select_detail_position,
            select_detail_pick,
            select_detail_size,
            select_detail_material,
            select_pick_quality,
            select_detail_weight,
            c,
            sels,
            tagss,
            types
        }
    }
}
</script>

<style scoped>

</style>
