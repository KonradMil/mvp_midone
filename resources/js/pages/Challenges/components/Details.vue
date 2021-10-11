<template>
    <div
        class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
        <div class="mt-5">
            <div class="px-5 sm:px-10pt-2">
                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-1" class="form-label">
                            {{$t('challengesNew.maxWeight')}}
                        </label>
                        <TailSelect
                            id="input-wizard-1"
                            v-model="details.select_detail_weight"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option  :selected="details.select_detail_weight === '' ? '' : 'selected'" disabled>Wybierz...</option>
                            <option :selected="det.value === details.select_detail_weight ? '' : 'selected'" v-for="(det,index) in props.selects.select_detail_weight"
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
                            v-model="details.select_pick_quality"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option :selected="details.select_pick_quality === '' ? '' : 'selected'" disabled>Wybierz...</option>
                            <option :selected="det.value === details.select_pick_quality ? '' : 'selected'" v-for="(det,index) in props.selects.select_pick_quality"
                                    :value="det.value">{{ det.name }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-3" class="form-label">{{$t('challengesNew.detail')}}</label>
                        <TailSelect
                            id="input-wizard-3"
                            v-model="details.select_detail_material"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', openAbove: false,search: false, hideSelected: false, classNames: 'w-full' }">
                            <option :selected="details.select_detail_material === '' ? '' : 'selected'" disabled>{{$t('challengesNew.select')}}</option>
                            <option :selected="det.value === details.select_detail_material ? '' : 'selected'"
                                v-for="(det,index) in props.selects.select_detail_material"
                                :value="det.value">{{ det.name }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-4" class="form-label">{{$t('challengesNew.size')}}</label>
                        <TailSelect
                            id="input-wizard-4"
                            v-model="details.select_detail_size"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej',openAbove: false, search: false, hideSelected: false, classNames: 'w-full' }">
                            <option :selected="details.select_detail_size === '' ? '' : 'selected'" disabled>{{$t('challengesNew.select')}}</option>
                            <option :selected="det.value === details.select_detail_size ? '' : 'selected'" v-for="(det,index) in props.selects.select_detail_size"
                                    :value="det.value">{{ det.name }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">
                            {{$t('challengesNew.way')}}
                        </label>
                        <TailSelect
                            id="input-wizard-5"
                            v-model="details.select_detail_pick"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej',openAbove: false, search: false, hideSelected: false, classNames: 'w-full' }">
                            <option  :selected="details.select_detail_pick === '' ? '' : 'selected'" disabled> {{$t('challengesNew.select')}}</option>
                            <option :selected="det.value === details.select_detail_pick ? '' : 'selected'" v-for="(det,index) in props.selects.select_detail_pick"
                                    :value="det.value">{{ det.name }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">
                            {{$t('challengesNew.position')}}
                        </label>
                        <TailSelect
                            id="input-wizard-6"
                            v-model="details.select_detail_position"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej',openAbove: false, search: false, hideSelected: false, classNames: 'w-full' }">
                            <option :selected="details.select_detail_position === '' ? '' : 'selected'" disabled> {{$t('challengesNew.select')}}</option>
                            <option :selected="det.value === details.select_detail_position ? '' : 'selected'"
                                v-for="(det,index) in props.selects.select_detail_position"
                                :value="det.value">{{ det.name }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-7" class="form-label">
                            {{$t('challengesNew.distance')}}
                        </label>
                        <TailSelect
                            id="input-wizard-7"
                            v-model="details.select_detail_range"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', openAbove: false, search: false, hideSelected: false, classNames: 'w-full' }">
                            <option :selected="details.select_detail_range === '' ? '' : 'selected'" disabled> {{$t('challengesNew.select')}}</option>
                            <option :selected="det.value === details.select_detail_range ? '' : 'selected'" v-for="(det,index) in props.selects.select_detail_range"
                                    :value="det.value">{{ det.name }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-8" class="form-label">
                            {{$t('challengesNew.place')}}
                        </label>
                        <TailSelect
                            id="input-wizard-8"
                            v-model="details.select_detail_destination"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option  :selected="details.select_detail_destination === '' ? '' : 'selected'" disabled> {{$t('challengesNew.select')}}</option>
                            <option  :selected="det.value === details.select_detail_destination ? '' : 'selected'"
                                v-for="(det,index) in props.selects.select_detail_destination"
                                :value="det.value">{{ det.name }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6" >
                        <label for="input-wizard-9" class="form-label">
                            {{$t('challengesNew.numberSupported')}}
                        </label>
                        <input type="number" v-model="details.select_number_of_lines" class="form-control" placeholder="1" :aria-label="$t('challengesNew.numberSupported')" />
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-10" class="form-label">{{$t('challengesNew.changeNumber')}}</label>
                        <TailSelect
                            id="input-wizard-9"
                            v-model="details.select_work_shifts"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', openAbove: false, animate: false, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option :selected="details.select_work_shifts === '' ? '' : 'selected'" disabled>{{$t('challengesNew.select')}}</option>
                            <option :selected="det.value === details.select_work_shifts ? '' : 'selected'"
                                v-for="(det,index) in props.selects.select_work_shifts"
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
import {onMounted, ref, watch} from "vue";

export default {
name: "Details",
    props: {
        details: Object,
        types: Array,
        selects: Object
    },
    emits: ["update:details"],
    setup(props, context) {
        const details = ref({});

        watch(details, (lab, prevLabel) => {

            context.emit("update:details", lab);
        }, {deep: true});

        onMounted(() => {
           details.value = props.details;
        });

        return {
            props,
            details
        }
    }
}
</script>

<style scoped>

</style>
