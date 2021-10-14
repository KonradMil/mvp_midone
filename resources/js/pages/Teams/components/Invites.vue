<template>
    <div class="col-span-3">
                <h2 class="intro-y text-lg font-medium mt-5">{{$t('teams.invitations')}}</h2>
                <div class="grid-cols-12 grid">
                    <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-2">
                        <div class="mt-3">
                            <div v-if="invites.length === 0" class="intro-y text-lg text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                                Nie otrzymałeś jeszcze żadnych zaproszeń.
                            </div>
                            <div v-for="(invite, index) in invites" :key="'invite_' + index" class="intro-y">
                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                                        <Avatar :src="'/s3/avatars/' + invite.inviter.avatar" :username="invite.inviter.name + ' ' + invite.inviter.lastname" :size="40" color="#FFF" background-color="#5e50ac"/>
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">{{invite.team.name}}</div>
                                        <div class="text-gray-600 text-xs mt-0.5">
                                            Od: {{invite.inviter.name + ' ' + invite.inviter.lastname}}
                                        </div>
                                    </div>
                                    <div class="py-1 px-2 rounded-full text-xs text-center bg-theme-9 text-white cursor-pointer font-medium" @click="acceptInvite(invite.id, invite.team)">
                                        {{$t('teams.acceptInvite')}}
                                    </div>
                                </div>
                            </div>
                          <hr class="my-2"/>
                            <div v-if="invitesSent.length === 0" class="intro-y text-lg text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                                Nie wysłałeś jeszcze żadnych zaproszeń.
                            </div>
                            <div v-for="(invite, index) in invitesSent" :key="'inviteSent_' + index" class="intro-y">
                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden" v-if="invite.user != null">
                                        <Avatar :src="'/s3/avatars/' + invite.user.avatar" :username="invite.user.name + ' ' + invite.user.lastname" :size="40" color="#FFF" background-color="#5e50ac"/>
                                    </div>
                                    <div v-if="invite.user == null">
                                        <Avatar :src="''" :username="invite.email" :size="40" color="#FFF" background-color="#5e50ac"/>

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
</template>

<script>
import {getCurrentInstance, onMounted, reactive, ref, watch} from "vue";
import GetTeams from '../../../compositions/GetTeams'
import GetInvites from '../../../compositions/GetInvites'
import AcceptInvite from '../../../compositions/AcceptInvite'
import AddTeam from '../../../compositions/AddTeam'
import AddTeamMember from '../../../compositions/AddTeamMember'
import {useToast} from "vue-toastification";
import Avatar from "../../../components/avatar/Avatar";
import router from "../../../router";

export default {
    name: "Invites",
    components: {Avatar},
    props: {
        team: Object,
        guard: Boolean,
    },
    setup(props, {emit}) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const isDisabled = ref(false);
        const teams = ref([]);
        const invites = ref([]);
        const invitesSent = ref([]);
        const user = ref({});
        const new_team_name = ref('');
        const new_team_member_email = ref('');
        const search = ref('');
        const toast = useToast();
        const temporary_team_id = ref(null);
        const currentTeam_id = ref();
        const currentMember_id = ref();
        const width = ref('250px');
        watch(() => props.guard, (first, second) => {
            getInvitesRepositories(search.value);
        }, {});
        const getInvitesRepositories = async () => {

           GetInvites((res) => {
               invites.value = res.payload;
               invitesSent.value = res.sent;
           });
        }

        const pushTeam = async(team) => {
            emitter.emit('pushTeamList', {team: team});
        }

        const acceptInvite = async (id,team) => {
                await AcceptInvite(id)
                setTimeout(function () {
                    getInvitesRepositories(search.value);
                    emitter.emit('pushTeamList', {team: team});
                }, 1000);
        }

        onMounted(function () {

            getInvitesRepositories('');
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })

        return {

            user,
            teams,
            search,
            new_team_name,
            new_team_member_email,
            invites,
            acceptInvite,
            isDisabled,
            invitesSent,
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
