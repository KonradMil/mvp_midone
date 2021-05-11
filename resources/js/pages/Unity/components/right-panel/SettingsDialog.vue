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
                            v-model="select_detail_weight"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
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
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
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
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
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
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
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
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
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
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
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
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
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
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
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
                            :options="{locale: 'pl', placeholder: 'Wybierz...', openAbove: false, animate: false, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
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
                        <Multiselect
                            class="w-full h-8 z-50"
                            mode="single"
                            label="name"
                            max="1"
                            placeholder="Wybierz"
                            valueProp="value"
                            :options="sels.select_work_shifts"
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
</template>

<script>
import {onMounted, ref} from "vue";

export default {
    name: "SettingsDialog",
    props: {
        object: Object
    },
    setup(props) {
        const sels = require("../../../../json/challenge.json");

        const challengeSelects = ref();
        onMounted(() => {
            challengeSelects.value = sels;

            c.value = props.object
        });

        return {
            sels
        }
    }
}
</script>

<style scoped>

</style>
