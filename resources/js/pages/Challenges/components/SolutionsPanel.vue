<template>
    <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9" v-if="guard === true">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-12">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">{{$t('challengesMain.solutions')}}</h2>
                </div>
                <div class="px-5 py-7" style="background-color: rgba(241,245,248,var(--tw-bg-opacity));">
                    <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5" v-if="user.type === 'investor' && solutionsInTeam.length !== 0 || (filterType !== null ||technologyType !== null)">
                        <label for="input-wizard-5" style="position: absolute; margin-bottom: 90px;" class="form-label pr-5 font-medium dark:text-theme-10 text-theme-1">Filtr</label>
                        <Multiselect
                            :disabled="technologyType !== null"
                            class="form-control"
                            v-model="filterType"
                            mode="single"
                            label="name"
                            max="1"
                            :placeholder="filterType === null ? 'Wybierz...' : filterType"
                            :close-on-select="false"
                            :clear-on-select="false"
                            :preserve-search="true"
                            :preselect-first="true"
                            valueProp="value"
                            :options="filters['options']"
                        />
                    </div>
                    <div class="flex items-center px-5 py-7 border-b border-gray-200 dark:border-dark-5" v-if="user.type === 'investor' && solutionsInTeam.length !== 0 || (filterType !== null ||technologyType !== null)">
                        <label for="input-wizard-5" class="form-label font-medium dark:text-theme-10 text-theme-1" style="position: absolute; margin-bottom: 90px;">Dostawca głównej technologii</label>
                        <Multiselect
                            :disabled="filterType !== null"
                            class="form-control"
                            v-model="technologyType"
                            mode="single"
                            label="name"
                            max="1"
                            :placeholder="technologyType === null ? 'Wybierz...' : technologyType"
                            :show-labels="false"
                            :preselect-first="true"
                            valueProp="value"
                            :options="technology['options']"
                            :option-height="104"
                        />
                    </div>
                    <div v-if="challenge.solutions.length === 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                        {{$t('challengesMain.noSolutions')}}.
                    </div>
                    <div v-if="solutionsInTeam.length === 0 && (filterType !== null || technologyType !== null)" class="intro-y w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                        Nie ma rozwiązań spełniających podane kryteria.
                        <div v-if="user.type == 'integrator'">
                            <p>
                                {{$t('challengesMain.noSolutionsInform')}}.
                            </p>
                            <button class="btn btn-primary shadow-md mr-2" @click="addSolution">{{$t('challengesMain.addSolution')}}</button>
                        </div>
                    </div>
                    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
                        <div v-for="(solution, index) in solutionsInTeam" :key="solution.id" v-if="challenge.stage > 0" class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box" :class="(solution.selected) ? 'solution-selected' : ''">
                                <span v-if="user.type === 'integrator'">
                                    <SingleSolutionPost :user="user" :challenge="challenge" :solution="solution" :canAccept="(user.id === challenge.author_id) && challenge.status == 1" :canEdit="user.id === solution.author_id" :canEditSolution="canEditSolution" :addSolutionOffer="addSolutionOffer" :canDeleteSolution="canDeleteSolution" :canPublishSolution="canPublishSolution"></SingleSolutionPost>
                                </span>
                                <span v-if="user.type === 'investor'">
                                    <SingleSolutionPost v-if="solution.status === 1" :check="(technologyType === null && filterType === null) ? 'false' : 'true'" :index="index" :challenge="challenge" :user="user" :solution="solution" :canAccept="(inTeam) && challenge.status == 1" :canEdit="false" :acceptChallengeSolutions="acceptChallengeSolutions"></SingleSolutionPost>
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


