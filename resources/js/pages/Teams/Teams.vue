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
                                                <a href="" class="font-medium">{{ member.name + ' ' + member.lastname }} - {{member.type}}</a>
                                                <div class="text-gray-600 mr-5 sm:mr-5" v-if="member.companies.length != 0">
                                                     {{member.companies[0].company_name}}
                                                </div>
                                            </div>
                                            <div class="flex justify-center items-center" v-if="team.owner_id == user.id">
<!--                                                <button class="btn btn-outline-secondary py-1 px-2" @click="showPermissions[member.id] = !showPermissions[member.id]">-->
<!--                                                    Uprawnienia-->
<!--                                                </button>-->
                                                <button class="btn btn-outline-secondary py-1 px-2" @click="showMemberPermissionModal(team.id, member.id)">
                                                    {{ $t('global.permissions') }}
                                                </button>
                                                <a v-if="team.owner_id != member.id" :disabled="isDisabled" @click.prevent="del(member.id,team.id)" class="flex items-center text-theme-6 pl-2" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <TrashIcon></TrashIcon> Delete </a>
                                            </div>
                                            <div class="font-medium text-gray-700 dark:text-gray-600">
                                            </div>
                                            <div class="flex flex-col lg:flex-row items-center p-5" v-if="showPermissions[member.id] === true">
                                                <div class="intro-y box w-full">
                                                    <div
                                                        class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm "
                                                    >
                                                        <input
                                                            id="rodo"
                                                            type="checkbox"
                                                            class="form-check-input border mr-2 ring-0"
                                                            v-model="member.pivot.acceptChallengeOffer"
                                                            disabled
                                                        />
                                                        <label class="cursor-pointer select-none" for="rodo"
                                                        >Publish challenge</label
                                                        >
                                                    </div>
                                                    <div
                                                        class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"
                                                    >
                                                        <input
                                                            id="rodo3"
                                                            type="checkbox"
                                                            class="form-check-input border mr-2 ring-0"
                                                            :checked="acceptChallengeOffer"
                                                            disabled
                                                        />
                                                        <label class="cursor-pointer select-none" for="rodo3"
                                                        >Accept challenge offer</label
                                                        >
                                                    </div>
                                                    <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5">
                                                        <input
                                                            id="rodo2"
                                                            type="checkbox"
                                                            class="form-check-input border mr-2 ring-0"
                                                            :checked="publishSolution"
                                                            disabled/>
                                                        <label class="cursor-pointer select-none" for="rodo2">
                                                            Publish Solution
                                                        </label>
                                                    </div>
                                                    <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5">
                                                        <input
                                                            id="rodo2"
                                                            type="checkbox"
                                                            class="form-check-input border mr-2 ring-0"
                                                            :checked="publishSolution"
                                                            disabled/>
                                                        <label class="cursor-pointer select-none" for="rodo2">
                                                            Add solution offer
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-3">
                <h2 class="intro-y text-lg font-medium mt-5">{{$t('teams.invitations')}}</h2>
                <div class="grid-cols-12 grid">
                    <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-2">
                        <div class="mt-5">
                            <div v-if="invites.length == 0" class="intro-y text-lg text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                                Nie otrzymałeś jeszcze żadnych zaproszeń.
                            </div>
                            <div v-for="(invite, index) in invites" :key="'invite_' + index" class="intro-y">
                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                                        <Avatar :src="'/s3/avatars/' + invite.inviter.avatar" :username="invite.inviter.name + ' ' + invite.inviter.lastname" :size="40" color="#FFF" background-color="#930f68"/>
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">{{invite.team.name}}</div>
                                        <div class="text-gray-600 text-xs mt-0.5">
                                            Od: {{invite.inviter.name + ' ' + invite.inviter.lastname}}
                                        </div>
                                    </div>
                                    <div class="py-1 px-2 rounded-full text-xs text-center bg-theme-9 text-white cursor-pointer font-medium" @click="acceptInvite(invite.id)">
                                        {{$t('teams.acceptInvite')}}
                                    </div>
                                </div>
                            </div>
                          <hr class="my-2"/>
                            <div v-for="(invite, index) in invitesSent" :key="'inviteSent_' + index" class="intro-y">
                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden" v-if="invite.user != null">
                                        <Avatar :src="'/s3/avatars/' + invite.user.avatar" :username="invite.user.name + ' ' + invite.user.lastname" :size="40" color="#FFF" background-color="#930f68"/>
                                    </div>
                                    <div v-if="invite.user == null">
                                        <Avatar :src="''" :username="invite.email" :size="40" color="#FFF" background-color="#930f68"/>

                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">{{invite.team.name}}</div>
                                        <div class="text-gray-600 text-xs mt-0.5"  v-if="invite.user != null">
                                            Do: {{invite.user.name + ' ' + invite.user.lastname}}
                                        </div>
                                        <div class="text-gray-600 text-xs mt-0.5"  v-if="invite.user == null">
                                            Do: {{invite.email}}
                                        </div>
                                    </div>
                                    <div class="py-1 px-2 rounded-full text-xs text-center bg-theme-27 text-white cursor-pointer font-medium">
                                        Wysłano
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            <div class="intro-y box w-full">
                <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm ">
                    <input
                        id="publishChallenge"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        v-model="publishChallenge" />
                    <label class="cursor-pointer select-none" for="publishChallenge">{{ $t('global.publishChallenge') }}</label>
                </div>
                <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                    <input
                        id="publishSolution"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="publishSolution"/>
                    <label class="cursor-pointer select-none" for="publishSolution">{{ $t('global.publishSolution') }}</label>
                </div>
                <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                    <input
                        id="acceptChallengeOffer"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="acceptChallengeOffer"/>
                    <label class="cursor-pointer select-none" for="acceptChallengeOffer">{{ $t('global.acceptChallengeOffer') }}</label>
                </div>
                <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                    <input
                        id="addSolutionOffer"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="addSolutionOffer"/>
                    <label class="cursor-pointer select-none" for="addSolutionOffer">{{ $t('global.addSolutionOffer') }}</label>
                </div>
                <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5">
                    <input
                        id="acceptChallengeSolution"
                        type="checkbox"
                        class="form-check-input border mr-2 ring-0"
                        :checked="acceptChallengeSolution"/>
                    <label class="cursor-pointer select-none" for="acceptChallengeSolution">{{ $t('global.acceptChallengeSolution') }}</label>
                </div>
                <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5">
                    <button class="btn btn-outline-secondary py-1 px-2" @click="savePermissions(currentTeam_id,currentMember_id)">
                        Zapisz
                    </button>
                </div>
            </div>
        </div>
    </ModalPermission>
