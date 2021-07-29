<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-12">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">{{$t('challengesMain.solutions')}}</h2>
                </div>
                <div class="px-5 py-5">
                    <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5" v-if="user.type === 'investor'">
                        <label for="input-wizard-5" class="form-label pr-5 font-medium dark:text-theme-10 text-theme-1">Filtr</label>
                        <Multiselect
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
                    <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5" v-if="user.type === 'investor'">
                        <label for="input-wizard-5" class="form-label font-medium dark:text-theme-10 text-theme-1">Dostawca głównej technologii</label>
                        <Multiselect
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
                        <!--            <template slot="singleLabel" slot-scope="props"><img class="option__image" :src="props.option.img" alt="No Man’s Sky"><span class="option__desc"><span class="option__title">{{ props.option.title }}</span></span></template>-->
                        <!--            <template slot="option" slot-scope="props"><img class="option__image" :src="props.option.img" alt="No Man’s Sky">-->
                        <!--                <div class="option__desc"><span class="option__title">{{ props.option.title }}</span><span class="option__small">{{ props.option.desc }}</span></div>-->
                        <!--            </template>-->
                    </div>
                    <div v-if="solutionsInTeam.length == 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                        {{$t('challengesMain.noSolutions')}}.
                    </div>
                    <div v-if="solutions.length == 0 && filterType !== null" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                        Nie ma rozwiązań spełniających podane kryteria.
                        <div v-if="user.type == 'integrator'">
                            <p>
                                {{$t('challengesMain.noSolutionsInform')}}.
                            </p>
                            <button class="btn btn-primary shadow-md mr-2" @click="addSolution">{{$t('challengesMain.addSolution')}}</button>
                        </div>
                    </div>
                    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
<!--                        <div v-if="challenge.stage >= 2" v-for="(solution, index) in challenge.selected" class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box solution-selected">-->
<!--                            <SingleSolutionPost  :challenge="challenge" :user="user" :key="'selected_' + index" :solution="solution" :canAccept="false" :canEdit="false"></SingleSolutionPost>-->
<!--                        </div>-->
                        <div v-for="(solution, index) in solutionsInTeam" :key="index" v-if="challenge.stage > 0" class="intro-y col-span-6 md:col-span-4 xl:col-span-6 box" :class="(solution.selected) ? 'solution-selected' : ''">
                                <span v-if="user.type === 'integrator'">
                                    <SingleSolutionPost :index="index" :user="user" :challenge="challenge" :solution="solution" :canAccept="(user.id === challenge.author_id) && challenge.status == 1" :canEdit="user.id === solution.author_id" :canEditSolution="canEditSolution" :addSolutionOffer="addSolutionOffer" :canDeleteSolution="canDeleteSolution" :canPublishSolution="canPublishSolution"></SingleSolutionPost>
                                </span>
                                <span v-if="user.type === 'investor'">
                                    <SingleSolutionPost v-if="solution.status === 1" :challenge="challenge" :user="user" :solution="solution" :canAccept="(inTeam) && challenge.status == 1" :canEdit="false" :acceptChallengeSolutions="acceptChallengeSolutions"></SingleSolutionPost>
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
            solutions.value.splice(e.index, 1);
            // filterMember();
        });

        const changeAddSolutionOffer = async(addSolutionOffer) => {
            emitter.emit('updateAddSolutionOffer', {addSolutionOffer: addSolutionOffer});
        }

        // watch(() => solutions.value, (first, second) => {
        // }, {})

        watch(() => technologyType.value, (first, second) => {
            if(technologyType.value !== null){
                StartFilterOffer();
            }
            // if(technologyType.value === null){
            //     getChallengeOffersRepositories();
            // }
        }, {})

        watch(() => filterType.value, (first, second) => {
            StartFilterOffer();
            if(filterType.value === null){
                technologyType.value = null;
                solutions.value = props.challenge.solutions;
            }
        }, {})


        const checkPermissions = () => {
            permissions.value.addSolutionOffer.forEach(function (permission) {
                props.challenge.solutions.forEach(function (solution){
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
                        solutionsInTeam.value = props.challenge.solutions;
                    }
                });
            permissions.value.publishSolution.forEach(function (permission) {
                props.challenge.solutions.forEach(function (solution){
                    let id = solution.id;
                    if(id === permission){
                        if(canPublishSolution.value === false){
                            canPublishSolution.value = true;
                        }
                    }
                });
            });
            permissions.value.showSolutions.forEach(function (permission) {
                props.challenge.solutions.forEach(function (solution){
                    let id = solution.id;
                    if(id === permission){
                        solutionsInTeam.value.push(solution);
                    }
                });
            });
            permissions.value.canEditSolution.forEach(function (permission) {
                props.challenge.solutions.forEach(function (solution){
                    let id = solution.id;
                    if(id === permission){
                            canEditSolution.value = true;
                        }
                });
            });
            permissions.value.canDeleteSolution.forEach(function (permission) {
                props.challenge.solutions.forEach(function (solution){
                    let id = solution.id;
                    if(id === permission){
                        canDeleteSolution.value = true;
                    }
                });
            });
        }

        onMounted(function () {
            permissions.value = window.Laravel.permissions;
           if(user.type == 'investor' && props.inTeam) {
               solutions.value = props.challenge.solutions;
           } else {
               // filterMember();
               solutions.value = props.challenge.solutions;
           }
            checkPermissions();
        });


        const filterMember = () => {
            axios.post('/api/solution/filter-member', {challenge_id: challenge.value.id})
                .then(response => {
                    if (response.data.success) {
                        solutions.value = response.data.payload;
                    }
                })
        }

        const StartFilterOffer = async () => {
            axios.post('/api/solution/user/filter', {option: filterType.value , id: props.challenge.id, technologyType: technologyType.value})
                .then(response => {
                    if (response.data.success) {
                        solutions.value = response.data.payload;
                        toast.success('Success!');
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
                        console.log(response.data.payload);
                        router.push({
                            name: 'challengeStudio',
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
                    ((domain) ? ";domain=devsys.appworks-dev.pl" : "") +
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
