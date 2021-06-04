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
                        <button class="btn btn-primary shadow-md mr-2" :disabled="isDisabled" @click="addSolutionTeam">{{$t('teams.addTeam')}}</button>
                    </div>
                    <!-- BEGIN: Users Layout -->
                    <div v-for="(team, index) in teamsSolution" :key="'team_' + index" class="intro-y col-span-6 xl:col-span-6 md:col-span-6 sm:col-span-12">
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
                                    <div class="text-gray-600 text-xs mt-0.5" v-if="team.users != undefined">
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
                                                <a :disabled="isDisabled" @click.prevent="del(member.id,team.id, index)" class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <TrashIcon></TrashIcon> Delete </a>
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
</template>

<script>
import {computed, onMounted, ref, watch} from "vue";
import GetTeams from '../../../compositions/GetTeams'
import GetInvites from '../../../compositions/GetInvites'
import AcceptInvite from '../../../compositions/AcceptInvite'
import AddTeam from '../../../compositions/AddTeam'
import AddSolutionTeam from '../../../compositions/AddSolutionTeam'
import AddTeamMember from '../../../compositions/AddTeamMember'
import {useToast} from "vue-toastification";
import Avatar from "../../../components/avatar/Avatar";
import Modal from "../../../components/Modal";

export default {
    name: "TeamsPanelSolution",
    components: {Avatar, Modal},
    props: {
        solution: Object
    },
    setup(props, {emit}) {
        const showDetails = ref([]);
        const isDisabled = ref(false);
        const teams = ref([]);
        const invites = ref([]);
        const user = ref({});
        const new_team_name = ref('');
        const new_team_member_email = ref('');
        const search = ref('');
        const toast = useToast();
        const show = ref(false);
        const temporary_team_id = ref(null);

        watch(props.solution.teams, (lab, prevLabel) => {
            teamsSolution.value = props.solution.teams;
        }, {deep: true})

        const teamsSolution = computed(() => {
            return props.solution.teams;
        });
        const getTeamsRepositories = async () => {
            teams.value = GetTeams();
        }

        const getInvitesRepositories = async () => {
            invites.value = GetInvites();
        }

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

        const del = async (member_id,team_id, index) => {
            axios.post('api/teams/user/member/delete', {member_id: member_id, team_id: team_id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        isDisabled.value = true;
                        toast.success(response.data.message);
                        teamsSolution[team_id].users.splice(index,1);
                        setTimeout(() =>{
                            isDisabled.value = false;
                        }, 2000);

                    } else {
                        isDisabled.value = true;
                        toast.error(response.data.message);
                        setTimeout(() =>{
                            isDisabled.value = false;
                        }, 2000);
                    }
                    setTimeout(() =>{
                        isDisabled.value = false;
                    }, 2000);
                })
            // await getTeamsRepositories();
        }

        const addSolutionTeam = async () => {
            if(new_team_name.value === '') {
                toast.error('Nazwa nie może być pusta');
                isDisabled.value=true;
            } else if (new_team_name.value.length < 3) {
                toast.error('Nazwa nie może mieć mniej niż 3 znaki');
                isDisabled.value=true;
            } else {
                await AddSolutionTeam(new_team_name.value, props.solution.id, (res) => {
                   teamsSolution.value.push(res);
                })
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
        const acceptInvite = async (id) => {
            await AcceptInvite(id)
            setTimeout(function () {
                getTeamsRepositories(search.value);
                getInvitesRepositories(search.value);
            }, 1000);
        }

        onMounted(function () {
            teamsSolution.value = new_team_name.value;
            getTeamsRepositories('');
            getInvitesRepositories('');
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })

        return {
            user,
            teams,
            addSolutionTeam,
            search,
            new_team_name,
            show,
            showAddToTeamModal,
            modalClosed,
            new_team_member_email,
            addMember,
            invites,
            acceptInvite,
            showDetails,
            isDisabled,
            del,
            teamsSolution
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
