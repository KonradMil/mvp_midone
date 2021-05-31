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
