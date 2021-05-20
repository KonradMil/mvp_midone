<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div
                    class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                >
                    <h2 class="font-medium text-base mr-auto"> Szczegóły techniczne</h2>
                </div>
                <div class="px-5 py-5">
                    <div
                        id="latest-tasks-new"
                        class="tab-pane active"
                        role="tabpanel"
                        aria-labelledby="latest-tasks-new-tab"
                    >
                        <div class="flex items-center">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Maksymalna waga detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_weight'][challenge.technical_details.detail_weight].name }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Jakość chwytania detalu:</span>
                                <div class="text-gray-600"> {{ details['select_pick_quality'][challenge.technical_details.pick_quality].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Materiał detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_material'][challenge.technical_details.detail_material].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Wielkość detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_size'][challenge.technical_details.detail_size].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Sposób pobierania metalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_pick'][challenge.technical_details.detail_pick].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Czy detal jest pozycjonowany do pobrania?</span>
                                <div class="text-gray-600"> {{ details['select_detail_position'][challenge.technical_details.detail_position].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Odległość pomiędzy miejscem pobrania i odkładania detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_range'][challenge.technical_details.detail_range].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Miejsce odłożenia detalu:</span>
                                <div class="text-gray-600"> {{ details['select_detail_destination'][challenge.technical_details.detail_destination].name }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Ilość obsługiwanych stanowisk/linii:</span>
                                <div class="text-gray-600"> {{challenge.technical_details.number_of_lines }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Liczba zmian:</span>
                                <div class="text-gray-600"> {{ details['select_work_shifts'][challenge.technical_details.work_shifts].name }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Announcement -->
            <!-- BEGIN: Daily Sales -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div
                    class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5"
                >
<!--                    <h2 class="font-medium text-base mr-auto">Zdjęcia</h2>-->
                </div>
                <div class="p-10">

                </div>
            </div>
            <!-- END: Daily Sales -->
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref} from "vue";

export default {
    name: "TechnicalInformationPanel",
    props: {
        challenge: Object
    },
    setup(props) {
        const challenge = computed(() => {
            return props.challenge;
        });
        const details = require("../../../json/challenge.json");

        onMounted(() => {

        });


        return {
            challenge,
            details
        }
    }
}
</script>

<style scoped>

</style>
