<template>
    <div class="grid grid-cols-12 gap-6 mt-5 col-span-8">
        <div class="col-span-12">
            <h2 class="intro-y text-lg font-medium mt-5">{{$t('teams.teams')}}</h2>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div
                    class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2"
                >
                    <div class="w-56 relative text-gray-700 dark:text-gray-300 mr-4">
                        <input
                            type="text"
                            class="form-control w-56 box pr-10 placeholder-theme-13"
                            :placeholder="$t('teams.name')"
                            v-model="new_team_name"
                        />
                    </div>
                    <button class="btn btn-primary shadow-md mr-2" :disabled="isDisabled" @click="addChallengeTeam">{{$t('teams.addTeam')}}</button>
                </div>
                <!-- BEGIN: Users Layout -->
                <div v-for="(team, index) in teams" :key="'team_' + index" class="intro-y col-span-6 xl:col-span-6 md:col-span-6 sm:col-span-12">
                    <div class="box">
                        <div class="flex flex-col lg:flex-row items-center p-5">
                            <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                <Avatar :username="team.name" color="#FFF" background-color="#930f68"/>
                            </div>
                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                <a href="" class="font-medium">{{ team.name }}</a>
                                <div class="text-gray-600 text-xs mt-0.5">
                                    {{$t('teams.created')}}: {{ $dayjs(team.created_at).format('DD.MM.YYYY HH:mm') }}
                                </div>
                                <div class="text-gray-600 text-xs mt-0.5">
                                    {{ $t('teams.members')}}: {{ team.users.length }}
                                </div>
                            </div>
                            <div class="flex mt-4 lg:mt-0">
                                <button class="btn btn-primary py-1 px-2 mr-2" @click="showAddToTeamModal(team.id)" v-if="team.owner_id === user.id">{{$t('teams.add')}}</button>
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
                                            <Avatar :src="'/s3/avatars/' + member.avatar" :username="member.name + ' ' + member.lastname" :size="40" color="#FFF" background-color="#930f68"/>
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <a href="" class="font-medium">{{ member.name + ' ' + member.lastname }}</a>
                                            <div class="text-gray-600 mr-5 sm:mr-5" v-if="member.companies.length != 0">
                                                {{member.companies[0].company_name}}
                                            </div>
                                        </div>
                                        <div class="flex justify-center items-center" v-if="member.id != user.id">
                                            <a :disabled="isDisabled" @click.prevent="del(member.id,team.id)" class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <TrashIcon></TrashIcon> Delete </a>
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
        <!-- BEGIN: Users Layout -->
    </div>
    <Modal :show="show" @closed="modalClosed">
        <h3 class="intro-y text-lg font-medium mt-5">{{$t('teams.addMember')}}</h3>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div>
                {{$t('teams.description')}}
            </div>
        </div>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Email" v-model="new_team_member_email"/>
                <button class="btn btn-primary shadow-md mr-2" :disabled="isDisabled" @click="addMember">{{ $t('teams.invite') }}</button>
            </div>
        </div>
    </Modal>


<!--    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">-->
<!--        <div class="grid grid-cols-12 gap-6">-->
<!--            &lt;!&ndash; BEGIN: Announcement &ndash;&gt;-->
<!--            <div class="intro-y box col-span-12 xxl:col-span-12">-->
<!--                <div-->
<!--                    class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"-->
<!--                >-->
<!--                    <h2 class="font-medium text-base mr-auto">{{$t('teams.teams')}}</h2>-->
<!--                </div>-->
<!--                <div class="px-5 py-5 grid grid-cols-12">-->
<!--                    <div-->
<!--                        v-for="(team, index) in teams"-->
<!--                        :key="'team_' + index"-->
<!--                        class="intro-y col-span-6 xl:col-span-6 md:col-span-6 sm:col-span-12"-->
<!--                    >-->
<!--                        <div class="box">-->
<!--                            <div class="flex flex-col lg:flex-row items-center p-5">-->
<!--                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">-->
<!--                                    <Avatar :username="team.name" color="#FFF" background-color="#930f68"/>-->
<!--                                </div>-->
<!--                                <div-->
<!--                                    class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0"-->
<!--                                >-->
<!--                                    <a href="" class="font-medium">{{ team.name }}</a>-->
<!--                                    <div class="text-gray-600 text-xs mt-0.5">-->
<!--                                        {{$t('teams.created')}}: {{ $dayjs(team.created_at).format('DD.MM.YYYY HH:mm') }}-->
<!--                                    </div>-->
<!--                                    <div class="text-gray-600 text-xs mt-0.5">-->
<!--                                        {{ $t('teams.members')}}: {{ team.users.length }}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="flex mt-4 lg:mt-0">-->
<!--                                    <button class="btn btn-outline-secondary py-1 px-2" @click="showDetails[team.id] = !showDetails[team.id]">-->
<!--                                        {{$t('teams.details')}}-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="flex flex-col lg:flex-row items-center p-5" v-if="showDetails[team.id] === true">-->
<!--                                <div class="intro-y box w-full pb-3">-->
<!--                                    <div class="p-5">-->
<!--                                        <div v-for="(member, index) in team.users" class="relative flex items-center" :key="'member_' + index">-->
<!--                                            <div class="w-12 h-12 flex-none image-fit">-->
<!--                                                <Avatar :src="'/s3/avatars/' + member.avatar" :username="member.name + ' ' + member.lastname" :size="40" color="#FFF" background-color="#930f68"/>-->
<!--                                            </div>-->
<!--                                            <div class="ml-4 mr-auto">-->
<!--                                                <a href="" class="font-medium">{{ member.name + ' ' + member.lastname }}</a>-->
<!--                                                <div class="text-gray-600 mr-5 sm:mr-5" v-if="member.companies.length != 0">-->
<!--                                                    {{member.companies[0].company_name}}-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="font-medium text-gray-700 dark:text-gray-600">-->

