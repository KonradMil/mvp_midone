<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{ $t('solutions.newSolution') }}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button
                    type="button"
                    class="btn box text-gray-700 dark:text-gray-300 mr-2 flex items-center ml-auto sm:ml-0"
                >
                    <EyeIcon class="w-4 h-4 mr-2"/>
                    {{ $t('global.preview') }}
                </button>
                <button
                    class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                    aria-expanded="false"
                    @click="saveSolutionRepo"
                >
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
                            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz...',
                                limit: 'Nie można wybrać więcej',
                                search: false,
                                hideSelected: false,
                                classNames: 'w-full' }"
                        >
                            <option value="pl">PL</option>
                            <option value="en">ENG</option>

                        </TailSelect>
                    </div>
                    <input v-if="name_lang == 'pl'"
                        type="text"
                        class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13"
                        :placeholder="$t('global.name')"
                        v-model="name"
                    />
                    <input v-if="name_lang == 'en'"
                           type="text"
                           class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13"
                           :placeholder="$t('global.name')"
                           v-model="en_name"
                    />
                </div>

                <div class="post intro-y overflow-hidden box mt-5">
                    <div
                        class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600"
                        role="tablist"
                    >
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
                            @click="tab = 'desc'"
                        >
                            <FileTextIcon class="w-4 h-4 mr-2"/>
                            {{$t('challengesNew.description')}}                        </Tippy>
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
                            @click="tab = 'details'"
                        >
                            <CodeIcon class="w-4 h-4 mr-2"/>
                            {{ $t('global.preview') }}
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
                            @click="tab = 'financials'"
                        >
                            <CodeIcon class="w-4 h-4 mr-2"/>
                            {{ $t('global.financials') }}
                        </Tippy>
                    </div>
                    <div class="post__content tab-content">
                        <div
                            v-if="tab === 'desc'"
                            id="content"
                            class="tab-pane p-5 active"
                            role="tabpanel"
                            aria-labelledby="content-tab"
                        >
                            <div
                                class="border border-gray-200 dark:border-dark-5 rounded-md p-5"
                            >
                                <div
                                    class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"
                                >
                                    <div class="w-22 mr-3">
                                        <TailSelect
                                            id="input-wizard-2"
                                            v-model="description_lang"
                                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                        >
                                            <option value="pl">PL</option>
                                            <option value="en">ENG</option>
                                        </TailSelect>
                                    </div>
                                    {{$t('global.description')}}
                                </div>
                                <div class="mt-5">
                                    <textarea v-model="description" style="width: 100%;"></textarea>
                                </div>
                            </div>
                            <div
                                class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5"
                            >
                                <div
                                    class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"
                                >
                                    <ChevronDownIcon class="w-4 h-4 mr-2"/>
                                    {{ $t('challengesNew.photo') }}
                                </div>
                                <div class="mt-5">
                                    <div class="mt-3">
                                        <label class="form-label">{{ $t('challengesNew.uploadPhoto') }}</label>
                                        <div
                                            class="rounded-md pt-4"
                                        >
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
                                                    <div
                                                        class="px-4 py-4 flex items-center cursor-pointer relative"
                                                    >
                                                        <ImageIcon class="w-4 h-4 mr-2"/>
                                                        <span class="text-theme-1 dark:text-theme-10 mr-1"
                                                        >{{ $t('challengesNew.file') }}</span
                                                        >
                                                        {{ $t('challengesNew.fileUpload') }}
                                                    </div>
                                                </Dropzone>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="tab === 'details'"
                            id="content2"
                            class="tab-pane p-5 active"
                            role="tabpanel"
                            aria-labelledby="content-tab"
                        >
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
                                                    {{ $t('challengesNew.maxWeight') }}
                                                </label>
                                                <TailSelect
                                                    id="input-wizard-1"
                                                    v-model="select_detail_weight"
                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                                >
                                                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                                                    <option v-for="(det,index) in solutionSelects.select_detail_weight"
                                                            :value="det.value">{{ det.name }}
                                                    </option>

                                                </TailSelect>
                                            </div>
                                            <div class="intro-y col-span-12 sm:col-span-6">
                                                <label for="input-wizard-2" class="form-label">
                                                    {{ $t('challengesNew.quality') }}
                                                </label>
                                                <TailSelect
                                                    id="input-wizard-2"
                                                    v-model="select_pick_quality"
                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                                >
                                                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                                                    <option v-for="(det,index) in solutionSelects.select_pick_quality"
                                                            :value="det.value">{{ det.name }}
                                                    </option>

                                                </TailSelect>

                                            </div>
                                            <div class="intro-y col-span-12 sm:col-span-6">
                                                <label for="input-wizard-3" class="form-label">{{ $t('challengesNew.detail') }}</label>
                                                <TailSelect
                                                    id="input-wizard-3"
                                                    v-model="select_detail_material"
                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                                >
                                                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                                                    <option
                                                        v-for="(det,index) in solutionSelects.select_detail_material"
                                                        :value="det.value">{{ det.name }}
                                                    </option>

                                                </TailSelect>
                                            </div>
                                            <div class="intro-y col-span-12 sm:col-span-6">
                                                <label for="input-wizard-4" class="form-label">{{ $t('challengesNew.size') }}</label>
                                                <TailSelect
                                                    id="input-wizard-4"
                                                    v-model="select_detail_size"
                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                                >
                                                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                                                    <option v-for="(det,index) in solutionSelects.select_detail_size"
                                                            :value="det.value">{{ det.name }}
                                                    </option>

                                                </TailSelect>
                                            </div>
                                            <div class="intro-y col-span-12 sm:col-span-6">
                                                <label for="input-wizard-5" class="form-label">
                                                    {{ $t('challengesNew.way') }}
                                                    </label>
                                                <TailSelect
                                                    id="input-wizard-5"
                                                    v-model="select_detail_pick"
                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                                >
                                                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                                                    <option v-for="(det,index) in solutionSelects.select_detail_pick"
                                                            :value="det.value">{{ det.name }}
                                                    </option>

                                                </TailSelect>
                                            </div>
                                            <div class="intro-y col-span-12 sm:col-span-6">
                                                <label for="input-wizard-6" class="form-label">
                                                    {{ $t('challengesNew.position') }}
                                                </label>
                                                <TailSelect
                                                    id="input-wizard-6"
                                                    v-model="select_detail_position"
                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                                >
                                                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                                                    <option
                                                        v-for="(det,index) in solutionSelects.select_detail_position"
                                                        :value="det.value">{{ det.name }}
                                                    </option>

                                                </TailSelect>
                                            </div>
                                            <div class="intro-y col-span-12 sm:col-span-6">
                                                <label for="input-wizard-7" class="form-label">
                                                    {{ $t('challengesNew.distance') }}
                                                </label>
                                                <TailSelect
                                                    id="input-wizard-7"
                                                    v-model="select_detail_range"
                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                                >
                                                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                                                    <option v-for="(det,index) in solutionSelects.select_detail_range"
                                                            :value="det.value">{{ det.name }}
                                                    </option>

                                                </TailSelect>
                                            </div>
                                            <div class="intro-y col-span-12 sm:col-span-6">
                                                <label for="input-wizard-8" class="form-label">
                                                    {{ $t('challengesNew.place') }}
                                                </label>
                                                <TailSelect
                                                    id="input-wizard-8"
                                                    v-model="select_detail_destination"
                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                                >
                                                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                                                    <option
                                                        v-for="(det,index) in solutionSelects.select_detail_destination"
                                                        :value="det.value">{{ det.name }}
                                                    </option>

                                                </TailSelect>
                                            </div>
                                            <div class="intro-y col-span-12 sm:col-span-6">
                                                <label for="input-wizard-9" class="form-label">
                                                    {{ $t('challengesNew.numberSupported') }}
                                                </label>
                                                <TailSelect
                                                    id="input-wizard-9"
                                                    v-model="select_number_of_lines"
                                                    :options="{locale: 'pl', placeholder: 'Wybierz...', openAbove: true, animate: false, limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }"
                                                >
                                                    <option selected disabled>{{ $t('challengesNew.select') }}</option>
                                                    <option
                                                        v-for="(det,index) in solutionSelects.select_number_of_lines"
                                                        :value="det.value">{{ det.name }}
                                                    </option>

                                                </TailSelect>
                                            </div>
                                            <div class="intro-y col-span-12 sm:col-span-6">
                                                <label for="input-wizard-10" class="form-label">{{ $t('challengesNew.changeNumber') }}</label>
                                                <Multiselect
                                                    class="w-full h-8 z-50"
                                                    v-model="select_work_shifts"
                                                    mode="single"
                                                    label="name"
                                                    max="1"
                                                    :placeholder="$t('global.select')"
                                                    valueProp="value"
                                                    :options="solutionSelects.select_work_shifts"
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

                        </div>
                        <div
                            v-if="tab==='financials'"
                            class="intro-y box mt-5">
                            <div class="p-5" id="hoverable-table">
                                <div class="preview">
                                    <div class="overflow-x-auto">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Przed robotyzacją</th>
                                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Po robotyzacji</th>
                                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Różnica</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="hover:bg-gray-200">
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.days')}}
                                                    </label>
                                                    <input type="number" v-model="days" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.days')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="260,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr>
                                            <tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.shifts')}}
                                                    </label>
                                                    <input type="number" v-model="shifts" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.shifts')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr>
                                            <tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.shift_time')}}
                                                    </label>
                                                    <input type="number" v-model="shift_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.shift_time')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="8,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr>
                                            <tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.weekend_shift')}}
                                                    </label>
                                                    <input type="number" v-model="weekend_shift" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.weekend_shift')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr>
                                            <tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.breakfast')}}
                                                    </label>
                                                    <input type="number" v-model="breakfast" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.breakfast')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="30,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr>
                                            <tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.stop_time')}}
                                                    </label>
                                                    <input type="number" v-model="stop_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.stop_time')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="20,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr>
                                            <tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.operator_performance')}}
                                                    </label>
                                                    <input type="number" v-model="operator_performance" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.operator_performance')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="90,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr>
                                            <tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.defective')}}
                                                    </label>
                                                    <input type="number" v-model="defective" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.defective')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="5,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr>
                                            <tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.number_of_operators')}}
                                                    </label>
                                                    <input type="number" v-model="number_of_operators" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.number_of_operators')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="2,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr><tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.operator_cost')}}
                                                    </label>
                                                    <input type="number" v-model="operator_cost" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.operator_cost')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="4500,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr><tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.absence')}}
                                                    </label>
                                                    <input type="number" v-model="absence" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.absence')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="12,00" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr><tr class="hover:bg-gray-200">

                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.cycle_time')}}
                                                    </label>
                                                    <input type="number" v-model="cycle_time" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" />
                                                </td>
                                                <td class="border">
                                                    <label for="input-wizard-9" class="form-label">
                                                        {{$t('challengesNew.cycle_time')}}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="0" :aria-label="$t('challengesNew.numberSupported')" disabled/>
                                                </td>
                                                <td class="border">0</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="source-code hidden">
                                    <button data-target="#copy-hoverable-table" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
                                    <div class="overflow-y-auto mt-3 rounded-md">
                                        <pre class="source-preview" id="copy-hoverable-table"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTagdiv class=&quot;overflow-x-auto&quot;HTMLCloseTag HTMLOpenTagtable class=&quot;table&quot;HTMLCloseTag HTMLOpenTagtheadHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTag#HTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagFirst NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagLast NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagUsernameHTMLOpenTag/thHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/theadHTMLCloseTag HTMLOpenTagtbodyHTMLCloseTag HTMLOpenTagtr class=&quot;hover:bg-gray-200&quot;HTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag1HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagAngelinaHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagJolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag0HTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtr class=&quot;hover:bg-gray-200&quot;HTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag2HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagBradHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagPittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@bradpittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtr class=&quot;hover:bg-gray-200&quot;HTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag3HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagCharlieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagHunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@charliehunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/tbodyHTMLCloseTag HTMLOpenTag/tableHTMLCloseTag HTMLOpenTag/divHTMLCloseTag </code> </pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END: Post Content -->
            <!-- BEGIN: Post Info -->
            <div class="col-span-12 lg:col-span-4">
                <div class="intro-y box p-5">
                    <div>
                        <label class="form-label">{{ $t('challengesNew.teamAccess') }}</label>
                        <TailSelect
                            id="post-form-5"
                            v-model="teamsAllowed"
                            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz zespoły...',
                                limit: 'Nie można wybrać więcej',
                                 placeholderMulti: 'Wybierz do :limit zespołów...',
                search: false,
                hideSelected: true,
                hideDisabled: true,
                multiLimit: 15,
                multiShowCount: false,
                multiContainer: true,
                classNames: 'w-full'
              }"
                            multiple
                        >
                            <option selected disabled>{{ $t('challengesNew.tags') }}</option>
                            <option v-for="(team,index) in teams.list" :value="team.id">{{ team.name }}</option>
                        </TailSelect>
                    </div>
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
                  maxYear: null,
                  months: true,
                  years: true
                }
              }"
                            class="form-control"
                        />
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
                  maxYear: null,
                  months: true,
                  years: true
                }
              }"
                            class="form-control"
                        />
                    </div>
                    <div class="mt-3">
                        <label for="post-form-3" class="form-label">{{ $t('challengesNew.categories') }}</label>
                        <TailSelect
                            id="post-form-3"
                            v-model="category"
                            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz kategorie...',
                                limit: 'Nie można wybrać więcej',
                                search: false,
                                hideSelected: false,
                                classNames: 'w-full'
                                }">
                            <option selected disabled>Wybierz kategorie...</option>
                            <option v-for="(category,index) in categories" :value="index">{{ category }}</option>
                        </TailSelect>
                    </div>
                    <div class="mt-3">
                        <label for="post-form-4" class="form-label">{{ $t('challengesNew.tags') }}</label>
                        <TailSelect
                            id="post-form-4"
                            v-model="tagsSelected"
                            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz tagi...',
                                limit: 'Nie można wybrać więcej',
                                placeholderMulti: 'Wybierz do :limit tagów...',
                                search: false,
                                hideSelected: true,
                                hideDisabled: true,
                                multiLimit: 15,
                                multiShowCount: false,
                                multiContainer: true,
                                classNames: 'w-full'
                               }"
                            multiple
                        >
                            <option selected disabled>{{ $t('challengesNew.selectTags') }}</option>
                            <option v-for="(tag,index) in tags" :value="index">{{ tag }}</option>
                        </TailSelect>
                    </div>
                    <div class="form-check flex-col items-start mt-3">
                        <label for="post-form-5" class="form-check-label ml-0 mb-2"
                        >{{ $t('challengesNew.publish') }}</label
                        >
                        <input id="post-form-5" class="form-check-switch" v-model="publish" type="checkbox"/>
                    </div>
                    <div class="form-check flex-col items-start mt-3">
                        <label for="post-form-6" class="form-check-label ml-0 mb-2"
                        >{{ $t('challengesNew.acceptPublic')}}</label
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
import SaveSolution from "../../compositions/SaveSolution";
import { useI18n } from 'vue-i18n'
import Multiselect from '@vueform/multiselect'

