<template>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 xxl:col-span-6">
        <!-- BEGIN: Inbox Content -->
            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">{{$t('global.notifications')}}</h2>
            </div>
        <div class="intro-y inbox mt-5">
            <div v-if="notificationsComp.length === 0" class="intro-y text-lg text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                Nie otrzymałeś jeszcze żadnych powiadomień.
            </div>
            <div class="overflow-y-auto" style="height: 500px; overflow-x: hidden;">
                <div v-for="(notification, index) in notificationsComp"
                     :key="'notification_' + index"
                    class="intro-y pb-2">
                    <div :class="(notification.read_at === null) ? 'inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1' : 'inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1 opacity-60'">
                        <div class="flex px-5 py-3">
                            <div class="w-72 flex-none flex items-center mr-5" style="max-width: 200px;">
<!--                                <input class="form-check-input flex-none" type="checkbox" checked>-->
                                <a href="javascript:;" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="star"></i> </a>
                                <a href="javascript:;" class="w-5 h-5 flex-none ml-2 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="bookmark"></i> </a>
                                <div class="w-6 h-6 flex-none image-fit relative ml-5">
                                    <Avatar :src="'/s3/avatars/' + notification.data.author.avatar"
                                            :username="notification.data.author.name + ' ' + notification.data.author.lastname"
                                            :size="35" color="#FFF" background-color="#5e50ac"/>
                                </div>
                            </div>
                            <div class="w-64 sm:w-auto truncate" @click="goTo(notification.data.name,notification.id,notification.data.params,notification.data.id)">
                                <span class="inbox__item--highlight">{{ notification.data.message }}</span>
                            </div>
                            <div class="inbox__item--time whitespace-nowrap ml-auto pl-10">{{ $dayjs(notification.created_at).format('DD.MM.YYYY HH:mm') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Inbox Content -->
    </div>
        <Invites></Invites>
    </div>
</template>


<script>
import {defineComponent, onMounted, ref, computed, getCurrentInstance, watch} from "vue";
import store, {useStore} from "../store";
import router from '../router';
import GetNotifications from "../compositions/GetNotifications"
import GetInvites from "../compositions/GetInvites"
import { useI18n } from 'vue-i18n'
import {useToast} from "vue-toastification";
import Avatar from "../components/avatar/Avatar";
import AcceptInvite from "../compositions/AcceptInvite";
import Invites from "./Teams/components/Invites";


const toast = useToast();

export default defineComponent({
    components:  {Invites, Avatar},
    setup() {
        const user = window.Laravel.user;
        const echo = window.Echo;
        const notifications = ref([]);
        const lang = ref('pl');
        const { t, locale } = useI18n({ useScope: 'global' })
        const results = ref({});
        const searchTerm = ref('');
        const invites = ref([]);
        const invitesSent = ref([]);
        const changeLang = () => {
            locale.value = lang.value;
            store.dispatch('main/setCurrentLang', lang.value);
        }

        const getInvitesRepositories = async () => {
            await GetInvites((res) => {
                invites.value = res.payload;
                invitesSent.value = res.sent;
            });
        }

        const acceptInvite = async (id) => {
            await AcceptInvite(id)
            setTimeout(function () {
                getInvitesRepositories(search.value);
            }, 1000);
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

        const getNotificationsRepositories = async () => {
            notifications.value = GetNotifications();
        }

        // const GetInvitesRepositories = async () => {
        //     invites.value = GetInvites();
        // }
        const searchDropdown = ref(false);
        const store = useStore();

        const showSearchDropdown = () => {
            searchDropdown.value = true;
        };

        const hideSearchDropdown = () => {
            searchDropdown.value = false;
        };

        const notificationsComp = computed(() => {
            if(notifications.value.list === undefined) {
                return notifications.value;
            }  else {
                return notifications.value.list;
            }
        });

        const setRead = async (id) => {
            axios.post('/api/notifications/set', {id: id})
                .then(response => {
                    if (response.data.success) {
                        notifications.value = response.data.payload
                    } else {
                        toast.error('Error');
                    }
                })
        }
        const readAll = async () => {
            axios.post('/api/notifications/read-all', {})
                .then(response => {
                    if (response.data.success) {
                        notifications.value = response.data.payload
                    } else {
                        toast.error('Error');
                    }
                })
        }

        const delNotifi = async (id,index) => {
            axios.post('/api/notifications/delete', {id: id})
                .then(response => {

                    if (response.data.success) {
                        notifications.value.splice(index,1);
                        toast.success(response.data.message);
                    } else {
                    }
                })
        }

        const goTo = (name,id,change,challenge_id) => {
            setRead(id);
            if(change === 'commentChallenge'){
                router.push({ path: '/challenges' })
            }
            router.push({ name: name, params : {id: challenge_id, change: change}})
        };

        onMounted(function () {
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
            getInvitesRepositories();
            getNotificationsRepositories();
            lang.value = store.state.main.currentLang;
            notifications.value = user.notifications;
        })
        return {
            acceptInvite,
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
            invitesSent,
            searchMe,
            searchTerm,
            results
        };
    }
});
</script>
<style>

</style>
