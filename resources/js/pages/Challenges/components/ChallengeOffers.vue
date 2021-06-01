<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-12">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto"> Wszystkie oferty</h2>
                </div>
                <div class="px-5 pt-5">
                    <div v-if="offers.length == 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                        <div v-if="user.type == 'integrator'">
                            <p>
                                W tej chwili nie masz żadnych ofert.
                            </p>
                        </div>

                    </div>
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
                </div>
            </div>
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
