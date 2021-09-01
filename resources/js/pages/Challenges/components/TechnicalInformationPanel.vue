<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">{{$t('challengesMain.technicalDetails')}}</h2>
                    <div class="flex items-center justify-center text-theme-9" v-if="project.project_accept_details === 1 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.accepted')}}</div>
                    <div class="flex items-center justify-center text-theme-6" v-if="project.project_accept_details === 2 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.rejected')}}</div>
                    <div class="flex items-center mr-3" v-if="project.project_accept_details < 1 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.waitingApproval')}}</div>
                    <button v-if="stage === 3 && author_id === user.id" class="btn btn-primary w-20 mt-3" style="margin-top: 3px;" @click.prevent="saveTechnicalDetails">{{$t('profiles.save')}}</button>
                    <button v-if="challenge.author_id === user.id && stage === 3" class="btn btn-primary" @click.prevent="acceptTechnicalDetails">Akceptuje zmiany</button>
                    <button v-if="challenge.author_id === user.id && stage === 3" class="btn btn-primary" @click.prevent="rejectTechnicalDetails">Odrzucam zmiany</button>
                </div>
                <div class="px-5 py-5">
                    <div
                        id="latest-tasks-new"
                        class="tab-pane active"
                        role="tabpanel"
                        aria-labelledby="latest-tasks-new-tab"
                        v-if="challenge.technical_details != undefined"
                    >
                        <div class="flex items-center">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.maxWeight')}}:</span>
                                <div class=" dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_weight'][challenge.technical_details.detail_weight].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.detail_weight"
                                    :options="{locale: 'pl', placeholder: details.select_detail_weight[challenge.technical_details.detail_weight].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_detail_weight"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.quality')}}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_pick_quality'][challenge.technical_details.pick_quality].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.pick_quality"
                                    :options="{locale: 'pl', placeholder: details.select_pick_quality[challenge.technical_details.pick_quality].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_pick_quality"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.detail')}}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_material'][challenge.technical_details.detail_material].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.detail_material"
                                    :options="{locale: 'pl', placeholder: details.select_detail_material[challenge.technical_details.detail_material].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_detail_material"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.size')}}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_size'][challenge.technical_details.detail_size].name}}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.detail_size"
                                    :options="{locale: 'pl', placeholder: details.select_detail_size[challenge.technical_details.detail_size].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_detail_size"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.way')}}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_pick'][challenge.technical_details.detail_pick].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.detail_pick"
                                    :options="{locale: 'pl', placeholder: details.select_detail_pick[challenge.technical_details.detail_pick].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_detail_pick"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.position')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_position'][challenge.technical_details.detail_position].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.detail_position"
                                    :options="{locale: 'pl', placeholder: details.select_detail_position[challenge.technical_details.detail_position].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_detail_position"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.distance')}}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_range'][challenge.technical_details.detail_range].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.detail_range"
                                    :options="{locale: 'pl', placeholder: details.select_detail_range[challenge.technical_details.detail_range].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_detail_range"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.place')}}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_destination'][challenge.technical_details.detail_destination].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.detail_destination"
                                    :options="{locale: 'pl', placeholder: details.select_detail_destination[challenge.technical_details.detail_destination].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_detail_destination"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.numberSupported')}}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{challenge.technical_details.number_of_lines }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.number_of_lines"
                                    :options="{locale: 'pl', placeholder: details.select_number_of_lines[challenge.technical_details.number_of_lines].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_number_of_lines"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.changeNumber')}}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_work_shifts'][challenge.technical_details.work_shifts].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="challenge.technical_details.work_shifts"
                                    :options="{locale: 'pl', placeholder: details.select_work_shifts[challenge.technical_details.work_shifts].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option v-for="(det,index) in details.select_work_shifts"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Announcement -->
            <!-- BEGIN: Daily Sales -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">{{$t('challengesMain.financialDetails')}}
                        <div class="flex items-center justify-center text-theme-9" v-if="project.project_accept_details === 1 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.accepted')}}</div>
                        <div class="flex items-center justify-center text-theme-6" v-if="project.project_accept_details === 2 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.rejected')}}</div>
                        <div class="flex items-center mr-3" v-if="project.project_accept_details < 1 && stage === 3"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.waitingApproval')}}</div>
                    </h2>
                    <button v-if="stage === 3 && author_id === user.id" class="btn btn-primary w-20 mt-3" style="margin-top: 3px;" @click.prevent="saveFinancialDetails">{{$t('profiles.save')}}</button>
                    <button v-if="challenge.author_id === user.id && stage === 3" class="btn btn-primary mr-6" @click.prevent="acceptFinancialDetails">Akceptuje zmiany</button>
                    <button v-if="challenge.author_id === user.id && stage === 3" class="btn btn-primary" @click.prevent="rejectFinancialDetails">Odrzucam zmiany</button>
                </div>
                <div class="px-5 py-5">
                    <div
                        id="latest-tasks-new2"
                        class="tab-pane active"
                        role="tabpanel"
                        aria-labelledby="latest-tasks-new-tab"
                        v-if="challenge.financial_before != undefined"
                    >
                        <div class="flex items-center">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.days')}}</span>
                                <div class=" dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.days }} dni
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.days"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.shifts')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{challenge.financial_before.shifts }} zmian
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.shifts"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.shift_time')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.shift_time }} godzin
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.shift_time"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.weekend_shift')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.weekend_shift }} zmian
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.weekend_shift"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600"> {{$t('challengesNew.breakfast')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.breakfast }} minut
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.breakfast"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600"> {{$t('challengesNew.stop_time')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.stop_time }} minut
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.stop_time"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.operator_performance')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.operator_performance }}%
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.operator_performance"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.defective')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.defective }}%
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.defective"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.number_of_operators')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.number_of_operators }} operatorów
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.number_of_operators"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.operator_cost')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.operator_cost }}zł
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.operator_cost"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.absence')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.absence }}%
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.absence"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium text-gray-600">{{$t('challengesNew.cycle_time')}}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ challenge.financial_before.cycle_time }}s
                                </div>
                                <input v-if="stage === 3"
                                       type="number"
                                       v-model="challenge.financial_before.cycle_time"
                                       class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Daily Sales -->
        </div>
    </div>
