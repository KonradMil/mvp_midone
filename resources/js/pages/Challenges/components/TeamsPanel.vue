<template>
    <div class="grid grid-cols-12 gap-6 mt-5 col-span-8">
        <div class="col-span-12">
            <h2 class="intro-y text-lg font-medium mt-5">{{ $t('teams.teams') }}</h2>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-6 xl:col-span-6 md:col-span-6 sm:col-span-12">
                    <h5>
                        Dostępne zespoły
                    </h5>
                    <div class="grid grid-cols-12 gap-6 mt-2">
                        <div v-for="(team, index) in teams" :key="'team_' + index" class="intro-y col-span-12 xl:col-span-12 md:col-span-12 sm:col-span-12">
                            <div class="box">
                                <div class="flex flex-col lg:flex-row items-center p-5">
                                    <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                        <Avatar :username="team.name" color="#FFF" background-color="#5e50ac"/>
                                    </div>
                                    <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                        <a href="" class="font-medium">{{ team.name }}</a>
                                        <div class="text-gray-600 text-xs mt-0.5">
                                            {{ $t('teams.created') }}: {{ $dayjs(team.created_at).format('DD.MM.YYYY HH:mm') }}
                                        </div>
                                        <div class="text-gray-600 text-xs mt-0.5" v-if="team.users != undefined">
                                            {{ $t('teams.members') }}: {{ team.users.length }}
                                        </div>
                                    </div>
                                    <div class="flex mt-4 lg:mt-0">
                                        <button v-if="challenge.stage !== 3" class="btn btn-primary py-1 px-2 mr-2" @click.prevent="addToSelected(team.id,index)">{{ $t('teams.add') }}</button>
                                        <button class="btn btn-outline-secondary py-1 px-2" @click="showDetails[team.id] = !showDetails[team.id]">
                                            {{ $t('teams.details') }}
                                        </button>
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
                                                    <a href="" class="font-medium">{{ member.name + ' ' + member.lastname }}</a>
                                                    <div class="text-gray-600 mr-5 sm:mr-5" v-if="member.companies.length != 0">
                                                        {{ member.companies[0].company_name }}
                                                    </div>
                                                </div>
                                                <div class="flex justify-center items-center" v-if="member.id != user.id">
<!--                                                    <a :disabled="isDisabled" @click.prevent="del(member.id,team.id, index)" class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal">-->
<!--                                                        <TrashIcon></TrashIcon>-->
<!--                                                        Delete </a>-->
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

                <div class="intro-y col-span-6 xl:col-span-6 md:col-span-6 sm:col-span-12">
                    <h5 v-if="who == 'challenge'">
                        Zespoły dodane do wyzwania
                    </h5>
                    <h5 v-if="who == 'solution'">
                        Zespoły dodane do rozwiązania
                    </h5>
                    <div class="grid grid-cols-12 gap-6 mt-2">
                        <div v-for="(team, index) in teamsObject" :key="'team_' + index" class="intro-y col-span-12 xl:col-span-12 md:col-span-12 sm:col-span-12">
                            <div class="box">
                                <div class="flex flex-col lg:flex-row items-center p-5">
                                    <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                        <Avatar :username="team.name" color="#FFF" background-color="#5e50ac"/>
                                    </div>
                                    <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                        <a href="" class="font-medium">{{ team.name }}</a>
                                        <div class="text-gray-600 text-xs mt-0.5">
                                            {{ $t('teams.created') }}: {{ $dayjs(team.created_at).format('DD.MM.YYYY HH:mm') }}
                                        </div>
                                        <div class="text-gray-600 text-xs mt-0.5" v-if="team.users != undefined">
                                            {{ $t('teams.members') }}: {{ team.users.length }}
                                        </div>
                                    </div>
                                    <div class="flex mt-4 lg:mt-0">
                                        <button v-if="challenge.stage !== 3" class="btn btn-primary py-1 px-2 mr-2" @click="removeFromSelected(team,team.id, index)">Usuń</button>
                                        <button class="btn btn-outline-secondary py-1 px-2" @click="showDetails[team.id] = !showDetails[team.id]">
                                            {{ $t('teams.details') }}
                                        </button>
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
                                                    <a href="" class="font-medium">{{ member.name + ' ' + member.lastname }}</a>
                                                    <div class="text-gray-600 mr-5 sm:mr-5" v-if="member.companies.length != 0">
                                                        {{ member.companies[0].company_name }}
                                                    </div>
                                                </div>
                                                <div class="flex justify-center items-center" v-if="member.id != user.id">
<!--                                                    <a :disabled="isDisabled" @click.prevent="del(member.id,team.id, index)" class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal">-->
<!--                                                        <TrashIcon></TrashIcon>-->
<!--                                                        Delete </a>-->
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
            </div>
        </div>
        <!-- BEGIN: Users Layout -->
        <!-- BEGIN: Users Layout -->
    </div>
    <Modal :show="show" @closed="modalClosed">
        <h3 class="intro-y text-lg font-medium mt-5">{{ $t('teams.addMember') }}</h3>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div>
                {{ $t('teams.description') }}
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
import AddObjectTeam from '../../../compositions/AddObjectTeam'
import AddTeamMember from '../../../compositions/AddTeamMember'
import {useToast} from "vue-toastification";
import Avatar from "../../../components/avatar/Avatar";
import Modal from "../../../components/Modal";

