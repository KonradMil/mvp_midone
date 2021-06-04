<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-12">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto"> Rozwiązania</h2>
                </div>
                <div class="px-5 py-5">
                    <div v-if="challenge.solutions.length == 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                        Nie ma jeszcze żadnych rozwiązań.
                        <div v-if="user.type == 'integrator'">
                            <p>
                                W tej chwili nie ma żadnych wyzwań, poinformujemy Cię jak tylko jakieś będą dostępne.
                            </p>
                            <button class="btn btn-primary shadow-md mr-2" @click="addSolution">{{ $t('challengesMain.addChallenge') }}</button>
                        </div>
                    </div>
                    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
                        <div v-if="challenge.stage >= 2" class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box" :class="(challenge.selected)? 'solution-selected': ''">
                            <SingleSolutionPost :user="user" :solution="challenge.selected" :canAccept="false" :canEdit="false"></SingleSolutionPost>
                        </div>
                        <div v-for="(solution, index) in challenge.solutions" :key="index" v-if="challenge.stage < 2" class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box" :class="(solution.selected)? 'solution-selected': ''">
                                     <span v-if="user.type == 'integrator'">
                                    <SingleSolutionPost v-if="(solution.author_id === user.id)" :user="user" :solution="solution" :canAccept="(user.id === challenge.author_id) && challenge.status == 1" :canEdit="user.id === solution.author_id"></SingleSolutionPost>
                                </span>
                            <span v-if="user.type == 'investor'">
                                    <SingleSolutionPost v-if="solution.status === 1" :user="user" :solution="solution" :canAccept="(user.id === challenge.author_id) && challenge.status == 1" :canEdit="user.id === solution.author_id"></SingleSolutionPost>
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
import router from "../../../router";
import SingleSolutionPost from "../../../components/SingleSolutionPost";

export default {
    name: "SolutionsPanel",
    components: {SingleSolutionPost},
    props: {
        challenge: Object
    },
    setup(props) {
        const challenge = computed(() => {
            return props.challenge;
        });
        const toast = useToast();
        const types = require("../../../json/types.json");
        const user = ref({});

        onMounted(function () {
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        const addSolution = () => {
            axios.post('/api/solution/create', {id: challenge.value.id})
                .then(response => {
                    if (response.data.success) {
                        delete_cookie('type');
                        delete_cookie('id');
                        console.log(response.data.payload);
                        router.push({
                            name: 'solutionStudio',
                            params: {id: response.data.payload.id, type: 'solution', load: response.data.payload}
                        });
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        };


        const delete_cookie = (name, path = '/', domain) => {
            if (get_cookie(name)) {
                document.cookie = name + "=" +
                    ((path) ? ";path=" + path : "") +
                    ((domain) ? ";domain=two.appworks-dev.pl" : "") +
                    ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
            }
        }

        const get_cookie = (name) => {
            return document.cookie.split(';').some(c => {
                return c.trim().startsWith(name + '=');
            });
        }

        const follow = () => {
            axios.post('/api/solution/follow', {id: props.challenge.id})
                .then(response => {
                    // console.log(response.data)
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
                    // console.log(response.data)
                    if (response.data.success) {
                        challenge.value.followed = false;
                        toast.success('Nie śledzisz już tego rozwiązania.');
                    } else {

                    }
                })
        }
        return {
            challenge,
            types,
            follow,
            unfollow,
            user,
            addSolution
        }
    }
}
</script>

<style scoped>

</style>
