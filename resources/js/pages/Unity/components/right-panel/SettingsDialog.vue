<template>
    <div
        class="px-5 sm:px-10pt-2"
    >
        <!--                <div class="font-medium text-base">Profile Settings</div>-->
        <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">

            <div class="intro-y col-span-12">
                <p class="alert alert-warning show">Przed wprowadzeniem zmian upewnij się, że kursor znajduje się we właściwym polu.</p><br>
            </div>

            <div class="intro-y col-span-12">
                <label for="input-wizard-1" class="form-label">
                    Max waga
                </label>
                <TailSelect
                    id="input-wizard-1"
                    v-model="technical.detail_weight"
                    :options="{locale: 'pl', placeholder: sels.select_detail_weight[technical.detail_weight].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                    <option selected disabled>Wybierz...</option>
                    <option v-for="(det,index) in sels.select_detail_weight"
                            :value="det.value"
                            :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))">
                        {{ det.name }}
                    </option>
                </TailSelect>
            </div>
            <div class="intro-y col-span-12">
                <label for="input-wizard-2" class="form-label">
                    {{ $t('challengesNew.quality') }}
                </label>
                <TailSelect
                    id="input-wizard-2"
                    v-model="technical.pick_quality"
                    :options="{locale: 'pl', placeholder: sels.select_pick_quality[technical.pick_quality].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                    <option selected disabled>Wybierz...</option>
                    <option v-for="(det,index) in sels.select_pick_quality"
                            :value="det.value"
                            :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))">
                        {{ det.name }}
                    </option>
                </TailSelect>
            </div>
            <div class="intro-y col-span-12">
                <label for="input-wizard-3" class="form-label">{{ $t('challengesNew.detail') }}</label>
                <TailSelect
                    id="input-wizard-3"
                    v-model="technical.detail_material"
                    :options="{locale: 'pl', placeholder: sels.select_detail_material[technical.detail_material].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                >
                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                    <option
                        v-for="(det,index) in sels.select_detail_material"
                        :value="det.value"
                        :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))">
                        {{ det.name }}
                    </option>
                </TailSelect>
            </div>
            <div class="intro-y col-span-12">
                <label for="input-wizard-4" class="form-label">{{ $t('challengesNew.size') }}</label>
                <TailSelect
                    id="input-wizard-4"
                    v-model="technical.detail_size"
                    :options="{locale: 'pl', placeholder: sels.select_detail_size[technical.detail_size].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                >
                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                    <option v-for="(det,index) in sels.select_detail_size"
                            :value="det.value"
                            :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))">
                        {{ det.name }}
                    </option>
                </TailSelect>
            </div>
            <div class="intro-y col-span-12">
                <label for="input-wizard-5" class="form-label">
                    {{ $t('challengesNew.way') }}
                </label>
                <TailSelect

                    id="input-wizard-5"
                    v-model="technical.detail_pick"
                    :options="{locale: 'pl', placeholder: sels.select_detail_pick[technical.detail_pick].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                >
                    <option selected disabled> {{ $t('challengesNew.select') }}</option>
                    <option v-for="(det,index) in sels.select_detail_pick"
                            :value="det.value"
                            :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))">
                        {{ det.name }}
                    </option>
                </TailSelect>
            </div>
            <div class="intro-y col-span-12">
                <label for="input-wizard-6" class="form-label">
                    {{ $t('challengesNew.position') }}
                </label>
                <TailSelect

                    id="input-wizard-6"
                    v-model="technical.detail_position"
                    :options="{locale: 'pl', placeholder: sels.select_detail_position[technical.detail_position].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                >
                    <option selected disabled> {{ $t('challengesNew.select') }}</option>
                    <option
                        :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))"
                        v-for="(det,index) in sels.select_detail_position"
                        :value="det.value">{{ det.name }}
                    </option>
                </TailSelect>
            </div>
            <div class="intro-y col-span-12">
                <label for="input-wizard-7" class="form-label">
                    {{ $t('challengesNew.distance') }}
                </label>
                <TailSelect
                    id="input-wizard-7"
                    v-model="technical.detail_range"
                    :options="{locale: 'pl', placeholder: sels.select_detail_range[technical.detail_range].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                >
                    <option selected disabled> {{ $t('challengesNew.select') }}</option>

                    <option v-for="(det,index) in sels.select_detail_range"
                            :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))"
                            :value="det.value">{{ det.name }}
                    </option>

                </TailSelect>
            </div>
            <div class="intro-y col-span-12">
                <label for="input-wizard-8" class="form-label">
                    {{ $t('challengesNew.place') }}
                </label>
                <TailSelect

                    id="input-wizard-8"
                    v-model="technical.detail_destination"
                    :options="{locale: 'pl', placeholder: sels.select_detail_destination[technical.detail_destination].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                >
                    <option selected disabled> {{ $t('challengesNew.select') }}</option>
                    <option
                        :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))"
                        v-for="(det,index) in sels.select_detail_destination"
                        :value="det.value">
                        {{ det.name }}
                    </option>
                </TailSelect>
            </div>
            <div class="intro-y col-span-12">
                <label for="input-wizard-9" class="form-label">
                    {{ $t('challengesNew.numberSupported') }}
                </label>
<!--                <div>{{technical.number_of_lines}}</div>-->
                <input :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))" class="form-control" v-model="technical.number_of_lines" :placeholder="technical.number_of_lines"/>
<!--                <TailSelect-->
<!--                    id="input-wizard-9"-->
<!--                    v-model="technical.number_of_lines"-->
<!--                    :options="{locale: 'pl', placeholder: 1, openAbove: false, animate: false, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                >-->
<!--                    <option selected disabled>{{ $t('challengesNew.select') }}</option>-->
<!--                    <option-->
<!--                        v-for="(det,index) in sels.select_number_of_lines"-->
<!--                        :value="det.value">{{ det.name }}-->
<!--                    </option>-->

<!--                </TailSelect>-->
            </div>
            <div class="intro-y col-span-12">
                <label for="input-wizard-10" class="form-label">{{ $t('challengesNew.changeNumber') }}</label>
                <TailSelect

                    id="input-wizard-10"
                    v-model="technical.work_shifts"
                    :options="{locale: 'pl', placeholder: sels.select_work_shifts[technical.work_shifts].name, limit: 'Nie można wybrać więcej', openAbove: false, search: false, hideSelected: false, classNames: 'w-full' }"
                >
                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                    <option
                        :disabled="((user.type === 'integrator') || ((type==='solution') && (user.type==='investor')))"
                        v-for="(det,index) in sels.select_work_shifts"
                        :value="det.value">{{ det.name }}
                    </option>
                </TailSelect>
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
        technical: Object,
        type: String
    },
    setup(props) {
        const user = window.Laravel.user;
        const sels = require("../../../../json/challenge.json");
        onMounted(() => {
        });

        return {
            sels,
            user
        }
    }
}
</script>

<style scoped>

</style>
