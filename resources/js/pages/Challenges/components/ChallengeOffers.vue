<template>
<!--    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">-->
<!--        <div class="grid grid-cols-12 gap-6">-->
<!--            &lt;!&ndash; BEGIN: Announcement &ndash;&gt;-->
<!--            <div class="intro-y box col-span-12 xxl:col-span-12">-->
<!--                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">-->
<!--                    <h2 class="font-medium text-base mr-auto"> Wszystkie oferty</h2>-->
<!--                </div>-->
<!--                <div class="px-5 pt-5">-->
<!--                    <div v-if="offers.length == 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">-->
<!--                        <div v-if="user.type == 'integrator'">-->
<!--                            <p>-->
<!--                                W tej chwili nie masz żadnych ofert.-->
<!--                            </p>-->
<!--                        </div>-->

<!--                    </div>-->
<!--                                        <div class="intro-y grid grid-cols-12 gap-6 mt-5">-->
<!--                                            <div v-for="(solution, index) in challenge.solutions" :key="index"-->
<!--                                                 class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box" :class="(solution.selected)? 'solution-selected': ''">-->
<!--                                                <div v-if="!solution.rejected">-->
<!--                                                    <div v-if="user.type == 'integrator'">-->
<!--                                                        <SingleSolutionPost v-if="solution.author_id === user.id" :user="user" :solution="solution" :canAccept="user.id === challenge.author_id" :canEdit="user.id === solution.author_id"></SingleSolutionPost>-->
<!--                                                    </div>-->
<!--                                                    <div v-if="user.type == 'investor'">-->
<!--                                                        <SingleSolutionPost v-if="solution.status === 1" :user="user" :solution="solution" :canAccept="user.id === challenge.author_id" :canEdit="user.id === solution.author_id"></SingleSolutionPost>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9" >
        <div
        class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
    >
        <h2 class="font-medium text-base mr-auto"> Moje oferty</h2>
    </div>
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-6" v-for="(offer, index) in offers.list" :key="index">

                <div class="px-5 py-5"  >
                    <div
                        id="latest-tasks-new"
                        class="tab-pane active"
                        role="tabpanel"
                        aria-labelledby="latest-tasks-new-tab"
                    >
                        <div class="flex items-center">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Cena za dostawę oraz uruchomienie stanowiska (netto):</span>
                                <div class="text-gray-600"> {{ offer.price_of_delivery }}</div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Ilość tygodni do uruchomienia, liczona od podpisania umowy:</span>
                                <div class="text-gray-600"> {{ offer.weeks_to_start }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Czas realizacji uruchomienia u klienta (tygodni):</span>
                                <div class="text-gray-600"> {{ offer.time_to_start }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Czas przywrócenia stanowiska do sprawności po awarii:</span>
                                <div class="text-gray-600"> {{ offer.time_to_fix }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Wysokość zaliczki płatnej po uruchomieniu i finalnym odbiorze stanowiska:</span>
                                <div class="text-gray-600"> {{ offer.advance_upon_start }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Wyskość zaliczki (%) płatnej przy odbiorze wstępnym dokonywanym u Integratora:</span>
                                <div class="text-gray-600"> {{ offer.advance_upon_delivery }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Wysokość zaliczki (%) płatnej po podpisaniu umowy:</span>
                                <div class="text-gray-600"> {{ offer.advance_upon_agreement }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Okres gwarancji w latach:</span>
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
                                <span class="font-medium dark:text-theme-10 text-theme-1">Częstotliwość przeglądów gwarancyjnych w roku:</span>
                                <div class="text-gray-600"> {{ offer.maintenance_frequency }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Koszt roczny przeglądu gwaranycjnego:</span>
                                <div class="text-gray-600"> {{ offer.price_of_maintenance }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Czas reakcji na zgłoszenie awarii w godzinach:</span>
                                <div class="text-gray-600"> {{ offer.reaction_time }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Koszt interwencji w wypadku awarii nie podlegającej gwarancji:</span>
                                <div class="text-gray-600"> {{ offer.intervention_price }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Koszt roboczo godziny pracy wsparcia / prac rozwojowych:</span>
                                <div class="text-gray-600"> {{ offer.work_hour_price }} </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5">
                            <div class="border-l-2 border-theme-1 pl-4">
                                <span class="font-medium dark:text-theme-10 text-theme-1">Okres wsparcia technicznego poza zakresem gwarancji w latach:</span>
                                <div class="text-gray-600"> {{ offer.period_of_support }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Announcement -->
            <!-- BEGIN: Daily Sales -->
            <!-- END: Daily Sales -->
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import GetChallengeOffers from "../../../compositions/GetChallengeOffers";

export default {
    name: "ChallengeOffers",
    props: {
        id: Number,
        activeTab: String
    },
    emits: ["update:activeTab"],
    setup(props, context) {
        const offers = ref([]);
        const user = window.Laravel.user;

        const switchTab = () => {
            context.emit("update:activeTab", 'addingoffer');
        }

        const getChallengeOffersRepositories = async () => {
            offers.value = GetChallengeOffers(props.id);
        }


        onMounted(() => {
            getChallengeOffersRepositories('');
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
