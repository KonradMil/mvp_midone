<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-12">
                <div
                    class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                >
                    <h2 class="font-medium text-base mr-auto">{{$t('teams.teams')}}</h2>
                </div>
                <div class="px-5 pt-5">
                    <div
                        v-for="(team, index) in teams"
                        :key="'team_' + index"
                        class="intro-y col-span-6 xl:col-span-6 md:col-span-6 sm:col-span-12"
                    >
                        <div class="box">
                            <div class="flex flex-col lg:flex-row items-center p-5">
                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                    <Avatar :username="team.name" color="#FFF" background-color="#930f68"/>
                                </div>
                                <div
                                    class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0"
                                >
                                    <a href="" class="font-medium">{{ team.name }}</a>
                                    <div class="text-gray-600 text-xs mt-0.5">
                                        {{$t('teams.created')}}: {{ $dayjs(team.created_at).format('DD.MM.YYYY HH:mm') }}
                                    </div>
                                    <div class="text-gray-600 text-xs mt-0.5">
                                        {{ $t('teams.members')}}: {{ team.users.length }}
                                    </div>
                                </div>
                                <div class="flex mt-4 lg:mt-0">
                                    <button class="btn btn-outline-secondary py-1 px-2" @click="showDetails[team.id] = !showDetails[team.id]">
                                        {{$t('teams.details')}}
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-col lg:flex-row items-center p-5" v-if="showDetails[team.id] === true">
                                <div class="intro-y box w-full">
                                    <div class="p-5">
                                        <div v-for="(member, index) in team.users" class="relative flex items-center" :key="'member_' + index">
                                            <div class="w-12 h-12 flex-none image-fit">
                                                <Avatar :src="'uploads/' + member.avatar" :username="member.name + ' ' + member.lastname" size="40" color="#FFF" background-color="#930f68"/>
                                            </div>
                                            <div class="ml-4 mr-auto">
                                                <a href="" class="font-medium">{{ member.name + ' ' + member.lastname }}</a>
                                                <div class="text-gray-600 mr-5 sm:mr-5" v-if="member.companies.length != 0">
                                                    {{member.companies[0].company_name}}
                                                </div>
                                            </div>
                                            <div class="font-medium text-gray-700 dark:text-gray-600">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Announcement -->
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref, watch} from "vue";
import GetTeams from "../../../compositions/GetTeams";
import Avatar from "../../../components/avatar/Avatar";

export default {
    name: "TeamsPanel",
    props: {
        teams: Object
    },
    components: {Avatar},
    setup(props) {
        const teams = ref([]);
        const user = ref({});
        const showDetails = ref([]);

        watch(props.teams, (lab, prevLabel) => {
            teams.value = props.teams;
        }, {deep: true})

        const getTeamsRepositories = async () => {
            // teams.value = GetTeams();
        }

        onMounted(function () {
            getTeamsRepositories('');
            teams.value = props.teams;
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        return {
            user,
            teams,
            showDetails
        }
    }
}
</script>

<style scoped>

</style>
