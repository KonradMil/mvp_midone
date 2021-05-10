<template>
<!--    <div-->
<!--        class="border border-gray-200 dark:border-dark-5 rounded-md p-5"-->
<!--    >-->
<!--        <div class="mt-5">-->
<!--            <div-->
<!--                class="px-5 sm:px-10pt-2"-->
<!--            >-->
<!--                &lt;!&ndash;                <div class="font-medium text-base">Profile Settings</div>&ndash;&gt;-->
<!--                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6">-->
<!--                        <label for="input-wizard-1" class="form-label">-->
<!--                            {{$t('challengesNew.maxWeight')}}-->
<!--                        </label>-->
<!--                        <TailSelect-->
<!--                            id="input-wizard-1"-->
<!--                            v-model="select_detail_weight"-->
<!--                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                        >-->
<!--                            <option selected disabled>Wybierz...</option>-->
<!--                            <option v-for="(det,index) in challengeSelects.select_detail_weight"-->
<!--                                    :value="det.value">{{ det.name }}-->
<!--                            </option>-->

<!--                        </TailSelect>-->
<!--                    </div>-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6">-->
<!--                        <label for="input-wizard-2" class="form-label">-->
<!--                            {{$t('challengesNew.quality')}}-->
<!--                        </label>-->
<!--                        <TailSelect-->
<!--                            id="input-wizard-2"-->
<!--                            v-model="select_pick_quality"-->
<!--                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                        >-->
<!--                            <option selected disabled>Wybierz...</option>-->
<!--                            <option v-for="(det,index) in challengeSelects.select_pick_quality"-->
<!--                                    :value="det.value">{{ det.name }}-->
<!--                            </option>-->

<!--                        </TailSelect>-->

<!--                    </div>-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6">-->
<!--                        <label for="input-wizard-3" class="form-label">{{$t('challengesNew.detail')}}</label>-->
<!--                        <TailSelect-->
<!--                            id="input-wizard-3"-->
<!--                            v-model="select_detail_material"-->
<!--                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                        >-->
<!--                            <option selected disabled>{{$t('challengesNew.select')}}</option>-->
<!--                            <option-->
<!--                                v-for="(det,index) in challengeSelects.select_detail_material"-->
<!--                                :value="det.value">{{ det.name }}-->
<!--                            </option>-->

<!--                        </TailSelect>-->
<!--                    </div>-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6">-->
<!--                        <label for="input-wizard-4" class="form-label">{{$t('challengesNew.size')}}</label>-->
<!--                        <TailSelect-->
<!--                            id="input-wizard-4"-->
<!--                            v-model="select_detail_size"-->
<!--                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                        >-->
<!--                            <option selected disabled>{{$t('challengesNew.select')}}</option>-->
<!--                            <option v-for="(det,index) in challengeSelects.select_detail_size"-->
<!--                                    :value="det.value">{{ det.name }}-->
<!--                            </option>-->

<!--                        </TailSelect>-->
<!--                    </div>-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6">-->
<!--                        <label for="input-wizard-5" class="form-label">-->
<!--                            {{$t('challengesNew.way')}}-->
<!--                        </label>-->
<!--                        <TailSelect-->
<!--                            id="input-wizard-5"-->
<!--                            v-model="select_detail_pick"-->
<!--                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                        >-->
<!--                            <option selected disabled> {{$t('challengesNew.select')}}</option>-->
<!--                            <option v-for="(det,index) in challengeSelects.select_detail_pick"-->
<!--                                    :value="det.value">{{ det.name }}-->
<!--                            </option>-->

<!--                        </TailSelect>-->
<!--                    </div>-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6">-->
<!--                        <label for="input-wizard-6" class="form-label">-->
<!--                            {{$t('challengesNew.position')}}-->
<!--                        </label>-->
<!--                        <TailSelect-->
<!--                            id="input-wizard-6"-->
<!--                            v-model="select_detail_position"-->
<!--                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                        >-->
<!--                            <option selected disabled> {{$t('challengesNew.select')}}</option>-->
<!--                            <option-->
<!--                                v-for="(det,index) in challengeSelects.select_detail_position"-->
<!--                                :value="det.value">{{ det.name }}-->
<!--                            </option>-->