</template>

<script>
import {onMounted, ref} from "vue";
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

export default {
    name: "Teams",
    components: {Avatar, Modal, ModalPermission},
    props: {
        team: Object
    },
    setup(props, {emit}) {
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
        const acceptChallengeOffer = ref(false);
        const publishSolution = ref(false);
        const addSolutionOffer = ref(false);
        const acceptChallengeSolution = ref(false);
        const showMemberPermission = ref(false);
        const currentTeam_id = ref();
        const currentMember_id = ref();
        const width = ref('250px');

        const getPermissions = (team_id,member_id) => {
            axios.post('/api/teams/user/get/permissions', { team_id: team_id, member_id: member_id})
                .then(response => {
                    if (response.data.success) {
                        publishChallenge.value = response.data.payload.publishChallenge;
                        publishSolution.value = response.data.payload.publishSolution;
                        acceptChallengeOffer.value = response.data.payload.acceptChallengeOffer;
                        addSolutionOffer.value = response.data.payload.addSolutionOffer;
                        acceptChallengeSolution.value = response.data.payload.acceptChallengeSolution;
                    }else{
                        console.log('error');
                    }
                })
        }

        const savePermissions = (team_id,member_id) => {
            axios.post('/api/teams/user/save/permissions', { team_id: team_id, member_id: member_id,
                publishChallenge: publishChallenge.value, publishSolution: publishSolution.value, acceptChallengeOffer: acceptChallengeOffer.value,
                addSolutionOffer: addSolutionOffer.value, acceptChallengeSolution: acceptChallengeSolution.value})
                .then(response => {
                    if (response.data.success) {
                        toast.success(response.data.message);
                        modalPermClosed();
                    }else{
                        console.log('error');
                    }
                })
        }

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

        const del = async (member_id,team_id) => {
            axios.post('api/teams/user/member/delete', {member_id: member_id, team_id: team_id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        isDisabled.value = true;
                        toast.success(response.data.message);
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
                    getInvitesRepositories();
                    new_team_member_email.value = '';
                    modalClosed();
                }, 1000);
                toast.success('Wysłano zaproszenie do zespołu!')
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
            publishChallenge,
            acceptChallengeOffer,
            publishSolution,
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
