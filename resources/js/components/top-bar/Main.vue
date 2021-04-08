<template>
    <!-- BEGIN: Top Bar -->
    <div class="top-bar">
        <!-- BEGIN: Breadcrumb -->
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
            <a href="">Application</a>
            <ChevronRightIcon class="breadcrumb__icon"/>
            <a href="" class="breadcrumb--active">Dashboard</a>
        </div>
        <!-- END: Breadcrumb -->
        <!-- BEGIN: Search -->
        <div class="intro-x relative mr-3 sm:mr-6">
            <TailSelect
                @update:modelValue="changeLang"
                @update="changeLang"
                id="post-form-3"
                v-model="lang"
                :options="{
                locale: 'pl',
                limit: 'Nie można wybrać więcej',
                search: false,
                hideSelected: false,
                classNames: 'w-12'
              }"
            >
                <option value="pl">PL</option>
                <option value="en">EN</option>

            </TailSelect>
            <div class="search hidden sm:block">
                <input
                    type="text"
                    style="color: #fff"
                    class="search__input form-control border-transparent placeholder-theme-13"
                    placeholder="Szukaj..."
                    @focus="showSearchDropdown"
                    @blur="hideSearchDropdown"
                />
                <SearchIcon class="search__icon dark:text-gray-300" style="color: #fff"/>
            </div>
            <a class="notification sm:hidden" href="">
                <SearchIcon class="notification__icon dark:text-gray-300"/>
            </a>
            <div class="search-result" :class="{ show: searchDropdown }">
                <div class="search-result__content">
                    <div class="search-result__content__title">Pages</div>
                    <div class="mb-5">
                        <a href="" class="flex items-center">
                            <div
                                class="w-8 h-8 bg-theme-18 text-theme-9 flex items-center justify-center rounded-full"
                            >
                                <InboxIcon class="w-4 h-4"/>
                            </div>
                            <div class="ml-3">Mail Settings</div>
                        </a>
                        <a href="" class="flex items-center mt-2">
                            <div
                                class="w-8 h-8 bg-theme-17 text-theme-11 flex items-center justify-center rounded-full"
                            >
                                <UsersIcon class="w-4 h-4"/>
                            </div>
                            <div class="ml-3">Users & Permissions</div>
                        </a>
                        <a href="" class="flex items-center mt-2">
                            <div
                                class="w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full"
                            >
                                <CreditCardIcon class="w-4 h-4"/>
                            </div>
                            <div class="ml-3">Transactions Report</div>
                        </a>
                    </div>
                    <div class="search-result__content__title">Users</div>
                    <div class="mb-5">
                        <a
                            v-for="(faker, fakerKey) in $_.take($f(), 4)"
                            :key="fakerKey"
                            href
                            class="flex items-center mt-2"
                        >
                            <div class="w-8 h-8 image-fit">
                                <Avatar :src="user.avatar_path" :username="user.name + ' ' + user.lastname" color="#FFF"
                                        background-color="#930f68"/>
                            </div>
                            <div class="ml-3">{{ faker.users[0].name }}</div>
                            <div
                                class="ml-auto w-48 truncate text-gray-600 text-xs text-right"
                            >
                                {{ faker.users[0].email }}
                            </div>
                        </a>
                    </div>
                    <div class="search-result__content__title">Products</div>
                    <a
                        v-for="(faker, fakerKey) in $_.take($f(), 4)"
                        :key="fakerKey"
                        href
                        class="flex items-center mt-2"
                    >
                        <div class="w-8 h-8 image-fit">
                            <img
                                alt="DBR77 Platforma Robotów "
                                class="rounded-full"
                                :src="require(`../../../images/${faker.images[0]}`)"
                            />
                        </div>
                        <div class="ml-3">{{ faker.products[0].name }}</div>
                        <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">
                            {{ faker.products[0].category }}
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- END: Search -->
        <!-- BEGIN: Notifications -->
        <div class="intro-x dropdown mr-auto sm:mr-6">
            <div
                class="dropdown-toggle notification notification--bullet cursor-pointer"
                role="button"
                aria-expanded="false"
            >
                <BellIcon class="notification__icon dark:text-gray-300"/>
            </div>
            <div class="notification-content pt-2 dropdown-menu">
                <div
                    class="notification-content__box dropdown-menu__content box dark:bg-dark-6"
                >
                    <div class="notification-content__title">Powiadomienia</div>
                    <div
                        v-for="(notification, index) in notificationsComp"
                        :key="'notification_' + index"
                        class="cursor-pointer relative flex items-center"
                        :class="{ 'mt-5': index }"
                        @click="goTo(notification.data.link)"
                    >
                        <div class="w-12 h-12 flex-none image-fit mr-1">
                            <Avatar :src="'uploads/' + notification.data.author.avatar"
                                    :username="notification.data.author.name + ' ' + notification.data.author.lastname"
                                    size="50" color="#FFF" background-color="#930f68"/>

                            <div v-if="notification.read_at === null"
                                 class="w-3 h-3 bg-theme-9 absolute right-0 bottom-0 rounded-full border-2 border-white"
                            ></div>
                        </div>
                        <div class="ml-2 overflow-hidden">
                            <div class="flex items-center">
                                <a href="#" class="font-medium truncate mr-5"></a>
                                <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">
                                    {{ $dayjs(notification.created_at).format('DD.MM.YYYY HH:mm') }}
                                </div>
                            </div>
                            <div class="w-full truncate text-gray-600 mt-0.5">
                                {{ notification.data.message }}
                            </div>
                        </div>
                    </div>
                    <div
                       v-if="notifications.length === 0"
                        class="relative flex items-center mt-5"
                    >
                        <div class="ml-2 overflow-hidden">
                            <div class="w-full truncate text-gray-600 mt-0.5">
                                Nie masz żadnych powiadomień.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Notifications -->
        <!-- BEGIN: Account Menu -->
        <div class="intro-x dropdown w-8 h-8">
            <div
                class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in"
                role="button"
                aria-expanded="false"
            >
                <Avatar :src="'uploads/' + user.avatar_path" :username="user.name + ' ' + user.lastname" size="30"
                        color="#FFF" background-color="#930f68"/>
            </div>
            <div class="dropdown-menu w-56">
                <div
                    class="dropdown-menu__content box bg-theme-26 dark:bg-dark-6 text-white"
                >
                    <div class="p-4 border-b border-theme-27 dark:border-dark-3">
                        <div class="font-medium">{{ user.name }} {{ user.last_name }}</div>
                        <div class="text-xs text-theme-28 mt-0.5 dark:text-gray-600">
                            {{ user.type }}
                        </div>
                    </div>
                    <div class="p-2">
                        <a
                            href=""
                            class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"
                        >
                            <UserIcon class="w-4 h-4 mr-2"/>
                            Profile
                        </a>
                        <a
                            href=""
                            class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"
                        >
                            <EditIcon class="w-4 h-4 mr-2"/>
                            Add Account
                        </a>
                        <a
                            href=""
                            class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"
                        >
                            <LockIcon class="w-4 h-4 mr-2"/>
                            Reset Password
                        </a>
                        <a
                            href=""
                            class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"
                        >
                            <HelpCircleIcon class="w-4 h-4 mr-2"/>
                            Help
                        </a>
                    </div>
                    <div class="p-2 border-t border-theme-27 dark:border-dark-3">
                        <a
                            @click="logout"
                            class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"
                        >
                            <ToggleRightIcon class="w-4 h-4 mr-2"/>
                            Wyloguj
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Account Menu -->
    </div>
    <!-- END: Top Bar -->
