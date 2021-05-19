<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{$t('solutions.solutions')}}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button class="btn btn-primary shadow-md mr-2" @click="$router.push({name: 'addSolution'})">{{$t('solutions.addNew')}}</button>
                <div class="dropdown ml-auto sm:ml-0">
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a href=""
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <Share2Icon class="w-4 h-4 mr-2"/>
                              {{$t('global.sharePost')}}
                            </a>
                            <a href=""
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <DownloadIcon class="w-4 h-4 mr-2"/>
                                {{$t('global.downloadPost')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Blog Layout -->
            <div
                v-for="(solution, index) in solutions.list"
                :key="index"
                class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box"
            >
            <SingleSolutionPost :user="user" :solution="solution"></SingleSolutionPost>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, provide, onMounted, getCurrentInstance} from "vue";
import GetSolutions from "../../compositions/GetSolutions";
import CommentSection from "../../components/social/CommentSection";
import SingleSolutionPost from "../../components/SingleSolutionPost";


export default {
    name: "SolutionsMain",
    components: {SingleSolutionPost, CommentSection, Comment, GetSolutions},
    setup: function () {
        const solutions = ref([]);
        const user = ref({});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const getSolutionRepositories = async () => {
            solutions.value = GetSolutions();
        }
        const types = require("../../json/types.json");

        onMounted(function () {
            getSolutionRepositories();
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })





        return {
            solutions,
            user,
            types
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>

<style scoped>

</style>