</template>

<script>
import {computed, getCurrentInstance, onMounted, ref} from "vue";
import {useToast} from "vue-toastification";

export default {
    name: "TechnicalInformationPanel",
    props: {
        challenge: Object,
        stage: Number,
        author_id: Number,
        project: Object
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const challenge = computed(() => {
            return props.challenge;
        });
        const details = require("../../../json/challenge.json");
        const toast = useToast();
        const user = window.Laravel.user;
        const challenge_details = ref({
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

        const saveTechnicalDetails = async () => {
            axios.post('/api/projects/technical-details/save', {
                id: props.challenge.technical_details.id,
                detail_weight: props.challenge.technical_details.detail_weight,
                pick_quality: props.challenge.technical_details.pick_quality,
                detail_material: props.challenge.technical_details.detail_material,
                detail_size: props.challenge.technical_details.detail_size,
                detail_pick: props.challenge.technical_details.detail_pick,
                detail_position: props.challenge.technical_details.detail_position,
                detail_range: props.challenge.technical_details.detail_range,
                detail_destination: props.challenge.technical_details.detail_destination,
                number_of_lines: props.challenge.technical_details.number_of_lines,
                work_shifts: props.challenge.technical_details.work_shifts,
            })
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zapisano poprawnie');
                    } else {

                    }
                })
        }

        const saveFinancialDetails = async () => {
            axios.post('/api/projects/financial-details/save', {
                id: props.challenge.financial_before.id,
                days: props.challenge.financial_before.days,
                shifts: props.challenge.financial_before.shifts,
                shift_time: props.challenge.financial_before.shift_time,
                weekend_shift: props.challenge.financial_before.weekend_shift,
                breakfast: props.challenge.financial_before.breakfast,
                stop_time: props.challenge.financial_before.stop_time,
                operator_performance: props.challenge.financial_before.operator_performance,
                defective: props.challenge.financial_before.defective,
                number_of_operators: props.challenge.financial_before.number_of_operators,
                operator_cost: props.challenge.financial_before.operator_cost,
                absence: props.challenge.financial_before.absence,
                cycle_time: props.challenge.financial_before.cycle_time,
            })
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zapisano poprawnie');
                    } else {

                    }
                })
        }

        const acceptTechnicalDetails = async () => {
            axios.post('/api/projects/technical-details/accept', {id: props.challenge.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zapisano poprawnie');
                        emitter.emit('acceptDetails', {});
                    } else {

                    }
                })
        }

        const acceptFinancialDetails = async () => {
            axios.post('/api/projects/financial-details/accept', {id: props.challenge.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zapisano poprawnie');
                        emitter.emit('acceptDetails', {});
                    } else {

                    }
                })
        }

        onMounted(() => {

        });

        return {
            user,
            saveTechnicalDetails,
            saveFinancialDetails,
            challenge,
            details,
            acceptTechnicalDetails,
            acceptFinancialDetails
        }
    }
}
</script>

<style scoped>

</style>
