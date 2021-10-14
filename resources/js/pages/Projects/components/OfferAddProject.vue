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
                            <option :selected="weeks_to_start === '' ? 'selected' : ''" disabled>Wybierz...</option>
                            <option :selected="index === weeks_to_start ? 'selected' : ''" v-for="(det,index) in values['weeks']"
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
                            <option  :selected="time_to_start === '' ? 'selected' : ''" disabled>Wybierz...</option>
                            <option :selected="index === time_to_start ? '' : 'selected'" v-for="(det,index) in values['weeks-short']" :data-det="det" :data-index="index" :data-jeden="time_to_start"
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
                            <option :selected="advance_upon_agreement === '' ? 'selected' : ''" disabled>Wybierz...</option>
                            <option :selected="index === advance_upon_agreement ? '' : 'selected'" v-for="(det,index) in values['percent']" :data-det="det" :data-index="index" :data-jeden="advance_upon_agreement"
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
                            <option :selected="advance_upon_delivery === '' ? 'selected' : ''" disabled>Wybierz...</option>
                            <option :selected="index === advance_upon_delivery ? 'selected' : ''" v-for="(det,index) in values['percent']"
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
                            <option :selected="advance_upon_start === '' ? 'selected' : ''" disabled>Wybierz...</option>
                            <option :selected="index === advance_upon_start ? 'selected' : ''" v-for="(det,index) in values['percent']"
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
                            <option :selected="years_of_guarantee === '' ? 'selected' : ''" disabled>Wybierz...</option>
                            <option :selected="index === years_of_guarantee ? 'selected' : ''" v-for="(det,index) in values['years-short']"
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
                            <option :selected="reaction_time === '' ? 'selected' : ''" disabled>Wybierz...</option>
                            <option :selected="index === reaction_time ? 'selected' : ''" v-for="(det,index) in values['hours']"
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
                            <option :selected="time_to_fix === '' ? 'selected' : ''" disabled>Wybierz...</option>
                            <option :selected="index === time_to_fix ? 'selected' : ''" v-for="(det,index) in values['hours']"
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
                    <!--                    <div class="intro-y col-span-12 sm:col-span-6 mt-2">-->
                    <!--                        <label for="input-wizard-13" class="form-label">-->
                    <!--                            Okres ważności oferty w dniach-->
                    <!--                        </label>-->
                    <!--                        <div class="intro-y col-span-12 sm:col-span-12" >-->
                    <!--                            <Multiselect-->
                    <!--                                class="form-control"-->
                    <!--                                v-model="selected_robot"-->
                    <!--                                mode="single"-->
                    <!--                                label="name"-->
                    <!--                                max="1"-->
                    <!--                                :placeholder="selected_robot === '' ? 'select' : selected_robot"-->
                    <!--                                valueProp="value"-->
                    <!--                                :track-by="trackBy"-->
                    <!--                                :options="solution_robots"-->
                    <!--                            />-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <div class="intro-y col-span-12 sm:col-span-6 mt-2" v-for="(obj, index) in solution_robots">
                        <label :for="'input-wizard-' + index" class="form-label pb-5">
                            Okres gwarancji robota {{obj.name}}
                        </label>
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <Slider v-model="solution_robots[index].guarantee_period" :min="0" :max="10" :step="1" style="width: 100%;"/>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary w-20 mt-3" @click.prevent="save">{{ $t('profiles.save') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
import Multiselect from '@vueform/multiselect';
import Slider from '@vueform/slider'


export default {
    components: {
        Multiselect,
        Slider
    },
    name: "OfferAddProject",
    props: {
        edit_offer_id: Number,
        solution_id: Number,
        challenge_id: Number,
        change_offer: Boolean
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
        const solution_robots = ref([]);
        const solution_save = ref({});
        const Robots = ref([]);
        const selected_robot = ref('');
        const trackBy = ref('name');
        const guarantee_period = ref('');
        const isDisabled = ref(false);
        const toast = useToast();
        const values = require('../../../json/offer_values.json');
        const gridSize = ref('');

        emitter.on('offerSelected', e => () => {
            getOffer(e.offer_id);
        });

        emitter.on('changeToOfferAdd', e => () => {
            getOffer(e.id);
        });



        const addRobot = () => {
            Robots.value.push({
                name: 'Dodaj robot',
                price: 0
            });
        }

        const saveRobot = async (robot_id) => {
            axios.post('/api/solution/save/robot', {robot_id: robot_id, solution_id: props.solution_id, guarantee_period: guarantee_period.value})
                .then(response => {
                    if (response.data.success) {
                        isDisabled.value = true;
                        toast.success(response.data.message);
                        setTimeout(() =>{
                            isDisabled.value = false;
                        }, 2000);

                    } else {
                        isDisabled.value = true;
                        toast.error(response.data.message);
                        setTimeout(() =>{
                            isDisabled.value = false;
                        }, 2000);
                    }
                })
        }

        const getSolution = () => {
            axios.post('/api/solution/robots', {id: props.solution_id, offer_id: props.edit_offer_id})
                .then(response => {
                    if (response.data.success) {

                        solution_robots.value = response.data.payload;
                    } else {
                        // toast.error(response.data.message);
                    }
                }).catch((error) =>{

            })
        };

        const save = () => {
            axios.post('/api/offer/save', {
                edit_id: props.edit_offer_id,
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
                offer_expires_in: offer_expires_in.value,
                solution_robots: solution_robots.value,
                is_changed: props.change_offer,
            }).then(response => {
                if (response.data.success) {
                    toast.success(response.data.message);
                    emitter.emit('changeToOffers', {action: 'go', check: true, is_done_offer: props.is_changed});
                } else {
                    toast.error('Ups! Coś poszło nie tak!');
                }
            })
        }

        const segregateRobots = () => {
            solution_save.value.map((obj) => {
                if(obj.category == 1) {
                    solution_robots.value.push(obj);
                }
            });
        };

        onMounted(() => {
            if(props.edit_offer_id != undefined){
                getOffer();
            }
            getSolution();
        });


        const getOffer = () => {
            let id = props.edit_offer_id;

            axios.post('/api/offer/get', {id: id})
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
            gridSize,
            saveRobot,
            isDisabled,
            guarantee_period,
            trackBy,
            selected_robot,
            Robots,
            addRobot,
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
            offer_expires_in,
            solution_robots,
            solution_save
        }
    }
}
</script>

<style scoped>

</style>
