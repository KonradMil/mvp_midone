<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9 p-5">
        <div class="flex flex-col-reverse xl:flex-row flex-col">
            <div class="flex-1 mt-6 xl:mt-0">
                <div class="grid grid-cols-12 gap-x-5">
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-1" class="form-label">
                            Cena za dostawę oraz uruchomienie stanowiska (netto)
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" v-model="price_of_delivery"/>
                            <div id="input-group-price4" class="input-group-text">zł</div>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-2" class="form-label">
                            Ilość tygodni do uruchomienia, liczona od podpisania umowy
                        </label>
                        <TailSelect
                            id="input-wizard-2"
                            v-model="weeks_to_start"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in values['weeks']"
                                    :value="index">{{ det }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-3" class="form-label">
                            Czas realizacji uruchomienia u klienta (tygodni)
                        </label>
                        <TailSelect
                            id="input-wizard-3"
                            v-model="time_to_start"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in values['weeks-short']"
                                    :value="index">{{ det }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-4" class="form-label">
                            Wysokość zaliczki (%) płatnej po podpisaniu umowy
                        </label>
                        <TailSelect
                            id="input-wizard-4"
                            v-model="advance_upon_agreement"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in values['percent']"
                                    :value="index">{{ det }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-5" class="form-label">
                            Wyskość zaliczki (%) płatnej przy odbiorze wstępnym dokonywanym u Integratora
                        </label>
                        <TailSelect
                            id="input-wizard-5"
                            v-model="advance_upon_delivery"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in values['percent']"
                                    :value="index">{{ det }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-6" class="form-label">
                            Wysokość zaliczki płatnej po uruchomieniu i finalnym odbiorze stanowiska
                        </label>
                        <TailSelect
                            id="input-wizard-6"
                            v-model="advance_upon_start"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in values['percent']"
                                    :value="index">{{ det }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-6" class="form-label">
                            Okres gwarancji w latach
                        </label>
                        <TailSelect
                            id="input-wizard-6"
                            v-model="years_of_guarantee"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in values['years-short']"
                                    :value="index">{{ det }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-7" class="form-label">
                            Częstotliwość przeglądów gwarancyjnych w roku
                        </label>
                        <input type="text" class="form-control" v-model="maintenance_frequency"/>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-8" class="form-label">
                            Koszt roczny przeglądu gwaranycjnego
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" v-model="price_of_maintenance"/>
                            <div id="input-group-price5" class="input-group-text">zł</div>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-9" class="form-label">
                            Czas reakcji na zgłoszenie awarii w godzinach
                        </label>
                        <TailSelect
                            id="input-wizard-9"
                            v-model="reaction_time"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in values['hours']"
                                    :value="index">{{ det }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-10" class="form-label">
                            Czas przywrócenia stanowiska do sprawności po awarii
                        </label>
                        <TailSelect
                            id="input-wizard-10"
                            v-model="time_to_fix"
                            :options="{locale: 'pl', placeholder: 'Wybierz...', limit: 'Nie można wybrać więcej', search: false, hideSelected: false, classNames: 'w-full' }">
                            <option selected disabled>Wybierz...</option>
                            <option v-for="(det,index) in values['hours']"
                                    :value="index">{{ det }}
                            </option>
                        </TailSelect>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-11" class="form-label">
                            Koszt interwencji w wypadku awarii nie podlegającej gwarancji
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" v-model="intervention_price"/>
                            <div id="input-group-price3" class="input-group-text">zł</div>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-12" class="form-label">
                            Koszt roboczo godziny pracy wsparcia / prac rozwojowych
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" v-model="work_hour_price"/>
                            <div id="input-group-price2" class="input-group-text">zł</div>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-13" class="form-label">
                            Okres wsparcia technicznego poza zakresem gwarancji w latach
                        </label>
                        <input type="text" class="form-control" v-model="period_of_support"/>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">
                        <label for="input-wizard-13" class="form-label">
                          Okres ważności oferty w dniach
                        </label>
                        <input type="number" class="form-control" v-model="offer_expires_in"/>
                    </div>
                </div>
                <button class="btn btn-primary w-20 mt-3" @click="save">{{ $t('profiles.save') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import {useToast} from "vue-toastification";

export default {
    name: "OfferAdd",
    props: {
        solution_id: Number,
        offer_id: Number,
        challenge_id: Number
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const price_of_delivery = ref(0);
        const weeks_to_start = ref(0);
        const time_to_start = ref(0);
        const advance_upon_agreement = ref(0);
        const advance_upon_delivery = ref(0);
        const advance_upon_start = ref(0);
        const years_of_guarantee = ref(0);
        const maintenance_frequency = ref('');
        const price_of_maintenance = ref(0);
        const reaction_time = ref(0);
        const time_to_fix = ref(0);
        const intervention_price = ref(0);
        const work_hour_price = ref(0);
        const offer_expires_in = ref(30);
        const period_of_support = ref('');

        const toast = useToast();
        const values = require('../../../json/offer_values.json');

        emitter.on('offerSelected', e => () => {
            getOffer(e.offer_id);
        });

        emitter.on('changeToOfferAdd', e => () => {
            getOffer(e.id);
        });

        const save = () => {
            axios.post('/api/offer/save', {
                id: props.offer_id,
                challenge_id: props.challenge_id,
                solution_id: props.solution_id,
                price_of_delivery: price_of_delivery.value,
                weeks_to_start: weeks_to_start.value,
                time_to_start: time_to_start.value,
                time_to_fix: time_to_fix.value,
                advance_upon_start: advance_upon_start.value,
                advance_upon_delivery: advance_upon_delivery.value,
                advance_upon_agreement: advance_upon_agreement.value,
                years_of_guarantee: years_of_guarantee.value,
                maintenance_frequency: maintenance_frequency.value,
                price_of_maintenance: price_of_maintenance.value,
                reaction_time: reaction_time.value,
                intervention_price: intervention_price.value,
                work_hour_price: work_hour_price.value,
                period_of_support: period_of_support.value,
                offer_expires_in: offer_expires_in.value
            }).then(response => {
                if (response.data.success) {
                    console.log(response.data + '-> OFFER SAVE !!');
                    console.log(advance_upon_delivery.value + '-> delivery');
                    toast.success(response.data.message);
                    emitter.emit('changeToOffers', {action: 'go'});
                } else {
                    toast.error('Ups! Coś poszło nie tak!');
                }
            })
        }

        onMounted(() => {
            if (props.offer_id != undefined) {
                getOffer();
            }
        });

        const getOffer = (val = 0) => {
            let c = props.offer_id;
            if (val != 0) {
                c = val;
            }
            axios.post('/api/offer/get', {id: c})
                .then(response => {
                    if (response.data.success) {
                        price_of_delivery.value = response.data.payload.price_of_delivery;
                        weeks_to_start.value = response.data.payload.weeks_to_start;
                        time_to_start.value = response.data.payload.time_to_start;
                        time_to_fix.value = response.data.payload.time_to_fix;
                        advance_upon_start.value = response.data.payload.advance_upon_start;
                        advance_upon_delivery.value = response.data.payload.advance_upon_delivery;
                        advance_upon_agreement.value = response.data.payload.advance_upon_agreement;
                        years_of_guarantee.value = response.data.payload.years_of_guarantee;
                        maintenance_frequency.value = response.data.payload.maintenance_frequency;
                        price_of_maintenance.value = response.data.payload.price_of_maintenance;
                        reaction_time.value = response.data.payload.reaction_time;
                        intervention_price.value = response.data.payload.intervention_price;
                        work_hour_price.value = response.data.payload.work_hour_price;
                        period_of_support.value = response.data.payload.period_of_support;
                        offer_expires_in.value = response.data.payload.offer_expires_in;
                    } else {
                        toast.error('Ups! Coś poszło nie tak!');
                    }
                })
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
            values,
            offer_expires_in
        }
    }
}
</script>

<style scoped>

</style>