export default {
    name: "TeamsPanel",
    components: {Avatar, Modal},
    props: {
        solution: Object,
        challenge: Object,
        who: String
    },
    setup(props, {emit}) {
        const showDetails = ref([]);
        const isDisabled = ref(false);
        const teams = ref([]);
        const user = ref({});
        const new_team_name = ref('');
        const new_team_member_email = ref('');
        const search = ref('');
        const toast = useToast();
        const show = ref(false);
        const temporary_team_id = ref(null);
        const teamsObject = ref([]);

        const object = computed(() => {
            if (props.who === 'challenge') {
                return props.challenge;
            } else {
                return props.solution;
            }
        });

        const getTeamsRepositories = async () => {
            if(props.who === 'solution'){
                GetTeams('', props.solution.id, props.who,(res) => {
                    teams.value = res;
                });
            }else{
                GetTeams('', props.challenge.id, props.who,(res) => {
                    teams.value = res;
                });
            }

        }
        const showAddToTeamModal = (id) => {
            if (temporary_team_id == null || temporary_team_id === id) {
                show.value = !show.value;
            } else {
                show.value = true;
            }
            temporary_team_id.value = id;
        }

        const modalClosed = () => {
            show.value = false;
            temporary_team_id.value = null;
        }

        const removeFromSelected = (team,id, index) => {
            let obj = {};
            if(props.who == 'challenge') {
                obj = props.challenge;
            } else {
                obj = props.solution;
            }
            axios.post('/api/teams/remove-from-selected', {team_id: id, type: props.who, object_id: obj.id})
                .then(response => {
                    if (response.data.success) {
                        teams.value.push(team);
                        toast.success('Rozłączono pomyślnie');
                        teamsObject.value.splice(index, 1);
                    } else {
                        toast.error('Błąd!');
                    }
                })
        }

        const addToSelected = (id,index) => {
             let obj = {};
            if(props.who == 'challenge') {
                obj = props.challenge;
            } else {
                obj = props.solution;
            }
            axios.post('/api/teams/add-to-selected', {team_id: id, type: props.who, object_id: obj.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Połączono pomyślnie');
                        teams.value.splice(index,1);
                        if (props.who === 'challenge') {
                            teamsObject.value.push(response.data.payload);
                        } else {
                            teamsObject.value.push(response.data.payload);
                        }
                    } else {
                        toast.error('Błąd!');
                    }
                })
        }

        const del = async (member_id, team_id, index) => {
            axios.post('api/teams/user/member/delete', {member_id: member_id, team_id: team_id})
                .then(response => {

                    if (response.data.success) {
                        isDisabled.value = true;
                        toast.success(response.data.message);
                        teamsObject[team_id].users.splice(index, 1);
                        setTimeout(() => {
                            isDisabled.value = false;
                        }, 2000);

                    } else {
                        isDisabled.value = true;
                        toast.error(response.data.message);
                        setTimeout(() => {
                            isDisabled.value = false;
                        }, 2000);
                    }
                    setTimeout(() => {
                        isDisabled.value = false;
                    }, 2000);
                })
        }

        const addObjectTeam = async () => {
            if (new_team_name.value === '') {
                toast.error('Nazwa nie może być pusta');
                isDisabled.value = true;
            } else if (new_team_name.value.length < 3) {
                toast.error('Nazwa nie może mieć mniej niż 3 znaki');
                isDisabled.value = true;
            } else {
                let id;
                if (props.who === 'challenge') {
                    id = props.challenge.id;
                } else {
                    id = props.solution.id;
                }
                await AddObjectTeam(props.who, new_team_name.value, id, (res) => {
                    teamsObject.value.push(res);
                })
                isDisabled.value = true;
            }
            setTimeout(() => {
                isDisabled.value = false;
            }, 5000);
        }

        const addMember = async () => {
            if (new_team_member_email.value === '') {
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
                toast.success('Wysłano zaproszenie do zespołu!')
            }
            setTimeout(() => {
                isDisabled.value = false;
            }, 2000);
        }

        const getObjectTeams = async () => {
            axios.post('/api/teams/object/get', {who: props.who, solution_id: props.solution.id, challenge_id: props.challenge.id})
                .then(response => {
                    if (response.data.success) {
                       teamsObject.value = response.data.payload
                    } else {
                    }
                })
        }

        onMounted(function () {
            getObjectTeams();
            teamsObject.value = new_team_name.value;
            getTeamsRepositories('');
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })

        return {
            user,
            teams,
            addObjectTeam,
            search,
            new_team_name,
            show,
            showAddToTeamModal,
            modalClosed,
            new_team_member_email,
            addMember,
            showDetails,
            isDisabled,
            del,
            teamsObject,
            addToSelected,
            removeFromSelected,
            object
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
