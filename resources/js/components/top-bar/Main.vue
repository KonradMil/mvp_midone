<template>
    <div class="top-bar">
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <!--            <a href="">Application</a>-->
            <!--            <ChevronRightIcon class="breadcrumb__icon"/>-->
            <!--            <a href="" class="breadcrumb&#45;&#45;active">Dashboard</a>-->
        </div>
        <div class="intro-x relative mr-2 sm:mr-2">
            <DarkModeSwitcher/>
        </div>
        <div class="intro-x relative mr-3 sm:mr-6">
            <div class="w-16">
                <TailSelect
                    id="post-form-3"
                    v-model="lang"
                    :options="{
                    locale: 'pl',
                    limit: 'Nie można wybrać więcej',
                    search: false,
                    hideSelected: false,
                    classNames: 'w-16'
                  }">
                    <option value="pl">PL</option>
                    <option value="en">EN</option>

                </TailSelect>
            </div>
        </div>
        <div class="intro-x relative mr-3 sm:mr-6">
            <div class="search hidden sm:block">
                <input
                    type="text"
                    style="color: #fff"
                    v-model="searchTerm"
                    class="search__input form-control border-transparent placeholder-theme-13  ring-0"
                    :placeholder="$t('global.search')"
                    @keyup.enter="searchMe"
                />
                <!--                    @focus="showSearchDropdown"-->
                <SearchIcon class="search__icon dark:text-gray-300" style="color: #fff"/>
            </div>
            <a class="notification sm:hidden" href="">
                <SearchIcon class="notification__icon dark:text-gray-300"/>
            </a>
            <div @mouseleave="hideSearchDropdown" class="search-result" :class="{ show: searchDropdown }">
                <Results :results="results"/>
            </div>
        </div>
        <div class="intro-x dropdown mr-auto sm:mr-6">
            <div :data-count=counts class="dropdown-toggle notification notification--bullet cursor-pointer" role="button" aria-expanded="false">
                <BellIcon class="notification__icon dark:text-gray-300"/>
            </div>
            <div class="notification-content pt-2 dropdown-menu">
                <div
                    class="notification-content__box dropdown-menu__content box dark:bg-dark-6" style="max-height: 400px;">
                    <div class="flex items-center sticky top-0 p-5" style="z-index: 1;">
                        <button class="btn btn-sm btn-primary shadow-md mr-2 truncate" style="max-width: 150px; max-height: 45px;" @click.prevent="$router.push({path: '/notifications'})">Zobacz wszystko</button>
                            <!--                        <div class="notification-content__title pr-10">{{$t('global.notifications')}}</div>-->
                        <button class="btn btn-sm btn-primary shadow-md mr-2 truncate" style="max-width: 150px; max-height: 45px;" @click.prevent="readAll">{{$t('global.readAll')}}</button>
                    </div>

                    <div class="overflow-y-auto p-5 pt-0" style="max-height: 330px;padding-bottom: 20px;">
                        <div style="overflow: hidden;"
                             class="test mt-5"
                             v-for="notification in notificationsComp"
                             :key="notification.id"
                        >
                            <div class="cursor-pointer relative flex items-center transition duration-500 ease-in-out transform hover:-translate-x-10 hover:scale-100"
                                 style="position: relative; overflow: hidden; width: calc(100% + 30px); padding-right: 30px;">
                                <div class="w-12 h-12 flex-none image-fit mr-1 mb-1" style="z-index: 2;">
                                    <Avatar :src="'/s3/avatars/' + notification.data.author.avatar"
                                            :username="notification.data.author.name + ' ' + notification.data.author.lastname"
                                            :size="50" color="#FFF" background-color="#5e50ac"/>
                                    <div v-if="notification.read_at === null"
                                         class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div :class="(notification.read_at === null) ? 'ml-2 overflow-hidden font-medium' : 'ml-2 overflow-hidden opacity-50'" >

                                    <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">
                                        {{ $dayjs(notification.created_at).format('DD.MM.YYYY HH:mm') }}
                                    </div>

                                    <div class="w-full text-black-600 mt-0.5" @click="goTo(notification,notification.data.name,notification.id,notification.data.params,notification.data.id, notification.data.link)">
                                        {{ notification.data.message }}
                                    </div>

                                </div>
                                <a  style="margin-right: -8px; margin-top: 6px; position: absolute; text-align: center; right: 0; top: 0; bottom: 0; width: 30px; vertical-align: middle; display: flex; align-items: center; justify-content: center;"
                                    class="text-theme-6"
                                    @click.prevent=delNotifi(notification)
                                    href="javascript:;"
                                    data-toggle="modal"
                                    data-target="#delete-confirmation-modal">
                                    <TrashIcon style="width: 16px;">
                                    </TrashIcon>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div v-if="notifications.length === 0" class="relative flex items-center mt-5">
                        <div class="ml-2 overflow-hidden">
                            <div class="w-full truncate text-gray-600 mt-0.5">
                                {{ $t('global.anyNotifications') }}
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="mt-5">-->
                    <!--                        <div-->
                    <!--                            v-for="(invite, index) in invites.list"-->
                    <!--                            :key="'invite_' + index"-->
                    <!--                            class="intro-y"-->
                    <!--                        >-->
                    <!--                            <div class="box px-4 py-4 mb-3 flex items-center zoom-in">-->
                    <!--                                <div-->
                    <!--                                    class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden"-->
                    <!--                                >-->
                    <!--                                    <Avatar :src="'uploads/' + invite.inviter.avatar" :username="invite.inviter.name + ' ' + invite.inviter.lastname" size="40" color="#FFF" background-color="#5e50ac"/>-->
                    <!--                                </div>-->
                    <!--                                <div class="ml-4 mr-auto">-->
                    <!--                                    <div class="font-medium">{{invite.team.name}}</div>-->
                    <!--                                    <div class="text-gray-600 text-xs mt-0.5">-->
                    <!--                                        Od: {{invite.inviter.name + ' ' + invite.inviter.lastname}}-->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                                <div-->
                    <!--                                    class="py-1 px-2 rounded-full text-xs text-center bg-theme-9 text-white cursor-pointer font-medium"-->
                    <!--                                    @click="acceptInvite(invite.id)"-->
                    <!--                                >-->
                    <!--                                    {{$t('teams.acceptInvite')}}-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>
            </div>
        </div>
        <!-- END: Notifications -->
        <!-- BEGIN: Account Menu -->
        <div class="intro-x dropdown w-8 h-8">
            <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false">
                <Avatar :src="'/s3/avatars/' + user.avatar" :username="user.name + ' ' + user.lastname" :size="30" color="#FFF" background-color="#5e50ac"/>
            </div>
            <div class="dropdown-menu w-56">
                <div class="dropdown-menu__content box bg-theme-26 dark:bg-dark-6 text-white">
                    <div class="p-4 border-b border-theme-27 dark:border-dark-3">
                        <div class="font-medium">{{ user.name }} {{ user.lastname }}</div>
                        <div class="text-xs text-theme-28 mt-0.5 dark:text-gray-600">
                            {{ user.type }}
                        </div>
                    </div>
                    <div class="p-2">
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md" @click.prevent="$router.push({path: '/profiles'})">
                            <UserIcon class="w-4 h-4 mr-2"/>
                            {{ $t('topBar.profil') }}
                        </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md" @click.prevent="$router.push({name: 'profiles', params: {check: 'change_password'}})">
                            <LockIcon class="w-4 h-4 mr-2"/>
                            {{ $t('topBar.resetPassword') }}
                        </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md" @click.prevent="$router.push({path: '/communication'})">
                            <HelpCircleIcon class="w-4 h-4 mr-2"/>
                            {{ $t('topBar.help') }}
                        </a>
                    </div>
                    <div class="p-2 border-t border-theme-27 dark:border-dark-3">
                        <a href="" @click.prevent="logout" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                            <ToggleRightIcon class="w-4 h-4 mr-2"/>
                            {{ $t('topBar.logout') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent, onMounted, ref, computed, getCurrentInstance, watch} from "vue";
import store, {useStore} from "../../store";
import Avatar from "../avatar/Avatar";
import router from '../../router';
import GetNotifications from "../../compositions/GetNotifications"
import GetInvites from "../../compositions/GetInvites"
import {useI18n} from 'vue-i18n'
import DarkModeSwitcher from "../dark-mode-switcher/Main";
import {useToast} from "vue-toastification";
import Results from "./Results";

const toast = useToast();

export default defineComponent({
    components: {Results, Avatar, DarkModeSwitcher},
    methods: {
        logout() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            store.dispatch('login/logout')
                            toast.success(response.data.message);
                            this.$router.go('/login');
                        } else {
                            toast.error(response.data.message);
                        }
                    })
            })
        }
    },
    setup() {
        const invites = ref([]);
        const user = window.Laravel.user;
        const echo = window.Echo;
        const notifications = ref([]);
        const lang = ref('pl');
        const {t, locale} = useI18n({useScope: 'global'})
        const results = ref({});
        const searchTerm = ref('');
        const counts = ref(0);
        const changeLang = () => {
            locale.value = lang.value;
            store.dispatch('main/setCurrentLang', lang.value);
        }

        const searchMe = () => {
            axios.post('/api/search', {query: searchTerm.value})
                .then(response => {
                    if (response.data.success) {

                        results.value = response.data.payload;
                        showSearchDropdown();
                    } else {
                        toast.error(response.data.message);
                    }
                })
        }

        watch(() => lang.value, (val) => {
            changeLang();
        });

        echo.private('App.Models.User.' + user.id)
            .notification((notification) => {
                getNotificationsRepositories();
            });

        const checkCounts = () => {
            user.notifications.forEach(function (notification) {

                if (notification.read_at === null) {
                    counts.value++;
                }
            });
        };

        const getNotificationsRepositories = async () => {
            notifications.value = await GetNotifications();
            checkCounts();
        }

        const GetInvitesRepositories = async () => {
            invites.value = GetInvites();
        }
        const searchDropdown = ref(false);
        const store = useStore();

        const showSearchDropdown = () => {
            searchDropdown.value = true;
        };

        const hideSearchDropdown = () => {
            searchDropdown.value = false;
        };

        const notificationsComp = computed(() => {
            if (notifications.value.list === undefined) {
                return notifications.value;
            } else {

                return notifications.value.list;
            }
        });

        const setRead = async (notification, id) => {
            axios.post('/api/notifications/set', {id: id})
                .then(response => {
                    if (response.data.success) {
                        notification.read_at = 1;
                        if (counts.value - 1 >= 0) {
                            counts.value--;
                        }
                    } else {
                        toast.error('Error');
                    }
                })
        }

        const readAll = async () => {
            axios.post('/api/notifications/read-all', {})
                .then(response => {
                    if (response.data.success) {
                        // getNotificationsRepositories();
                        notificationsComp.value.forEach(function (noti) {
                            noti.read_at = 1;
                        })
                        // notifications.value = response.data.payload
                        counts.value = 0;
                    } else {
                        toast.error('Error');
                    }
                })
        }

        const delNotifi = async (notification) => {
            axios.post('/api/notifications/delete', {id: notification.id})
                .then(response => {

                    if (response.data.success) {
                        if (notification.data.read_at === null) {
                            counts.value--;
                        }
                        notificationsComp.value.splice(notificationsComp.value.indexOf(notification), 1);
                        toast.success(response.data.message);
                    } else {
                    }
                })
        }

        const goTo = (notification, name, id, change, challenge_id, link) => {
            setRead(notification, id);
            if (change === 'commentChallenge' || change === 'likeChallenge') {
                router.push({path: '/challenges'})
            } else if (change === undefined) {
                router.push({path: link})
            } else {
                router.push({name: name, params: {id: challenge_id, change: change}})
            }
        };

        onMounted(function () {
            GetInvitesRepositories();
            getNotificationsRepositories();
            lang.value = store.state.main.currentLang;
            notifications.value = user.notifications;
        });

        return {
            checkCounts,
            counts,
            delNotifi,
            readAll,
            setRead,
            searchDropdown,
            showSearchDropdown,
            hideSearchDropdown,
            user,
            goTo,
            notifications,
            notificationsComp,
            changeLang,
            lang,
            invites,
            searchMe,
            searchTerm,
            results
        };
    }
});
</script>
