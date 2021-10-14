<template>
    <div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-9">
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
                        <button class="btn btn-primary shadow-md mr-2" :disabled="isDisabled" @click="addTeam">{{$t('teams.addTeam')}}</button>

                        <div class="hidden md:block mx-auto text-gray-600">

                        </div>
                        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
<!--                            <div class="w-56 relative text-gray-700 dark:text-gray-300">-->
<!--                                <input-->
<!--                                    type="text"-->
<!--                                    class="form-control w-56 box pr-10 placeholder-theme-13"-->
<!--                                    :placeholder="$t('teams.find')"-->
<!--                                    v-model="search"-->
<!--                                />-->
<!--                                <SearchIcon-->
<!--                                    class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"-->
<!--                                />-->
<!--                            </div>-->
                        </div>
                    </div>
                    <!-- BEGIN: Users Layout -->
                    <div v-for="(team, index) in teams" :key="'team_' + index" class="intro-y col-span-6 xl:col-span-6 md:col-span-6 sm:col-span-12">
                        <div class="box">
                            <div class="flex flex-col lg:flex-row items-center p-5">
                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                    <Avatar :username="team.name" color="#FFF" background-color="#5e50ac"/>
                                </div>
                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                    <a class="font-medium cursor-pointer">{{ team.name }}</a>
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
                                    <div class="pl-2">
                                        <a @click.prevent="delTeam(team.id,index)" v-if="team.owner_id === user.id" class="flex items-center text-theme-6 pl-2 cursor-pointer">
                                            <Tippy
                                                tag="a"
                                                class="dark:text-gray-300 text-theme-600"
                                                content="Usuń">
                                                <TrashIcon/>
                                            </Tippy>
                                        </a>
<!--                                    <button class="btn btn-danger py-1 px-2 mr-2" >-->
<!--                                        <TrashIcon></TrashIcon>-->
<!--                                    </button>-->
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col lg:flex-row items-center p-5" v-if="showDetails[team.id] === true">
                                <div class="intro-y box w-full">
                                    <div class="p-5">
                                        <div v-for="(member, index) in team.users" class="relative flex items-center" :key="'member_' + index">
                                            <div class="w-12 h-12 flex-none image-fit">
                                                <Avatar :src="'/s3/avatars/' + member.avatar" :username="member.name + ' ' + member.lastname" :size="40" color="#FFF" background-color="#5e50ac"/>
                                            </div>
                                            <div class="ml-4 mr-auto">
                                                <a class="font-medium cursor-pointer">{{ member.name + ' ' + member.lastname }} - {{member.type}}</a>
                                                <div class="text-gray-600 mr-5 sm:mr-5" v-if="member.companies.length != 0">
                                                     {{member.companies[0].company_name}}
                                                </div>
                                            </div>
                                            <div class="flex justify-center items-center" v-if="team.owner_id == user.id && member.id !== user.id">
                                                <button class="btn btn-outline-secondary py-1 px-2" @click="showMemberPermissionModal(team.id, member.id)">
                                                    {{ $t('global.permissions') }}
                                                </button>
                                                <a v-if="team.owner_id != member.id" :disabled="isDisabled" @click.prevent="del(member,team)" class="flex items-center text-theme-6 pl-2 cursor-pointer">
                                                    <Tippy
                                                        tag="a"
                                                        class="dark:text-gray-300 text-theme-600"
                                                        content="Usuń">
                                                        <TrashIcon/>
                                                    </Tippy>
                                                </a>
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
            <Invites :guard="guard"></Invites>
