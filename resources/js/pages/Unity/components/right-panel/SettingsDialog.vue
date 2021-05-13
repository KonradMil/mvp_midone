<template>
    <div
        class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mb-14"
    >
        <div class="mt-5">
            <div
                class="px-5 sm:px-10pt-2"
            >
                <!--                <div class="font-medium text-base">Profile Settings</div>-->
                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="intro-y col-span-12">
                        <label for="input-wizard-1" class="form-label">
                            Max waga
                        </label>
                        <TailSelect
                            id="input-wizard-1"
                            v-model="technical.detail_weight"
                            :options="{locale: 'pl', placeholder: sels.select_detail_weight.find(i => i.value === technical.detail_weight).name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in sels.select_detail_weight"
                                    :value="det.value">{{ det.name }}
                            </option>

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12">
                        <label for="input-wizard-2" class="form-label">
                            {{$t('challengesNew.quality')}}
                        </label>
                        <TailSelect
                            id="input-wizard-2"
                            v-model="technical.pick_quality"
                            :options="{locale: 'pl', placeholder: sels.select_pick_quality.find(i => i.value === technical.pick_quality).name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in sels.select_pick_quality"
                                    :value="det.value">{{ det.name }}
                            </option>

                        </TailSelect>

                    </div>
                    <div class="intro-y col-span-12">
                        <label for="input-wizard-3" class="form-label">{{$t('challengesNew.detail')}}</label>
                        <TailSelect
                            id="input-wizard-3"
                            v-model="technical.detail_material"
                            :options="{locale: 'pl', placeholder: sels.select_detail_material.find(i => i.value === technical.detail_material).name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>{{$t('challengesNew.select')}}</option>
                            <option
                                v-for="(det,index) in sels.select_detail_material"
                                :value="det.value">{{ det.name }}
                            </option>

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12">
                        <label for="input-wizard-4" class="form-label">{{$t('challengesNew.size')}}</label>
                        <TailSelect
                            id="input-wizard-4"
                            v-model="technical.detail_size"
                            :options="{locale: 'pl', placeholder: sels.select_detail_size.find(i => i.value === technical.detail_size).name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>{{$t('challengesNew.select')}}</option>
                            <option v-for="(det,index) in sels.select_detail_size"
                                    :value="det.value">{{ det.name }}
                            </option>

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12">
                        <label for="input-wizard-5" class="form-label">
                            {{$t('challengesNew.way')}}
                        </label>
                        <TailSelect
                            id="input-wizard-5"
                            v-model="technical.detail_pick"
                            :options="{locale: 'pl', placeholder: sels.select_detail_pick.find(i => i.value === technical.detail_pick).name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled> {{$t('challengesNew.select')}}</option>
                            <option v-for="(det,index) in sels.select_detail_pick"
                                    :value="det.value">{{ det.name }}
                            </option>

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12">
                        <label for="input-wizard-6" class="form-label">
                            {{$t('challengesNew.position')}}
                        </label>
                        <TailSelect
                            id="input-wizard-6"
                            v-model="technical.detail_position"
                            :options="{locale: 'pl', placeholder: sels.select_detail_position.find(i => i.value === technical.detail_position).name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled> {{$t('challengesNew.select')}}</option>
                            <option
                                v-for="(det,index) in sels.select_detail_position"
                                :value="det.value">{{ det.name }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12">
                        <label for="input-wizard-7" class="form-label">
                            {{$t('challengesNew.distance')}}
                        </label>
                        <TailSelect
                            id="input-wizard-7"
                            v-model="technical.detail_range"
                            :options="{locale: 'pl', placeholder: sels.select_detail_range.find(i => i.value === technical.detail_range).name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled> {{$t('challengesNew.select')}}</option>
                            <option v-for="(det,index) in sels.select_detail_range"
                                    :value="det.value">{{ det.name }}
                            </option>

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12">
                        <label for="input-wizard-8" class="form-label">
                            {{$t('challengesNew.place')}}
                        </label>
                        <TailSelect
                            id="input-wizard-8"
                            v-model="technical.detail_destination"
                            :options="{locale: 'pl', placeholder: sels.select_detail_destination.find(i => i.value === technical.detail_destination).name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled> {{$t('challengesNew.select')}}</option>
                            <option
                                v-for="(det,index) in sels.select_detail_destination"
                                :value="det.value">{{ det.name }}
                            </option>

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12" >
                        <label for="input-wizard-9" class="form-label">
                            {{$t('challengesNew.numberSupported')}}
                        </label>
                        <TailSelect
                            id="input-wizard-9"
                            v-model="technical.number_of_lines"
                            :options="{locale: 'pl', placeholder: sels.select_number_of_lines.find(i => i.value === technical.number_of_lines).name, openAbove: false, animate: false, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>{{$t('challengesNew.select')}}</option>
                            <option
                                v-for="(det,index) in sels.select_number_of_lines"
                                :value="det.value">{{ det.name }}
                            </option>

                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12">
                        <label for="input-wizard-10" class="form-label">{{$t('challengesNew.changeNumber')}}</label>
                        <TailSelect
                            id="input-wizard-10"
                            v-model="technical.work_shifts"
                            :options="{locale: 'pl', placeholder: sels.select_work_shifts.find(i => i.value === technical.work_shifts).name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                        >
                            <option selected disabled>{{$t('challengesNew.select')}}</option>
                            <option
                                v-for="(det,index) in sels.select_work_shifts"
                                :value="det.value">{{ det.name }}
                            </option>
                        </TailSelect>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
// import Multiselect from '@vueform/multiselect'

export default {
    name: "SettingsDialog",
    // components: {Multiselect},
    props: {
        object: Object,
        technical: Object,
        id: Number
    },
    setup(props) {
        const sels = require("../../../../json/challenge.json");

        const t =ref('');
        // const select_detail_pick = ref();
        const select_work_shifts = ref();
        const work = ref();

        console.log('TECHNICAL.ID!!!!' + props.technical.id);
        const challengeSelects = ref();
        onMounted(() => {
            challengeSelects.value = sels;
            // t.value = props.technical
            // select_detail_pick.value = sels.select_detail_pick.find(i => i.value === object.detail_pick).name
            // c.value = props.object

        });

        return {
            sels,
            select_work_shifts,
            t,
            // select_detail_pick,
        }
    }
}
</script>

<style scoped>

</style>
