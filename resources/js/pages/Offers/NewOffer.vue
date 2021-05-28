<template>
    <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{$t('profiles.profile')}}
            </h2>
        </div>
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box mt-5">
                </div>
            </div>
            <!-- END: Profile Menu -->
            <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                <!-- BEGIN: Display Information -->
                <div class="intro-y box lg:mt-5">
                    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">
                            {{$t('profiles.personality')}}
                        </h2>
                    </div>
                        <div class="p-5">
                            <div class="flex flex-col-reverse xl:flex-row flex-col">
                                <div class="flex-1 mt-6 xl:mt-0">
                                    <div class="grid grid-cols-12 gap-x-5">
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-1" class="form-label">
                                                Cena za dostawę oraz uruchomienie stanowiska (netto)
                                            </label>
                                            <input type="number" class="form-control" v-model="price_of_delivery"/>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-2" class="form-label">
                                                Ilość tygodni do uruchomienia, liczona od podpisania umowy
                                            </label>
                                            <TailSelect
                                                id="input-wizard-2"
                                                v-model="weeks_to_start"
                                                :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                                <option  :selected="weeks_to_start === '' ? 'selected' : ''" disabled>Wybierz...</option>
                                                <option :selected="index === weeks_to_start ? 'selected' : ''" v-for="(det,index) in values['weeks']"
                                                        :value="index">{{ det }}
                                                </option>
                                            </TailSelect>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-3" class="form-label">
                                                Czas realizacji uruchomienia u klienta (tygodni)
                                            </label>
                                            <TailSelect
                                                id="input-wizard-3"
                                                v-model="time_to_start"
                                                :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                                <option  :selected="time_to_start === '' ? 'selected' : ''" disabled>Wybierz...</option>
                                                <option :selected="index === time_to_start ? 'selected' : ''" v-for="(det,index) in values['weeks-short']"
                                                        :value="index">{{ det }}
                                                </option>
                                            </TailSelect>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-4" class="form-label">
                                                Wysokość zaliczki (%) płatnej po podpisaniu umowy
                                            </label>
                                            <TailSelect
                                                id="input-wizard-4"
                                                v-model="advance_upon_agreement"
                                                :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                                <option  :selected="advance_upon_agreement === '' ? 'selected' : ''" disabled>Wybierz...</option>
                                                <option :selected="index === advance_upon_agreement ? 'selected' : ''" v-for="(det,index) in values['percent']"
                                                        :value="index">{{ det }}
                                                </option>
                                            </TailSelect>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-5" class="form-label">
                                                Wyskość zaliczki (%) płatnej przy odbiorze wstępnym dokonywanym u Integratora
                                            </label>
                                            <TailSelect
                                                id="input-wizard-5"
                                                v-model="advance_upon_delivery"
                                                :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                                <option  :selected="advance_upon_delivery === '' ? 'selected' : ''" disabled>Wybierz...</option>
                                                <option :selected="index === advance_upon_delivery ? 'selected' : ''" v-for="(det,index) in values['percent']"
                                                        :value="index">{{ det }}
                                                </option>
                                            </TailSelect>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-6" class="form-label">
                                                Wysokość zaliczki płatnej po uruchomieniu i finalnym odbiorze stanowiska
                                            </label>
                                            <TailSelect
                                                id="input-wizard-6"
                                                v-model="advance_upon_start"
                                                :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                                <option  :selected="advance_upon_start === '' ? 'selected' : ''" disabled>Wybierz...</option>
                                                <option :selected="index === advance_upon_start ? 'selected' : ''" v-for="(det,index) in values['percent']"
                                                        :value="index">{{ det }}
                                                </option>
                                            </TailSelect>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-6" class="form-label">
                                                Okres gwarancji w latach
                                            </label>
                                            <TailSelect
                                                id="input-wizard-6"
                                                v-model="years_of_guarantee"
                                                :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                                <option  :selected="years_of_guarantee === '' ? 'selected' : ''" disabled>Wybierz...</option>
                                                <option :selected="index === years_of_guarantee ? 'selected' : ''" v-for="(det,index) in values['years-short']"
                                                        :value="index">{{ det }}
                                                </option>
                                            </TailSelect>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-7" class="form-label">
                                                Częstotliwość przeglądów gwarancyjnych w roku
                                            </label>
                                            <input type="text" class="form-control" v-model="maintenance_frequency"/>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-8" class="form-label">
                                                Koszt roczny przeglądu gwaranycjnego
                                            </label>
                                            <input type="number" class="form-control" v-model="price_of_maintenance"/>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-9" class="form-label">
                                                Czas reakcji na zgłoszenie awarii w godzinach
                                            </label>
                                            <TailSelect
                                                id="input-wizard-9"
                                                v-model="reaction_time"
                                                :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                                <option  :selected="reaction_time === '' ? 'selected' : ''" disabled>Wybierz...</option>
                                                <option :selected="index === reaction_time ? 'selected' : ''" v-for="(det,index) in values['hours']"
                                                        :value="index">{{ det }}
                                                </option>
                                            </TailSelect>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-10" class="form-label">
                                                Czas przywrócenia stanowiska do sprawności po awarii
                                            </label>
                                            <TailSelect
                                                id="input-wizard-10"
                                                v-model="time_to_fix"
                                                :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                                                <option  :selected="time_to_fix === '' ? 'selected' : ''" disabled>Wybierz...</option>
                                                <option :selected="index === time_to_fix ? 'selected' : ''" v-for="(det,index) in values['hours']"
                                                        :value="index">{{ det }}
                                                </option>
                                            </TailSelect>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-11" class="form-label">
                                                Koszt interwencji w wypadku awarii nie podlegającej gwarancji
                                            </label>
                                            <input type="number" class="form-control" v-model="intervention_price"/>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-12" class="form-label">
                                                Koszt roboczo godziny pracy wsparcia / prac rozwojowych
                                            </label>
                                            <input type="number" class="form-control" v-model="work_hour_price"/>
                                        </div>
                                        <div class="intro-y col-span-12 sm:col-span-6">
                                            <label for="input-wizard-13" class="form-label">
                                                Okres wsparcia technicznego poza zakresem gwarancji w latach
                                            </label>
                                            <input type="text" class="form-control" v-model="period_of_support"/>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary w-20 mt-3" @click="save">{{$t('profiles.save')}}</button>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- END: Display Information -->
            </div>
        </div>
    </div>
</template>

<script>
import {ref} from "vue";

export default {
name: "NewOffer",
    setup(props) {
        const price_of_delivery = ref('');
        const weeks_to_start = ref('');
        const time_to_start = ref('');
        const advance_upon_agreement = ref('');
        const advance_upon_delivery = ref('');
        const advance_upon_start = ref('');
        const years_of_guarantee = ref('');
        const maintenance_frequency = ref('');
        const price_of_maintenance = ref('');
        const reaction_time = ref('');
        const time_to_fix = ref('');
        const intervention_price = ref('');
        const work_hour_price = ref('');
        const period_of_support = ref('');

        const values = require('../../json/offer_values.json');

        const save = () => {

        }

        return {
            price_of_delivery,
            weeks_to_start,
            time_to_fix,
            time_to_start,
            advance_upon_agreement,
            advance_upon_delivery,
            advance_upon_start,
            years_of_guarantee,
            maintenance_frequency,
            price_of_maintenance,
            reaction_time,
            intervention_price,
            work_hour_price,
            period_of_support,
            save,
            values
        }
    }
}
</script>

<style scoped>

</style>
