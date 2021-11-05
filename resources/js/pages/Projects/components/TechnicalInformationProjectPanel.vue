<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6" v-if="guard === true">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">{{ $t('challengesMain.technicalDetails') }}
                        <div v-if="challenge.stage === 3">
                            <div class="intro-y flex items-center justify-center text-theme-9 pt-2"
                                 v-if="project.accept_technical_details === 1 && stage === 3"><i
                                data-feather="check-square" class="w-4 h-4 mr-2"></i>{{ $t('challengesMain.accepted') }}
                            </div>
                            <div class="intro-y flex items-center justify-center text-theme-6 pt-2"
                                 v-if="project.accept_technical_details === 2 && stage === 3"><i
                                data-feather="check-square" class="w-4 h-4 mr-2"></i>{{ $t('challengesMain.rejected') }}
                            </div>
                            <div class="flex items-center mr-3 pt-2"
                                 v-if="project.accept_technical_details < 1 && stage === 3"><i
                                data-feather="check-square"
                                class="w-4 h-4 mr-2"></i>{{ $t('challengesMain.waitingApproval') }}
                            </div>
                        </div>
                    </h2>
                    <button
                        v-if="challenge.stage === 3 && challenge.selected[0].author_id === user.id && project.accept_technical_details !== 1 && project.accept_financial_details !== 1"
                        class="btn btn-primary w-20 mt-3" style="margin-top: 3px;"
                        @click.prevent="saveTechnicalDetails">{{ $t('profiles.save') }}
                    </button>
                    <button
                        v-if="challenge.author_id === user.id && challenge.stage === 3 && project.accept_technical_details !== 1 && project.accept_financial_details !== 1"
                        class="btn btn-primary mr-6" @click.prevent="acceptTechnicalDetails">Akceptuję
                    </button>
                    <button
                        v-if="challenge.author_id === user.id && challenge.stage === 3 && project.accept_technical_details !== 1 && project.accept_financial_details !== 1 && project.accept_technical_details !== 2"
                        class="btn btn-primary" @click.prevent="rejectTechnicalDetails">Odrzucam
                    </button>
                </div>
                <div class="px-5 py-5">
                    <div
                        id="latest-tasks-new"
                        class="tab-pane active"
                        role="tabpanel"
                        aria-labelledby="latest-tasks-new-tab"
                        v-if="challenge.technical_details != undefined"
                    >
                        <div
                            :class="(new_technical.detail_weight === old_technical.detail_weight && old_technical !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.detail_weight === old_technical.detail_weight && old_technical !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.maxWeight') }}:</span>
                                <div class=" dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_weight'][new_technical.detail_weight].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.detail_weight"
                                    :options="{locale: 'pl', placeholder: details.select_detail_weight[new_technical.detail_weight].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_detail_weight"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div
                            :class="(new_technical.pick_quality === old_technical.pick_quality) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.pick_quality === old_technical.pick_quality) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.quality') }}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_pick_quality'][new_technical.pick_quality].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.pick_quality"
                                    :options="{locale: 'pl', placeholder: details.select_pick_quality[new_technical.pick_quality].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_pick_quality"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div
                            :class="(new_technical.detail_material === old_technical.detail_material) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.detail_material === old_technical.detail_material) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.detail') }}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_material'][new_technical.detail_material].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.detail_material"
                                    :options="{locale: 'pl', placeholder: details.select_detail_material[new_technical.detail_material].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_detail_material"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div
                            :class="(new_technical.detail_size === old_technical.detail_size) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.detail_size === old_technical.detail_size) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.size') }}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_size'][new_technical.detail_size].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.detail_size"
                                    :options="{locale: 'pl', placeholder: details.select_detail_size[new_technical.detail_size].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_detail_size"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div
                            :class="(new_technical.detail_pick === old_technical.detail_pick) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.detail_pick === old_technical.detail_pick) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.way') }}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_pick'][new_technical.detail_pick].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.detail_pick"
                                    :options="{locale: 'pl', placeholder: details.select_detail_pick[new_technical.detail_pick].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_detail_pick"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div
                            :class="(new_technical.detail_position === old_technical.detail_position) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.detail_position === old_technical.detail_position) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.position') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_position'][new_technical.detail_position].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.detail_position"
                                    :options="{locale: 'pl', placeholder: details.select_detail_position[new_technical.detail_position].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_detail_position"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div
                            :class="(new_technical.detail_range === old_technical.detail_range) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.detail_range === old_technical.detail_range) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.distance') }}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_range'][new_technical.detail_range].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.detail_range"
                                    :options="{locale: 'pl', placeholder: details.select_detail_range[new_technical.detail_range].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_detail_range"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div
                            :class="(new_technical.detail_destination === old_technical.detail_destination) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.detail_destination === old_technical.detail_destination) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.place') }}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_detail_destination'][new_technical.detail_destination].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.detail_destination"
                                    :options="{locale: 'pl', placeholder: details.select_detail_destination[new_technical.detail_destination].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_detail_destination"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div
                            :class="(new_technical.number_of_lines === old_technical.number_of_lines) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.number_of_lines === old_technical.number_of_lines) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span
                                    class="font-medium text-gray-600">{{ $t('challengesNew.numberSupported') }}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_technical.number_of_lines }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.number_of_lines"
                                    :options="{locale: 'pl', placeholder: details.select_number_of_lines[new_technical.number_of_lines].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_number_of_lines"
                                            :value="det.value">
                                        {{ det.name }}
                                    </option>
                                </TailSelect>
                            </div>
                        </div>
                        <div
                            :class="(new_technical.work_shifts === old_technical.work_shifts) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_technical.work_shifts === old_technical.work_shifts) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.changeNumber') }}:</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ details['select_work_shifts'][new_technical.work_shifts].name }}
                                </div>
                                <TailSelect
                                    v-if="stage === 3"
                                    id="input-wizard-1"
                                    v-model="new_technical.work_shifts"
                                    :options="{locale: 'pl', placeholder: details.select_work_shifts[new_technical.work_shifts].name, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                    <option selected disabled>Wybierz...</option>
                                    <option :disabled="challenge.selected[0].author_id !== user.id"
                                            v-for="(det,index) in details.select_work_shifts"
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
                    <h2 class="font-medium text-base mr-auto">{{ $t('challengesMain.financialDetails') }}
                        <div v-if="challenge.stage === 3">
                            <div class="intro-y flex items-center justify-center text-theme-9 pt-2"
                                 v-if="project.accept_financial_details === 1 && stage === 3"><i
                                data-feather="check-square" class="w-4 h-4 mr-2"></i>{{ $t('challengesMain.accepted') }}
                            </div>
                            <div class="intro-y flex items-center justify-center text-theme-6 pt-2"
                                 v-if="project.accept_financial_details === 2 && stage === 3"><i
                                data-feather="check-square" class="w-4 h-4 mr-2"></i>{{ $t('challengesMain.rejected') }}
                            </div>
                            <div class="flex items-center mr-3 pt-2"
                                 v-if="project.accept_financial_details < 1 && stage === 3"><i
                                data-feather="check-square"
                                class="w-4 h-4 mr-2"></i>{{ $t('challengesMain.waitingApproval') }}
                            </div>
                        </div>
                    </h2>
                    <button
                        v-if="stage === 3 && challenge.selected[0].author_id === user.id && project.accept_financial_details !== 1"
                        class="btn btn-primary w-20 mt-3" style="margin-top: 3px;"
                        @click.prevent="saveFinancialDetails">{{ $t('profiles.save') }}
                    </button>
                    <button
                        v-if="challenge.author_id === user.id && stage === 3 && project.accept_financial_details !== 1"
                        class="btn btn-primary mr-6" @click.prevent="acceptFinancialDetails">Akceptuję
                    </button>
                    <button
                        v-if="challenge.author_id === user.id && stage === 3 && project.accept_financial_details !== 1 && project.accept_financial_details !== 2"
                        class="btn btn-primary" @click.prevent="rejectFinancialDetails">Odrzucam
                    </button>
                </div>
                <div class="px-5 py-5">
                    <div
                        id="latest-tasks-new2"
                        class="tab-pane active"
                        role="tabpanel"
                        aria-labelledby="latest-tasks-new-tab"
                        v-if="challenge.financial_before != undefined"
                    >
                        <div
                            :class="(new_financial.days === old_financial.days && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.days === old_financial.days && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.days') }}</span>
                                <div class=" dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.days }} dni
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       @input="checkLength(new_financial.days, 'days')"
                                       type="number"
                                       v-model="new_financial.days"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.shifts === old_financial.shifts && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.shifts === old_financial.shifts && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.shifts') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.shifts }} zmian
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.shifts, 'shifts')"
                                       v-model="new_financial.shifts "
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.shift_time === old_financial.shift_time && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.shift_time === old_financial.shift_time && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.shift_time') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.shift_time }} godzin
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.shift_time, 'shiftTime')"
                                       v-model="new_financial.shift_time"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.weekend_shift === old_financial.weekend_shift && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.weekend_shift=== old_financial.weekend_shift && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.weekend_shift') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.weekend_shift }} zmian
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.weekend_shift, 'weekendShift')"
                                       v-model="new_financial.weekend_shift"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.breakfast === old_financial.breakfast && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.breakfast === old_financial.breakfast && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600"> {{ $t('challengesNew.breakfast') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.breakfast }} minut
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.breakfast, 'breakfast')"
                                       v-model="new_financial.breakfast "
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.stop_time === old_financial.stop_time && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.stop_time === old_financial.stop_time && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600"> {{ $t('challengesNew.stop_time') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.stop_time }} minut
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.stop_time, 'stopTime')"
                                       v-model="new_financial.stop_time"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.operator_performance === old_financial.operator_performance && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.operator_performance === old_financial.operator_performance && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span
                                    class="font-medium text-gray-600">{{ $t('challengesNew.operator_performance') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.operator_performance }}%
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.operator_performance, 'operatorPerformance')"
                                       v-model="new_financial.operator_performance"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.defective === old_financial.defective && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.defective === old_financial.defective && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.defective') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.defective }}%
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.defective, 'defective')"
                                       v-model="new_financial.defective"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.number_of_operators === old_financial.number_of_operators && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.number_of_operators === old_financial.number_of_operators && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span
                                    class="font-medium text-gray-600">{{ $t('challengesNew.number_of_operators') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.number_of_operators }} operatorów
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.number_of_operators, 'numberOfOperators')"
                                       v-model="new_financial.number_of_operators"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.operator_cost === old_financial.operator_cost && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.operator_cost === old_financial.operator_cost && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.operator_cost') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.operator_cost }}zł
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.operator_cost, 'operatorCost')"
                                       v-model="new_financial.operator_cost"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.absence === old_financial.absence && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.absence === old_financial.absence && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.absence') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.absence }}%
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.absence, 'absence')"
                                       v-model="new_financial.absence"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div
                            :class="(new_financial.cycle_time === old_financial.cycle_time && old_financial !== undefined) ? 'flex items-center mb-5' : 'flex items center border border-theme-1 pt-2 pb-2 mb-5'">
                            <div
                                :class="(new_financial.cycle_time === old_financial.cycle_time && old_financial !== undefined) ? 'border-l-2 border-theme-1 pl-4' : 'pl-4'">
                                <span class="font-medium text-gray-600">{{ $t('challengesNew.cycle_time') }}</span>
                                <div class="dark:text-theme-10 text-theme-1" v-if="stage !== 3">
                                    {{ new_financial.cycle_time }}s
                                </div>
                                <input :disabled="challenge.selected[0].author_id !== user.id"
                                       v-if="stage === 3"
                                       type="number"
                                       @input="checkLength(new_financial.cycle_time, 'cycleTime')"
                                       v-model="new_financial.cycle_time"
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
import {computed, getCurrentInstance, onBeforeMount, onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
import UnityBridgeWorkshop from "../../Unity/Workshop/bridge_workshop";
import router from "../../../router";
import RequestHandler from "../../../compositions/RequestHandler";

export default {
    name: "TechnicalInformationProjectPanel",
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
        const guard = ref(false);
        const error = ref(null);
        const old_technical = ref({});
        const new_technical = ref({});
        const old_financial = ref({});
        const new_financial = ref({});
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
        const example = ref({});


        const saveTechnicalDetails = async () => {
            RequestHandler('projects/' + props.challenge.id + '/technical-details/save', 'post', {
                detail_weight: new_technical.value.detail_weight,
                pick_quality: new_technical.value.pick_quality,
                detail_material: new_technical.value.detail_material,
                detail_size: new_technical.value.detail_size,
                detail_pick: new_technical.value.detail_pick,
                detail_position: new_technical.value.detail_position,
                detail_range: new_technical.value.detail_range,
                detail_destination: new_technical.value.detail_destination,
                number_of_lines: new_technical.value.number_of_lines,
                work_shifts: new_technical.value.work_shifts,
            }, (response) => {
                getNewTechnical();
            });
        }

        const saveFinancialDetails = async () => {
            RequestHandler('projects/' + props.challenge.id + '/financial-details/save', 'post', {
                days: new_financial.value.days,
                shifts: new_financial.value.shifts,
                shift_time: new_financial.value.shift_time,
                weekend_shift: new_financial.value.weekend_shift,
                breakfast: new_financial.value.breakfast,
                stop_time: new_financial.value.stop_time,
                operator_performance: new_financial.value.operator_performance,
                defective: new_financial.value.defective,
                number_of_operators: new_financial.value.number_of_operators,
                operator_cost: new_financial.value.operator_cost,
                absence: new_financial.value.absence,
                cycle_time: new_financial.value.cycle_time,
            }, (response) => {
                getNewFinancial();
            });
        }

        const acceptTechnicalDetails = async () => {
            RequestHandler('projects/' + props.project.id + '/technical-details/accept', 'post', {}, (response) => {
                props.project.accept_technical_details = 1;
                emitter.emit('acceptTechnicalDetails', {});
            });
        }
        const rejectTechnicalDetails = async () => {
            RequestHandler('projects/' + props.project.id + '/technical-details/reject', 'post', {}, (response) => {
                props.project.accept_technical_details = 2;
                emitter.emit('rejectDetails', {});
            });
        }

        const acceptFinancialDetails = async () => {
            RequestHandler('projects/' + props.project.id + '/financial-details/accept', 'post', {}, (response) => {
                props.project.accept_financial_details = 1;
                emitter.emit('acceptFinancialDetails', {});
            });
        }

        const rejectFinancialDetails = async () => {
            RequestHandler('projects/' + props.project.id + '/financial-details/reject', 'post', {}, (response) => {
                props.project.accept_financial_details = 2;
                emitter.emit('rejectDetails', {});
            });
        }

        const getNewTechnical = async (callback) => {
            RequestHandler('projects/' + props.challenge.id + '/technical-details', 'get', {}, (response) => {
                old_technical.value = response.data.old_technical,
                new_technical.value = response.data.new_technical,
                callback(response);
            });
        }
        const getNewFinancial = async (callback) => {
            RequestHandler('projects/' + props.challenge.id + '/financial-details', 'get', {}, (response) => {
                old_financial.value = response.data.old_financial,
                new_financial.value = response.data.new_financial,
                callback(response);
            });
        }

        const checkLength = (object, type) => {
            if(type === 'days'){
                if(object < 0){
                    new_financial.value.days = 0;
                }else if(object > 366){
                    new_financial.value.days = 366;
                }
            } else if(type === 'shifts'){
                if(object < 0){
                    new_financial.value.shifts = 0;
                }else if(object > 10){
                    new_financial.value.shifts = 10;
                }
            } else if(type === 'weekendShift'){
                if(object < 0){
                    new_financial.value.weekend_shift = 0;
                }else if(object > 10){
                    new_financial.value.weekend_shift = 10;
                }
            }else if(type === 'shiftTime'){
                if(object < 0){
                    new_financial.value.shift_time = 0;
                }else if(object > 24){
                    new_financial.value.shift_time = 24;
                }
            } else if(type === 'breakfast'){
                if(object < 0){
                    new_financial.value.breakfast = 0;
                }else if(object > 60){
                    new_financial.value.breakfast = 60;
                }
            } else if(type === 'stopTime'){
                if(object < 0){
                    new_financial.value.stop_time = 0;
                }else if(object > 100){
                    new_financial.value.stop_time = 100;
                }
            } else if(type === 'operatorPerformance'){
                if(object < 0){
                    new_financial.value.operator_performance = 0;
                }else if(object > 100){
                    new_financial.value.operator_performance = 100;
                }
            } else if(type === 'defective') {
                if(object < 0){
                    new_financial.value.defective = 0;
                }else if(object > 100){
                    new_financial.value.defective = 100;
                }
            } else if(type === 'numberOfOperators'){
                if(object < 0){
                    new_financial.value.number_of_operators = 0;
                }else if(object > 1000){
                    new_financial.value.number_of_operators = 1000;
                }
            } else if(type === 'operatorCost'){
                if(object < 0){
                    new_financial.value.operator_cost = 0;
                }
            } else if(type === 'absence'){
                if(object < 0){
                    new_financial.value.absence = 0;
                } else if(object > 100){
                    new_financial.value.absence = 100;
                }
            } else if(type === 'cycleTime'){
                if(object < 0){
                    new_financial.value.cycle_time = 0;
                } else if(object > 60){
                    new_financial.value.cycle_time = 60;
                }
            }

        }


        onMounted(() => {
            getNewTechnical((response) => {
                guard.value = true;
            });
            getNewFinancial((response) => {

            });

        });

        return {
            checkLength,
            error,
            guard,
            example,
            old_technical,
            new_technical,
            old_financial,
            new_financial,
            user,
            saveTechnicalDetails,
            saveFinancialDetails,
            challenge,
            details,
            acceptTechnicalDetails,
            acceptFinancialDetails,
            rejectTechnicalDetails,
            rejectFinancialDetails
        }
    }
}
</script>

<style scoped>

</style>