</template>

<script>
import {defineComponent, onMounted, ref, computed, getCurrentInstance} from "vue";
import store, {useStore} from "../../store";
import Avatar from "../avatar/Avatar";
import router from '../../router';
import GetNotifications from "../../compositions/GetNotifications"
import { useI18n } from 'vue-i18n'

export default defineComponent({
    components: {Avatar},
    data() {
        return {
            avatar_path: '',
        }
    },
    methods: {
        logout() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/logout')
                    .then(response => {
                        if (response.data.success) {
                            store.dispatch('login/logout')
                            this.$router.go('/login');
                        } else {
                            toast.error(response.data.message);
                        }
                    })
                // .catch(function (error) {
                //     this.toast.error(error);
                // });
            })
        }
    },
    created() {
        if (window.Laravel.user) {
            // this.user = window.Laravel.user;
            this.avatar_path = window.Laravel.user.avatar;
        }
    },
    setup() {
        const user = window.Laravel.user;
        const echo = window.Echo;
        const notifications = ref([]);
        const lang = ref('pl');
        const { t, locale } = useI18n({ useScope: 'global' })

        const changeLang = () => {
            locale.value = lang.value;
        }

        echo.private('App.Models.User.' + user.id)
            .notification((notification) => {
                console.log(notification);
                getNotificationsRepositories();
            });

        const getNotificationsRepositories = async () => {
            console.log(GetNotifications());
            // if(GetNotifications().list.)
            notifications.value = GetNotifications();
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
           if(notifications.value.list == undefined) {
               return notifications.value;
           }  else {
               console.log(notifications.value.list);
               return notifications.value.list;
           }
        });

        const goTo = (link) => {
            router.push({ path: link})
        };

        onMounted(function () {
           notifications.value = user.notifications;
        })
        return {
            searchDropdown,
            showSearchDropdown,
            hideSearchDropdown,
            user,
            goTo,
            notifications,
            notificationsComp,
            changeLang,
            lang
        };
    }
});
</script>
