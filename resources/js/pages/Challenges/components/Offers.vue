<template>
<!--    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">-->
<!--        <div class="grid grid-cols-12 gap-6">-->
<!--            &lt;!&ndash; BEGIN: Announcement &ndash;&gt;-->
<!--            <div class="intro-y box col-span-12 xxl:col-span-12">-->
<!--                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">-->
<!--                    <h2 class="font-medium text-base mr-auto"> Oferty</h2>-->
<!--                </div>-->
<!--                <div class="px-5 pt-5">-->
<!--                    <div v-if="offers.length == 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">-->
<!--                        <div v-if="user.type == 'integrator'">-->
<!--                            <p>-->
<!--                                W tej chwili nie dodałeś żadnej oferty.-->
<!--                            </p>-->
<!--                            <button class="btn btn-primary shadow-md mr-2 mt-2" @click="switchTab">Złóż ofertę</button>-->
<!--                        </div>-->

<!--                    </div>-->
<!--                    <div class="intro-y grid grid-cols-12 gap-6 mt-5">-->
<!--                        <div v-for="(solution, index) in challenge.solutions" :key="index"-->
<!--                             class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box" :class="(solution.selected)? 'solution-selected': ''">-->
<!--                            <div v-if="!solution.rejected">-->
<!--                                <div v-if="user.type == 'integrator'">-->
<!--                                    <SingleSolutionPost v-if="solution.author_id === user.id" :user="user" :solution="solution" :canAccept="user.id === challenge.author_id" :canEdit="user.id === solution.author_id"></SingleSolutionPost>-->
<!--                                </div>-->
<!--                                <div v-if="user.type == 'investor'">-->
<!--                                    <SingleSolutionPost v-if="solution.status === 1" :user="user" :solution="solution" :canAccept="user.id === challenge.author_id" :canEdit="user.id === solution.author_id"></SingleSolutionPost>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div
                    class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                >
                    <h2 class="font-medium text-base mr-auto"> Moje oferty</h2>
                </div>
                <div class="px-5 py-5" v-for="(offer, index) in offers.list" :key="index" >
                    <div
                        id="latest-tasks-new"
                        class="tab-pane active"
                        role="tabpanel"
                        aria-labelledby="latest-tasks-new-tab"
                    >
                        <div class="flex items-center">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Maksymalna waga detalu:</span>
                                <div class="text-gray-600"> {{ offer.price_of_delivery }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Jakość chwytania detalu:</span>
                                <div class="text-gray-600"> {{ offer.weeks_to_start }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Materiał detalu:</span>
                                <div class="text-gray-600"> {{ offer.time_to_start }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Wielkość detalu:</span>
                                <div class="text-gray-600"> {{ offer.time_to_fix }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Sposób pobierania metalu:</span>
                                <div class="text-gray-600"> {{ offer.advance_upon_start }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Czy detal jest pozycjonowany do pobrania?</span>
                                <div class="text-gray-600"> {{ offer.advance_upon_delivery }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Odległość pomiędzy miejscem pobrania i odkładania detalu:</span>
                                <div class="text-gray-600"> {{ offer.advance_upon_agreement }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Miejsce odłożenia detalu:</span>
                                <div class="text-gray-600"> {{ offer.years_of_guarantee }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Ilość obsługiwanych stanowisk/linii:</span>
                                <div class="text-gray-600"> {{offer.service_support_scope }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Liczba zmian:</span>
                                <div class="text-gray-600"> {{ offer.maintenance_frequency }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Liczba zmian:</span>
                                <div class="text-gray-600"> {{ offer.price_of_maintenance }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Liczba zmian:</span>
                                <div class="text-gray-600"> {{ offer.reaction_time }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Liczba zmian:</span>
                                <div class="text-gray-600"> {{ offer.intervention_price }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Liczba zmian:</span>
                                <div class="text-gray-600"> {{ offer.work_hour_price }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Liczba zmian:</span>
                                <div class="text-gray-600"> {{ offer.period_of_support }} </div>
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
import {getCurrentInstance, onMounted, ref} from "vue";
import GetOffers from "../../../compositions/GetOffers";
import GetChallengeOffers from "../../../compositions/GetChallengeOffers";

export default {
    name: "Offers",
    props: {
        activeTab: String
    },
    emits: ["update:activeTab"],
    setup(props, context) {
        const offers = ref([]);
        const user = window.Laravel.user;

        const switchTab = () => {
            context.emit("update:activeTab", 'addingoffer');
        }

        const getOffersRepositories = async () => {
            offers.value = GetOffers();
        }


        // const getOffers = () => {
        //     axios.post('/api/offer/get/all', {})
        //         .then(response => {
        //             if (response.data.success) {
        //                 offers.value = response.data.payload;
        //                 console.log(response.data.payload + ' -> OFFERS VALUE')
        //             } else {
        //                 // toast.error(response.data.message);
        //             }
        //         })
        // };

        onMounted(() => {
           // getOffers();
            getOffersRepositories('');
        });

        return {
            switchTab,
            offers,
            user
        }
    }
}
</script>

<style scoped>

</style>