export default {
    name: "SolutionsPanel",
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
        const filters = require('../../../json/solution_filters.json');
        const technology = require('../../../json/technology_filters.json');
        const challenge = computed(() => {
            return props.challenge;
        });
        const toast = useToast();
        const types = require("../../../json/types.json");
        const user = window.Laravel.user;
        const guard = ref(false);
        const solutions = ref([]);
        const solutionsInTeam = ref([]);
        const filterType = ref(null);
        const technologyType = ref(null);
        const permissions = ref({});
        const addSolutionOffer = ref(false);
        const canPublishSolution = ref(false);
        const canEditSolution= ref(false);
        const canDeleteSolution = ref(false);

        emitter.on('deletesolution', e => {
            solutionsInTeam.value.splice(solutionsInTeam.value.indexOf(e.solution), 1);
            let index;
            let length = permissions.value.showSolutions.length;
            for(index = 0; index < length; index++){
                if(permissions.value.showSolutions[index] === e.id){
                    permissions.value.showSolutions.splice(index, 1);
                    break;
                }
            }
            getChallengeSolutions();
        });

        const changeAddSolutionOffer = async(addSolutionOffer) => {
            emitter.emit('updateAddSolutionOffer', {addSolutionOffer: addSolutionOffer});
        }

        watch(() => technologyType.value, (first, second) => {
            if(technologyType.value !== null){
                StartFilterSolutions();
            }
            if(technologyType.value === null && filterType.value === null){
                StartFilterSolutions();
            }
        }, {})

        watch(() => filterType.value, (first, second) => {
            if(filterType.value !== null){
                StartFilterSolutions();
            }
            if(technologyType.value === null && filterType.value === null){
                StartFilterSolutions();
            }
        }, {})


        const checkPermissions = () => {
            permissions.value.addSolutionOffer.forEach(function (permission) {
                solutions.value.forEach(function (solution){
                    let id = solution.id;
                   if(id === permission){
                          if(addSolutionOffer.value === false){
                              addSolutionOffer.value = true;
                              changeAddSolutionOffer(addSolutionOffer);
                          }

                   }
                });
            });
            permissions.value.publishChallenges.forEach(function (permission) {
                    let id = props.challenge.id
                    if(id === permission){
                        solutionsInTeam.value = solutions.value;
                    }
                });
            permissions.value.publishSolution.forEach(function (permission) {
                solutions.value.forEach(function (solution){
                    let id = solution.id;
                    if(id === permission){
                        if(canPublishSolution.value === false){
                            canPublishSolution.value = true;
                        }
                    }
                });
            });
            permissions.value.showSolutions.forEach(function (permission) {
                solutions.value.forEach(function (solution){
                    let id = solution.id;
                    if(id === permission){
                        solutionsInTeam.value.push(solution);
                    }
                });
            });
            permissions.value.canEditSolution.forEach(function (permission) {
                solutions.value.forEach(function (solution){
                    let id = solution.id;
                    if(id === permission){
                            canEditSolution.value = true;
                        }
                });
            });
            permissions.value.canDeleteSolution.forEach(function (permission) {
                solutions.value.forEach(function (solution){
                    let id = solution.id;
                    if(id === permission){
                        canDeleteSolution.value = true;
                    }
                });
            });
        }

        onMounted(function () {
            permissions.value = window.Laravel.permissions;
            getChallengeSolutions(function(){
                checkPermissions();
                guard.value = true;
            })
        });

        const filterMember = () => {
            axios.post('/api/solution/filter-member', {challenge_id: challenge.value.id})
                .then(response => {
                    if (response.data.success) {
                        solutions.value = response.data.payload;
                    }
                })
        }

        const getChallengeSolutions = (callback) => {
            axios.post('/api/solution/all/get', {challenge_id: props.challenge.id})
                .then(response => {
                    if (response.data.success) {
                        solutions.value = response.data.payload;
                        callback();
                    }
                })
        }

        const StartFilterSolutions = async () => {
            axios.post('/api/solution/user/filter', {option: filterType.value , id: props.challenge.id, technologyType: technologyType.value})
                .then(response => {
                    if (response.data.success) {
                        solutionsInTeam.value = response.data.payload;
                        // toast.success('Success!');
                    } else {
                        toast.error('Erro!');
                    }
                })
        }

        const addSolution = () => {
            axios.post('/api/solution/create', {id: challenge.value.id})
                .then(response => {
                    if (response.data.success) {
                        delete_cookie('type');
                        delete_cookie('id');

                        router.push({
                            name: 'challengeStudio',
                            params: {id: response.data.payload.id, type: 'solution', load: response.data.payload}
                        });
                    } else {
                    }
                })
        };


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

        return {
            getChallengeSolutions,
            canDeleteSolution,
            canPublishSolution,
            checkPermissions,
            solutionsInTeam,
            canEditSolution,
            addSolutionOffer,
            permissions,
            guard,
            solutions,
            challenge,
            types,
            follow,
            unfollow,
            user,
            addSolution,
            filterMember,
            filterType,
            filters,
            technologyType,
            technology
        }
    }
}
</script>

<style scoped>

</style>