<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            &lt;!&ndash; END: Announcement &ndash;&gt;-->
<!--        </div>-->
<!--    </div>-->
</template>

<script>
import {computed, onMounted, reactive, ref, watch} from "vue";
import GetTeams from "../../../compositions/GetTeams";
import Avatar from "../../../components/avatar/Avatar";
import AddTeamMember from '../../../compositions/AddTeamMember'
import AddChallengeTeam from "../../../compositions/AddChallengeTeam";
import Modal from "../../../components/Modal";

export default {
    name: "TeamsPanel",
    props: {
        teams: Object,
        id: Number
    },
    components: {Avatar, Modal},
    setup(props) {
        const new_team_member_email = ref('');
        const new_team_name = ref('');
        const teams = ref([]);
        const user = ref({});
        const showDetails = ref([]);
        const temporary_team_id = ref(null);
        const show = ref(false);


        const showAddToTeamModal = (id) => {
            if(temporary_team_id == null || temporary_team_id === id) {
                show.value = !show.value;
            } else {
                show.value = true;
            }
            temporary_team_id.value =  id;
        }

        const modalClosed = () => {
            show.value = false;
            temporary_team_id.value = null;
        }

        watch(props.teams, (lab, prevLabel) => {
            teams.value = props.teams;
        }, {deep: true})

        const getTeamsRepositories = async () => {
            // teams.value = GetTeams();
        }

        const addChallengeTeam = async () => {
            if(new_team_name.value === '') {
                toast.error('Nazwa nie może być pusta');
                isDisabled.value=true;
            } else if (new_team_name.value.length < 3) {
                toast.error('Nazwa nie może mieć mniej niż 3 znaki');
                isDisabled.value=true;
            } else {
                console.log(new_team_name.value + ' -> new_team_name.value');
                console.log(props.solution.id + ' -> props.solution.id');

                await AddChallengeTeam(new_team_name.value, props.id)
                // setTimeout(function () {
                //     getTeamsRepositories(search.value);
                //     new_team_name.value = '';
                //     modalClosed();
                // }, 1000);
                isDisabled.value=true;
            }
            setTimeout(()=>{
                isDisabled.value=false;
            },5000);
        }
        const addMember = async () => {
            if(new_team_member_email.value === '') {
                isDisabled.value = true;
                toast.error('Email nie może być pusty');
            } else if (new_team_member_email.value.length < 3) {
                isDisabled.value = true;
                toast.error('Email nie może mieć mniej niż 3 znaki');
            } else {
                isDisabled.value = true;
                await AddTeamMember(new_team_member_email.value, temporary_team_id.value)
                setTimeout(function () {
                    getTeamsRepositories(search.value);
                    new_team_member_email.value = '';
                }, 1000);
                toast.success('Success!')
            }
            setTimeout(() =>{
                isDisabled.value = false;
            }, 2000);
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
            showDetails,
            new_team_name,
            new_team_member_email,
            addChallengeTeam,
            addMember,
            showAddToTeamModal,
            modalClosed
        }
    }
}
</script>

<style scoped>

</style>
