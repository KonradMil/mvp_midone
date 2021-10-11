<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-12">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">{{$t('challengesMain.solutions')}}</h2>
                </div>
                <div class="px-5 py-5" style="background-color: rgba(241,245,248,var(--tw-bg-opacity));">
                    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
<!--                        <div v-if="challenge.stage >= 2" v-for="(solution, index) in challenge.selected" class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box solution-selected">-->
<!--                            <SingleSolutionPost  :challenge="challenge" :user="user" :key="'selected_' + index" :solution="solution" :canAccept="false" :canEdit="false"></SingleSolutionPost>-->
<!--                        </div>-->
                        <div class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box" :class="(solution.selected) ? 'solution-selected' : ''">
                                <span v-if="user.type === 'integrator'">
                                    <SingleSolutionPost :user="user" :challenge="challenge" :solution="solution"></SingleSolutionPost>
                                </span>
                                <span v-if="user.type === 'investor'">
                                    <SingleSolutionPost v-if="solution.status === 1" :challenge="challenge" :user="user" :solution="solution" :canEdit="false" ></SingleSolutionPost>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, getCurrentInstance, onMounted, reactive, ref, watch} from "vue";
import {useToast} from "vue-toastification";
import router from "../../../router";
import SingleSolutionPost from "../../../components/SingleSolutionPost";
import Multiselect from '@vueform/multiselect';
import RequestHandler from "../../../compositions/RequestHandler";


export default {
    name: "SolutionProjectPanel",
    components: {SingleSolutionPost, Multiselect},
    props: {
        challenge: Object,
        inTeam: Boolean,
        type: String,
        addChallengeSolution: Boolean,
        acceptChallengeSolutions: Boolean,
        addSolutionOffer: Boolean
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const challenge = computed(() => {
            return props.challenge;
        });
        const toast = useToast();
        const types = require("../../../json/types.json");
        const user = window.Laravel.user;
        const guard = ref(false);
        const solution = ref({});

        const delete_cookie = (name, path = '/', domain) => {
            if (get_cookie(name)) {
                document.cookie = name + "=" +
                    ((path) ? ";path=" + path : "") +
                    ((domain) ? ";domain=staging.appworks-dev.pl" : "") +
                    ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
            }
        }

        const get_cookie = (name) => {
            return document.cookie.split(';').some(c => {
                return c.trim().startsWith(name + '=');
            });
        }

        const getProjectSolution = () => {
            RequestHandler('projects/' + props.challenge.id + '/solution', 'get', {}, (response) => {
                solution.value = response.data.solution;
            });
        }

        const follow = () => {
            axios.post('/api/solution/follow', {id: props.challenge.id})
                .then(response => {

                    if (response.data.success) {
                        challenge.value.followed = true;
                        toast.success('Teraz śledzisz to rozwiązania.');
                    } else {

                    }
                })
        }

        const unfollow = () => {
            axios.post('/api/solution/unfollow', {id: props.challenge.id})
                .then(response => {

                    if (response.data.success) {
                        challenge.value.followed = false;
                        toast.success('Nie śledzisz już tego rozwiązania.');
                    } else {

                    }
                })
        }

        onMounted(function () {
            getProjectSolution();
        });

        return {
            getProjectSolution,
            guard,
            solution,
            challenge,
            types,
            follow,
            unfollow,
            user,
        }
    }
}
</script>

<style scoped>

</style>
