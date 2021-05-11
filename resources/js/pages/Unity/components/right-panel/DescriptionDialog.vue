<template>
    <div class="flex">
    <div
        class="border border-gray-200 dark:border-dark-5 rounded-md p-5 flex-initial"
    >
        <div class="mt-5">
            <div
                class="px-5 sm:px-10pt-2"
            >
                <!--                <div class="font-medium text-base">Profile Settings</div>-->
                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-1" class="form-label">
                            Max waga
                        </label>
                        <TailSelect
                            id="input-wizard-1"
                            v-model="select_detail_weight"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in sels.select_detail_weight"
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
    <div class="flex-initial">
    <div class="mt-3 ">
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
    </div>
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import Multiselect from '@vueform/multiselect'
import cash from "cash-dom";


export default {
    name: "DescriptionDialog",
    props: {
        object: Object
    },
    setup(props, context) {
        const c = ref({description: '', name: '', solution_deadline: '', offer_deadline: ''});

        const challengeSelects = ref();
        // const select_detail_weight = ref();

        const types = require("../../../../json/types.json");
        const tagss = require("../../../../json/tagsChallenge.json");
        const sels = require("../../../../json/challenge.json");

        watch(c, (ca, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:comment", ca);
        }, {deep: true})
        onMounted(() => {
            challengeSelects.value = sels;

            c.value = props.object
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
            c,
            sels,
            tagss,
            types,
            // select_detail_weight,
            challengeSelects
        }
    }
}
</script>

<style scoped>

</style>