const toast = useToast();

export default {
    name: "AddSolution",
    components: {Multiselect},
    setup() {
        const { t, locale } = useI18n({ useScope: 'global' })
        const toast = useToast();
        const category = ref();
        const showModal = ref(false);
        const tab = ref('desc');
        const categories = ref();
        const tags = ref();
        const tagsSelected = ref();
        const deadline_offered = ref("");
        const published_at = ref("");
        const solutionSelects = ref();
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
        const description_lang = ref(locale.value);
        const en_description = ref('');
        const name = ref('');
        const en_name = ref('');
        const name_lang = ref(locale.value);
        const allowed_publishing = ref(false);
        const publish = ref(false);
        const dropzoneSingleRef = ref();
        const types = require("../../json/types.json");
        const tagss = require("../../json/tagsSolution.json");
        const sels = require("../../json/solution.json");

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });
        const modalClosed = () => {
            showModal.value = false;
        }
        const getTeamsRepositories = async () => {
            teams.value = GetTeams();
        }

        const saveSolutionRepo = async () => {
            SaveSolution({
                name: name.value,
                description: description.value,
                type: category.value,
                deadline_offered: deadline_offered.value,
                published_at: published_at.value,
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

        onMounted(() => {
            categories.value = types;
            tags.value = tagss;
            solutionSelects.value = sels;
            const elDropzoneSingleRef = dropzoneSingleRef.value;

            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                images.value.push(JSON.parse(resp.xhr.response).payload);

            });
            elDropzoneSingleRef.dropzone.on("error", () => {
                toast.error("Błąd");
            });
            cash("body")
                .removeClass("error-page");
        });
        getTeamsRepositories();
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
            deadline_offered,
            published_at,
            tab,
            solutionSelects,
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
            modalClosed,
            showModal,
            images,
            saveSolutionRepo,
            name_lang,
            en_name,
            description_lang,
            en_description
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