<!--                        </TailSelect>-->
<!--                    </div>-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6">-->
<!--                        <label for="input-wizard-7" class="form-label">-->
<!--                            {{$t('challengesNew.distance')}}-->
<!--                        </label>-->
<!--                        <TailSelect-->
<!--                            id="input-wizard-7"-->
<!--                            v-model="select_detail_range"-->
<!--                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                        >-->
<!--                            <option selected disabled> {{$t('challengesNew.select')}}</option>-->
<!--                            <option v-for="(det,index) in challengeSelects.select_detail_range"-->
<!--                                    :value="det.value">{{ det.name }}-->
<!--                            </option>-->

<!--                        </TailSelect>-->
<!--                    </div>-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6">-->
<!--                        <label for="input-wizard-8" class="form-label">-->
<!--                            {{$t('challengesNew.place')}}-->
<!--                        </label>-->
<!--                        <TailSelect-->
<!--                            id="input-wizard-8"-->
<!--                            v-model="select_detail_destination"-->
<!--                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                        >-->
<!--                            <option selected disabled> {{$t('challengesNew.select')}}</option>-->
<!--                            <option-->
<!--                                v-for="(det,index) in challengeSelects.select_detail_destination"-->
<!--                                :value="det.value">{{ det.name }}-->
<!--                            </option>-->

<!--                        </TailSelect>-->
<!--                    </div>-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6" >-->
<!--                        <label for="input-wizard-9" class="form-label">-->
<!--                            {{$t('challengesNew.numberSupported')}}-->
<!--                        </label>-->
<!--                        <TailSelect-->
<!--                            id="input-wizard-9"-->
<!--                            v-model="select_number_of_lines"-->
<!--                            :options="{locale: 'pl', placeholder: 'Wybierz...', openAbove: false, animate: false, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"-->
<!--                        >-->
<!--                            <option selected disabled>{{$t('challengesNew.select')}}</option>-->
<!--                            <option-->
<!--                                v-for="(det,index) in challengeSelects.select_number_of_lines"-->
<!--                                :value="det.value">{{ det.name }}-->
<!--                            </option>-->

<!--                        </TailSelect>-->
<!--                    </div>-->
<!--                    <div class="intro-y col-span-12 sm:col-span-6">-->
<!--                        <label for="input-wizard-10" class="form-label">{{$t('challengesNew.changeNumber')}}</label>-->
<!--                        <Multiselect-->
<!--                            class="w-full h-8 z-50"-->
<!--                            v-model="select_work_shifts"-->
<!--                            mode="single"-->
<!--                            label="name"-->
<!--                            max="1"-->
<!--                            placeholder="Wybierz"-->
<!--                            valueProp="value"-->
<!--                            :options="challengeSelects.select_work_shifts"-->
<!--                        />-->


<!--                        &lt;!&ndash;                                                <TailSelect&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                    id="input-wizard-10"&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                    v-model="select_work_shifts"&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"&ndash;&gt;-->
<!--                        &lt;!&ndash;                                                >&ndash;&gt;-->


<!--                        &lt;!&ndash;                                                </TailSelect>&ndash;&gt;-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="mt-3">
        <label for="modal-form-3" class="form-label">Tytuł</label>
        <input
            id="modal-form-3"
            type="text"
            class="form-control"
            placeholder=""
            v-model="c.solution_deadline"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-4" class="form-label">Tytuł</label>
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

export default {
    name: "DescriptionDialog",
    props: {
        object: Object
    },
    setup(props, context) {
        const c = ref({description: '', name: ''});
        watch(c, (ca, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:comment", ca);
        }, {deep: true})
        onMounted(() => {
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
        });

        return {
            c
        }
    }
}
</script>

<style scoped>

</style>
