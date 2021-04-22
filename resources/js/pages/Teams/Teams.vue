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
                        <button class="btn btn-primary shadow-md mr-2" @click="addTeam">{{$t('teams.addTeam')}}</button>

                        <div class="hidden md:block mx-auto text-gray-600">

                        </div>
                        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                            <div class="w-56 relative text-gray-700 dark:text-gray-300">
                                <input
                                    type="text"
                                    class="form-control w-56 box pr-10 placeholder-theme-13"
                                    :placeholder="$t('teams.find')"
                                    v-model="search"
                                />
                                <SearchIcon
                                    class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"
                                />
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN: Users Layout -->
                    <div
                        v-for="(team, index) in teams.list"
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
                                        Utworzono: {{ $dayjs(team.created_at).format('DD.MM.YYYY HH:mm') }}
                                    </div>
                                    <div class="text-gray-600 text-xs mt-0.5">
                                        Członków: {{ team.users.length }}
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
            <div class="col-span-3">
                <h2 class="intro-y text-lg font-medium mt-5">{{$t('teams.invitations')}}</h2>
                <div class="grid-cols-12 grid">
                    <div
                        class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-2"
                    >
                        <div class="mt-5">
                            <div
                                v-for="(invite, index) in invites.list"
                                :key="'invite_' + index"
                                class="intro-y"
                            >
                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                    <div
                                        class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden"
                                    >
                                        <Avatar :src="'uploads/' + invite.inviter.avatar" :username="invite.inviter.name + ' ' + invite.inviter.lastname" size="40" color="#FFF" background-color="#930f68"/>
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">{{invite.team.name}}</div>
                                        <div class="text-gray-600 text-xs mt-0.5">
                                            Od: {{invite.inviter.name + ' ' + invite.inviter.lastname}}
                                        </div>
                                    </div>
                                    <div
                                        class="py-1 px-2 rounded-full text-xs text-center bg-theme-9 text-white cursor-pointer font-medium"
                                        @click="acceptInvite(invite.id)"
                                    >
                                        {{$t('teams.acceptInvite')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BEGIN: Users Layout -->
            <!-- END: Pagination -->
<!--            <div-->
<!--                class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"-->
<!--            >-->
<!--                <ul class="pagination">-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronsLeftIcon class="w-4 h-4" />-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronLeftIcon class="w-4 h-4" />-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">...</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">1</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link pagination__link&#45;&#45;active" href="">2</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">3</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">...</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronRightIcon class="w-4 h-4" />-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronsRightIcon class="w-4 h-4" />-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <select class="w-20 form-select box mt-3 sm:mt-0">-->
<!--                    <option>10</option>-->
<!--                    <option>25</option>-->
<!--                    <option>35</option>-->
<!--                    <option>50</option>-->
<!--                </select>-->
<!--            </div>-->
            <!-- END: Pagination -->
        </div>
    </div>
    <Modal :show="show" @closed="modalClosed">
        <h3 class="intro-y text-lg font-medium mt-5">Dodaj członka zespołu</h3>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div>
                Jeśli podany mail jest powziązany z już zarejestrowanym użytkownikiem będzie on musiał jedynie potwierdzić chęć dołączenia.
            </div>
        </div>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                <input
                    type="text"
                    class="form-control w-56 box pr-10 placeholder-theme-13"
                    placeholder="Email"
                    v-model="new_team_member_email"
                />
                <button class="btn btn-primary shadow-md mr-2" @click="addMember">Zaproś</button>
            </div>

        </div>

    </Modal>
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


export default {
    name: "Teams",
    components: {Avatar, Modal},
    setup(props, {emit}) {
        const showDetails = ref([]);
        const teams = ref([]);
        const invites = ref([]);
        const user = ref({});
        const new_team_name = ref('');
        const new_team_member_email = ref('');
        const search = ref('');
        const toast = useToast();
        const show = ref(false);
        const temporary_team_id = ref(null);

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

        const addTeam = async () => {
            if(new_team_name.value === '') {
                toast.error('Nazwa nie może być pusta');
            } else if (new_team_name.value.length < 3) {
                toast.error('Nazwa nie może mieć mniej niż 3 znaki');
            } else {
                await AddTeam(new_team_name.value)
                    setTimeout(function () {
                        getTeamsRepositories(search.value);
                        new_team_name.value = '';
                        modalClosed();
                    }, 1000);
                toast.success('Success!')
            }
        }

        const addMember = async () => {
            if(new_team_member_email.value === '') {
                toast.error('Email nie może być pusty');
            } else if (new_team_member_email.value.length < 3) {
                toast.error('Email nie może mieć mniej niż 3 znaki');
            } else {
                await AddTeamMember(new_team_member_email.value, temporary_team_id.value)
                setTimeout(function () {
                    getTeamsRepositories(search.value);
                    new_team_member_email.value = '';
                }, 1000);
                toast.success('Success!')
            }
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
            showDetails
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