<!--            <div class="col-span-3">-->
<!--                <h2 class="intro-y text-lg font-medium mt-5">{{$t('teams.invitations')}}</h2>-->
<!--                <div class="grid-cols-12 grid">-->
<!--                    <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-2">-->
<!--                        <div class="mt-5">-->
<!--                            <div v-if="invites.length == 0" class="intro-y text-lg text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">-->
<!--                                Nie otrzymałeś jeszcze żadnych zaproszeń.-->
<!--                            </div>-->
<!--                            <div v-for="(invite, index) in invites" :key="'invite_' + index" class="intro-y">-->
<!--                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">-->
<!--                                    <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">-->
<!--                                        <Avatar :src="'/s3/avatars/' + invite.inviter.avatar" :username="invite.inviter.name + ' ' + invite.inviter.lastname" :size="40" color="#FFF" background-color="#5e50ac"/>-->
<!--                                    </div>-->
<!--                                    <div class="ml-4 mr-auto">-->
<!--                                        <div class="font-medium">{{invite.team.name}}</div>-->
<!--                                        <div class="text-gray-600 text-xs mt-0.5">-->
<!--                                            Od: {{invite.inviter.name + ' ' + invite.inviter.lastname}}-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="py-1 px-2 rounded-full text-xs text-center bg-theme-9 text-white cursor-pointer font-medium" @click="acceptInvite(invite.id)">-->
<!--                                        {{$t('teams.acceptInvite')}}-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                          <hr class="my-2"/>-->
<!--                            <div v-for="(invite, index) in invitesSent" :key="'inviteSent_' + index" class="intro-y">-->
<!--                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">-->
<!--                                    <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden" v-if="invite.user != null">-->
<!--                                        <Avatar :src="'/s3/avatars/' + invite.user.avatar" :username="invite.user.name + ' ' + invite.user.lastname" :size="40" color="#FFF" background-color="#5e50ac"/>-->
<!--                                    </div>-->
<!--                                    <div v-if="invite.user == null">-->
<!--                                        <Avatar :src="''" :username="invite.email" :size="40" color="#FFF" background-color="#5e50ac"/>-->

<!--                                    </div>-->
<!--                                    <div class="ml-4 mr-auto">-->
<!--                                        <div class="font-medium">{{invite.team.name}}</div>-->
<!--                                        <div class="text-gray-600 text-xs mt-0.5"  v-if="invite.user != null">-->
<!--                                            Do: {{invite.user.name + ' ' + invite.user.lastname}}-->
<!--                                        </div>-->
<!--                                        <div class="text-gray-600 text-xs mt-0.5"  v-if="invite.user == null">-->
<!--                                            Do: {{invite.email}}-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    <div class="py-1 px-2 rounded-full text-xs text-center bg-theme-27 text-white cursor-pointer font-medium">-->
<!--                                        Wysłano-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <!-- BEGIN: Users Layout -->
        </div>
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
    <ModalPermission :show="showMemberPermission" @closed="modalPermClosed">
        <h3 class="intro-y text-lg font-medium mt-5">{{ $t('global.permissions') }}</h3>
          <div class="flex flex-col lg:flex-row items-center p-5">
            <div class="intro-y box w-full divide-y divide-fuchsia-300">
                <div v-if="user.type === 'investor'" class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                    <input
                        id="publishchallenge"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="publishChallenge"
                        v-model="publishChallenge"/>
                    <label class="cursor-pointer select-none" for="publishChallenge">{{ $t('global.publishChallenge') }}</label>
                </div>
                <div v-if="user.type === 'investor'" class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pt-2">
                    <input
                        id="editchallenge"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="editChallenge"
                        v-model="editChallenge"/>
                    <label class="cursor-pointer select-none" for="editChallenge">{{ $t('global.editChallenge') }}</label>
                </div>
                <div v-if="user.type === 'investor'" class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pt-2">
                    <input
                        id="acceptChallengeOffer"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="acceptChallengeOffer"
                        v-model="acceptChallengeOffer"/>
                    <label class="cursor-pointer select-none" for="acceptChallengeOffer">{{ $t('global.acceptChallengeOffer') }}</label>
                </div>
                <div v-if="user.type === 'investor'" class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5 pt-2">
                    <input
                        id="acceptChallengeSolution"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="acceptChallengeSolution"
                        v-model="acceptChallengeSolution"/>
                    <label class="cursor-pointer select-none" for="acceptChallengeSolution">{{ $t('global.acceptChallengeSolution') }}</label>
                </div>
                <div v-if="user.type === 'integrator'" class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                    <input
                        id="publishSolution"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="publishSolution"
                        v-model="publishSolution"/>
                    <label class="cursor-pointer select-none" for="publishSolution">{{ $t('global.publishSolution') }}</label>
                </div>
                <div v-if="user.type === 'integrator'" class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pt-2">
                    <input
                        id="addSolutionOffer"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="addSolutionOffer"
                        v-model="addSolutionOffer"/>
                    <label class="cursor-pointer select-none" for="addSolutionOffer">{{ $t('global.addSolutionOffer') }}</label>
                </div>
                <div v-if="user.type === 'integrator'" class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pt-2">
                    <input
                        id="canEditSolution"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="canEditSolution"
                        v-model="canEditSolution"/>
                    <label class="cursor-pointer select-none" for="canEditSolution">{{ $t('global.canEditSolution') }}</label>
                </div>
                <div v-if="user.type === 'integrator'" class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5 pt-2">
                    <input
                        id="canDeleteSolution"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="canDeleteSolution"
                        v-model="canDeleteSolution"/>
                    <label class="cursor-pointer select-none" for="canDeleteSolution">{{ $t('global.canDeleteSolution') }}</label>
                </div>
                <div class="flex flex-col lg:flex-row items-center p-5" style="justify-content: center;">
                <button class="btn btn-outline-secondary py-1 px-2" @click="savePermissions(currentTeam_id,currentMember_id)">
                    {{ $t('global.save') }}
                </button>
                </div>
            </div>
        </div>
    </ModalPermission>
