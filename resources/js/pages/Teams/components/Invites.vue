<template>
    <div>
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
</template>

<script>
import {onMounted, reactive, ref} from "vue";
import GetTeams from '../../../compositions/GetTeams'
import GetInvites from '../../../compositions/GetInvites'
import AcceptInvite from '../../../compositions/AcceptInvite'
import AddTeam from '../../../compositions/AddTeam'
import AddTeamMember from '../../../compositions/AddTeamMember'
import {useToast} from "vue-toastification";
import Avatar from "../../../components/avatar/Avatar";
import Modal from "../../../components/Modal";
import ModalPermission from "../../../components/ModalPermission";
import router from "../../../router";

export default {
    name: "Invites",
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

        // const userPermissions = reactive({
        //     acceptChallengeSolution: 0,
        //     acceptChallengeOffer: 0,
        //     publishChallenge: false,
        // });


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
                        console.log('error');
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
                        console.log(publishChallenge.value + '-> publishChallenge');
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
            console.log('asdadsadsadas');
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
                    // console.log(response.data)
                    if (response.data.success) {
                        isDisabled.value = true;
                        toast.success(response.data.message);
                        teams.value.splice(index, 1);
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

        const del = async (member_id,team_id) => {
            axios.post('api/teams/user/delete', {member_id: member_id, team_id: team_id})
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
            console.log('ASDADSADSAFDSAFDDSAFDSF');
            getTeamsRepositories('');
            getInvitesRepositories('');
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })

        return {
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
