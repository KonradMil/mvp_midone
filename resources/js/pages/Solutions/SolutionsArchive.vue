<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-12">
                <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        {{$t('challengesMain.solutions')}}
                        <span v-if="type === 'archive'">archiwalne</span>
                        <span v-if="type === 'all'"> wszystkie</span>
                    </h2>
                    <div v-if="type === 'all'" class="mr-auto">
                        <label for="post-form-3" class="form-label ml-14 font-medium">Filtruj względem nazwy wyzwania</label>
                        <Multiselect
                            @select="getChallengeSolutionsByChallengeName"
                            @deselect="getAllUserSolutions"
                            :closeOnSelect="false"
                            class="w-80"
                            v-model="challengeName"
                            mode="single"
                            label="name"
                            max="1"
                            :placeholder="challengeName === null ? 'Wybierz...' : challengeName"
                            :close-on-select="false"
                            :clear-on-select="false"
                            :preserve-search="true"
                            :preselect-first="true"
                            valueProp="value"
                            :options="challengeNames"
                        />
                    </div>
                </div>
                <div class="px-5 py-5" style="background-color: rgba(241,245,248,var(--tw-bg-opacity));">
                    <span v-if="type === 'all'">
                        <div v-if="allSolutions.length == 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                        <div>
                            <p>
                                {{$t('challengesMain.noSolutions')}}.
                            </p>
                        </div>
                    </div>
                    </span>
                    <span v-if="type === 'archive'">
                        <div v-if="archiveSolutions.length == 0" class="w-full text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                        <div>
                            <p>
                                {{$t('challengesMain.noSolutionsInform')}}.
                            </p>
                        </div>
                    </div>
                     </span>
                    <div class="intro-y grid grid-cols-12 gap-6 mt-5" v-if="type === 'all'">
                        <div v-for="(solution, index) in allSolutions" :key="'solution_' + index" class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                                    <SingleSolutionPost :user="user" :solution="solution" :type="type"></SingleSolutionPost>
                        </div>
                    </div>
                    <div class="intro-y grid grid-cols-12 gap-6 mt-5" v-if="type === 'archive'">
                        <div v-for="(solution, index) in archiveSolutions" :key="'solution_' + index" class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                                    <SingleSolutionPost :user="user" :solution="solution" :type="type"></SingleSolutionPost>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import SingleSolutionPost from "../../components/SingleSolutionPost";
import GetSolutionsArchive from "../../compositions/GetSolutionsArchive";
import RequestHandler from "../../compositions/RequestHandler";
import Multiselect from '@vueform/multiselect';


export default {
    name: "solutionsArchive",
    components: {SingleSolutionPost, Multiselect, GetSolutionsArchive},
    props: {
        type: String
    },
    setup(props) {
        const types = require("../../json/types.json");
        const user = window.Laravel.user;
        const archiveSolutions = ref([]);
        const allSolutions = ref([]);
        const challengeNames = ref([]);
        const challengeName = ref(null);

        watch(()=> challengeName.value, ()=>{
            if(challengeName.value === null){
                getAllUserSolutions();
            }
        },{})

        watch(() => props.type, (first, second) => {
            if(props.type === 'all'){
                getAllUserSolutions();
            } else if(props.type === 'archive'){
                challengeName.value = null;
                filterSolutions();
            }
        }, {})

        const filterSolutions = () => {
            axios.post('/api/solution/user/get/archive', {})
                .then(response => {
                    if (response.data.success) {
                        archiveSolutions.value = response.data.payload;
                    }
                })
        }

        const getAllUserSolutions = async (callback) => {
            RequestHandler('solution/' + user.id + '/all', 'get', {}, (response) => {
                allSolutions.value = response.data.solutions;
                callback(response.data.solutions);
            });
        }

        const getChallengeSolutionsByChallengeName = async (callback) => {
            RequestHandler('solution/' + user.id + '/challenge/solutions', 'get', {
                challengeName: challengeName.value
            }, (response) => {
                allSolutions.value = response.data.solutions;
                callback(response.data.solutions);
            });
        }

        const addSolutionChallengeName = async(response) =>{
            let i =0;
            challengeNames.value.push(allSolutions.value[i].challenge.name)
            for(i=1; i < response.length; i++){
                if(i+1 < response.length){
                    if(allSolutions.value[i].challenge.name !== allSolutions.value[i+1].challenge.name){
                        challengeNames.value.push(allSolutions.value[i].challenge.name);
                    }
                }
            }
        }

        onMounted(function () {
            if(props.type === 'all'){
                console.log('all solutions start')
                getAllUserSolutions((response)=>{
                    addSolutionChallengeName(response);
                });
            } else if(props.type === 'archive'){
                console.log('Archive solutions start')
                filterSolutions(()=>{

                });
            }
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });


        return {
            getAllUserSolutions,
            getChallengeSolutionsByChallengeName,
            challengeName,
            challengeNames,
            allSolutions,
            archiveSolutions,
            types,
            user,
        }
    },
}
</script>

<style scoped>

</style>
