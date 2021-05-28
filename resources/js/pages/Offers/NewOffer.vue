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
        const price_of_delivery = ref(0);
        const weeks_to_start = ref(0);
        const time_to_start = ref(0);
        const advance_upon_agreement = ref(0);
        const advance_upon_delivery = ref(0);
        const advance_upon_start = ref(0);
        const years_of_guarantee = ref(0);
        const maintenance_frequency = ref(0);
        const price_of_maintenance = ref(0);
        const reaction_time = ref(0);
        const time_to_fix = ref(0);
        const intervention_price = ref(0);
        const work_hour_price = ref(0);
        const period_of_support = ref(0);

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
            save
        }
    }
}
</script>

<style scoped>

</style>