</template>

<script>
import {getCurrentInstance, onMounted, reactive, ref} from "vue";
import GetTeams from '../../compositions/GetTeams'
import GetInvites from '../../compositions/GetInvites'
import AcceptInvite from '../../compositions/AcceptInvite'
import AddTeam from '../../compositions/AddTeam'
import AddTeamMember from '../../compositions/AddTeamMember'
import {useToast} from "vue-toastification";
import Avatar from "../../components/avatar/Avatar";
import Modal from "../../components/Modal";
import ModalPermission from "../../components/ModalPermission";
import router from "../../router";
import Invites from "./components/Invites";

export default {
    name: "Teams",
    components: {Avatar, Modal, ModalPermission, Invites},
    props: {
        team: Object
    },
    setup(props, {emit}) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const showDetails = ref([]);
        const showPermissions = ref([]);
        const isDisabled = ref(false);
        const teams = ref([]);
        const invites = ref([]);
        const invitesSent = ref([]);
        const user = ref({});
        const new_team_name = ref('');
        const new_team_member_email = ref('');
        const search = ref('');
        const toast = useToast();
        const show = ref(false);
        const temporary_team_id = ref(null);
        const publishChallenge = ref(false);
        const editChallenge = ref(false);
        const acceptChallengeOffer = ref(false);
        const publishSolution = ref(false);
        const canEditSolution = ref(false);
        const canDeleteSolution = ref(false);
        const addSolutionOffer = ref(false);
        const acceptChallengeSolution = ref(false);
        const showMemberPermission = ref(false);
        const currentTeam_id = ref();
        const currentMember_id = ref();
        const width = ref('250px');
        const guard = ref(false);



        const getPermissions = (team_id,member_id) => {
            axios.post('/api/teams/user/get/permissions', { team_id: team_id, member_id: member_id})
                .then(response => {
                    if (response.data.success) {
                        publishChallenge.value = response.data.payload.publishChallenge;
                        editChallenge.value = response.data.payload.editChallenge;
                        publishSolution.value = response.data.payload.publishSolution;
                        canEditSolution.value = response.data.payload.canEditSolution;
                        canDeleteSolution.value = response.data.payload.canDeleteSolution;
                        acceptChallengeOffer.value = response.data.payload.acceptChallengeOffer;
                        addSolutionOffer.value = response.data.payload.addSolutionOffer;
                        acceptChallengeSolution.value = response.data.payload.acceptChallengeSolution;
                    }else{

                    }
                })
        }

        const savePermissions = (team_id,member_id) => {
            axios.post('/api/teams/user/save/permissions', { team_id: team_id, member_id: member_id,
                publishChallenge: publishChallenge.value,
                editChallenge: editChallenge.value,
                publishSolution: publishSolution.value,
                canEditSolution: canEditSolution.value,
                canDeleteSolution: canDeleteSolution.value,
                acceptChallengeOffer: acceptChallengeOffer.value,
                addSolutionOffer: addSolutionOffer.value,
                acceptChallengeSolution: acceptChallengeSolution.value})
                .then(response => {
                    if (response.data.success) {

                        toast.success(response.data.message);
                        modalPermClosed();
                    }else{

                    }
                })
        }

        emitter.on('pushTeamList', e => {
            getTeamsRepositories(search.value);
        });

        const getTeamsRepositories = async () => {
            GetTeams('','','teams',(res) => {
                teams.value = res;
            });
        }

        const getInvitesRepositories = async () => {

           GetInvites((res) => {
               invites.value = res.payload;
               invitesSent.value = res.sent;
           });
        }

        const showAddToTeamModal = (id) => {
            if(temporary_team_id == null || temporary_team_id === id) {
                show.value = !show.value;
            } else {
                show.value = true;
            }
            temporary_team_id.value =  id;
        }

        const showMemberPermissionModal = (team_id, member_id) => {
            currentTeam_id.value = team_id;
            currentMember_id.value = member_id;
            getPermissions(team_id,member_id);
            if(temporary_team_id == null || temporary_team_id === team_id) {
                showMemberPermission.value = !showMemberPermission.value;
            } else {
                showMemberPermission.value = true;
            }
            temporary_team_id.value =  team_id;

        }

        const modalPermClosed = () => {
            showMemberPermission.value = false;
            temporary_team_id.value = null;
        }

        const modalClosed = () => {
            show.value = false;
            temporary_team_id.value = null;
        }

        const delTeam = async (team_id,index) => {
            axios.post('/api/teams/user/delete', {team_id: team_id})
                .then(response => {

                    if (response.data.success) {
                        isDisabled.value = true;
                        toast.success(response.data.message);
                        teams.value.splice(index, 1);
                        setTimeout(() =>{
                            isDisabled.value = false;
                        }, 1000);
                    } else {
                        isDisabled.value = true;
                        toast.error(response.data.message);
                        setTimeout(() =>{
                            isDisabled.value = false;
                        }, 1000);
                    }
                })
        }

        const del = async (member,team) => {
            axios.post('api/teams/user/member/delete', {member_id: member.id, team_id: team.id})
                .then(response => {

                    if (response.data.success) {
                        team.value.users.splice(member,1);
                        isDisabled.value = true;
                        toast.success(response.data.message);
                        setTimeout(() =>{
                            isDisabled.value = false;
                        }, 1000);

                    } else {
                        isDisabled.value = true;
                        toast.error(response.data.message);
                        setTimeout(() =>{
                            isDisabled.value = false;
                        }, 1000);
                    }
                })
            await getTeamsRepositories();
        }

        const addTeam = async () => {
            if(new_team_name.value === '') {
                toast.error('Nazwa nie może być pusta');
                isDisabled.value=true;
            } else if (new_team_name.value.length < 3) {
                toast.error('Nazwa nie może mieć mniej niż 3 znaki');
                isDisabled.value=true;
            } else {
                await AddTeam(new_team_name.value)
                    setTimeout(function () {
                        getTeamsRepositories(search.value);
                        new_team_name.value = '';
                    }, 1000);
                toast.success('Dodałeś zespół!')
                isDisabled.value=true;

            }
            setTimeout(()=>{
                isDisabled.value=false;
            },1000);
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
                    getInvitesRepositories();
                    new_team_member_email.value = '';
                    guard.value = true;
                    modalClosed();
                }, 1000);
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

            getTeamsRepositories('');
            getInvitesRepositories('');
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })

        return {
            guard,
            editChallenge,
            publishChallenge,
            acceptChallengeOffer,
            publishSolution,
            canEditSolution,
            canDeleteSolution,
            addSolutionOffer,
            acceptChallengeSolution,
            user,
            teams,
            addTeam,
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
            showPermissions,
            isDisabled,
            del,
            delTeam,
            invitesSent,
            showMemberPermission,
            showMemberPermissionModal,
            modalPermClosed,
            savePermissions,
            currentTeam_id,
            currentMember_id,
            width
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
