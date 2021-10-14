<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-12">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">{{$t('challengesMain.solutions')}}</h2>
                </div>
                <div class="px-5 py-5" style="background-color: rgba(241,245,248,var(--tw-bg-opacity));">
                    <div v-if="solutions.length == 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                        <div>
                            <p>
                                {{$t('challengesMain.noSolutionsInform')}}.
                            </p>
                        </div>
                    </div>
                    <div class="intro-y grid grid-cols-12 gap-6 mt-5" v-if="user.type =='integrator'">
                        <!--                        <div v-if="challenge.stage >= 2" v-for="(solution, index) in challenge.selected" class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box solution-selected">-->
                        <!--                            <SingleSolutionPost  :challenge="challenge" :user="user" :key="'selected_' + index" :solution="solution" :canAccept="false" :canEdit="false"></SingleSolutionPost>-->
                        <!--                        </div>-->
                        <div v-for="(solution, index) in solutions" :key="index" class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                                <span v-if="user.type === 'integrator'">
                                    <SingleSolutionPost :user="user" :solution="solution" :type="'archive'"></SingleSolutionPost>
                                </span>
                            <span v-if="user.type === 'investor'">
                                    <SingleSolutionPost :user="user" :solution="solution" :type="'archive'"></SingleSolutionPost>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref} from "vue";
import {useToast} from "vue-toastification";
import router from "../../router";
import SingleSolutionPost from "../../components/SingleSolutionPost";
import GetSolutionsArchive from "../../compositions/GetSolutionsArchive";


export default {
    name: "solutionsArchive",
    components: {SingleSolutionPost, GetSolutionsArchive},
    setup(props) {
        const toast = useToast();
        const types = require("../../json/types.json");
        const user = window.Laravel.user;
        const solutions = ref([]);
        const filterSolutions = () => {
            axios.post('/api/solution/user/get/archive', {})
                .then(response => {
                    if (response.data.success) {
                        solutions.value = response.data.payload;
                    }
                })
        }

        // const getSolutionRepositories = async() => {
        //     solutions.value = GetSolutionsArchive();
        // }

        onMounted(function () {
            filterSolutions();

            // getSolutionRepositories();
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });


        return {
            // getSolutionRepositories,
            solutions,
            types,
            user,
        }
    },
    // beforeRouteEnter(to, from, next) {
    //     if (!window.Laravel.isLoggedin) {
    //         window.location.href = "/";
    //     }
    //     next((vm) => {
    //         vm.getSolutionRepositories();
    //     });
    // }
}
</script>

<style scoped>

</style>
