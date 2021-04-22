<template>
    <div class="flex">
        <!-- BEGIN: Content -->
        <div class="content">
            <div class="grid grid-cols-12 gap-6 mt-8">
                <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
                    <h2 class="intro-y text-lg font-medium mr-auto mt-2">
                        Inbox
                    </h2>
                    <!-- BEGIN: Inbox Menu -->
                    <div class="intro-y box bg-theme-1 p-5 mt-6">
                        <button type="button" class="btn text-gray-700 dark:text-gray-300 w-full bg-white dark:bg-theme-1 mt-1" @click="showAddToTeamModal"> <i class="w-4 h-4 mr-2" data-feather="edit-3"></i> Zgłoś błąd </button>
                        <div class="border-t border-theme-3 dark:border-dark-5 mt-6 pt-6 text-white">
                            <a href="" class="flex items-center px-3 py-2 rounded-md cursor-pointer" :class="(activeTab == 'notifications')? 'bg-theme-20 dark:bg-dark-1 font-medium' : ''" @click.prevent="activeTab = 'notifications'"> <i class="w-4 h-4 mr-2" data-feather="mail"></i> Powiadomienia </a>
                            <a class="flex items-center px-3 py-2 mt-2 rounded-md cursor-pointer" :class="(activeTab == 'teams')? 'bg-theme-20 dark:bg-dark-1 font-medium' : ''" @click.prevent="activeTab = 'teams'"> <i class="w-4 h-4 mr-2" data-feather="star"></i> Zespoły </a>
                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md cursor-pointer" :class="(activeTab == 'questions')? 'bg-theme-20 dark:bg-dark-1 font-medium' : ''"  @click.prevent="activeTab = 'questions'"> <i class="w-4 h-4 mr-2" data-feather="inbox"></i> Pytania </a>
                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md cursor-pointer" :class="(activeTab == 'tickets')? 'bg-theme-20 dark:bg-dark-1 font-medium' : ''" @click.prevent="activeTab = 'tickets'"> <i class="w-4 h-4 mr-2" data-feather="send"></i> Zgłoszenia </a>
                        </div>
<!--                        <div class="border-t border-theme-3 dark:border-dark-5 mt-4 pt-4 text-white">-->
<!--                            <a href="" class="flex items-center px-3 py-2 truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>-->
<!--                                Custom Work-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-9 rounded-full mr-3"></div>-->
<!--                                Important Meetings-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>-->
<!--                                Work-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>-->
<!--                                Design-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate">-->
<!--                                <div class="w-2 h-2 bg-theme-6 rounded-full mr-3"></div>-->
<!--                                Next Week-->
<!--                            </a>-->
<!--                            <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md truncate"> <i class="w-4 h-4 mr-2" data-feather="plus"></i> Add New Label </a>-->
<!--                        </div>-->
                    </div>
                    <!-- END: Inbox Menu -->
                </div>
                <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
                    <!-- BEGIN: Inbox Filter -->
                    <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
                        <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                            <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-gray-700 dark:text-gray-300" data-feather="search"></i>
                            <input type="text" class="form-control w-full sm:w-64 box px-10 text-gray-700 dark:text-gray-300 placeholder-theme-13" placeholder="Search mail">
                            <div class="inbox-filter dropdown absolute inset-y-0 mr-3 right-0 flex items-center" data-placement="bottom-start">
                                <i class="dropdown-toggle w-4 h-4 cursor-pointer text-gray-700 dark:text-gray-300" role="button" aria-expanded="false" data-feather="chevron-down"></i>
                                <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                                    <div class="dropdown-menu__content box p-5">
                                        <div class="grid grid-cols-12 gap-4 gap-y-3">
                                            <div class="col-span-6">
                                                <label for="input-filter-1" class="form-label text-xs">From</label>
                                                <input id="input-filter-1" type="text" class="form-control flex-1" placeholder="example@gmail.com">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-2" class="form-label text-xs">To</label>
                                                <input id="input-filter-2" type="text" class="form-control flex-1" placeholder="example@gmail.com">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-3" class="form-label text-xs">Subject</label>
                                                <input id="input-filter-3" type="text" class="form-control flex-1" placeholder="Important Meeting">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-4" class="form-label text-xs">Has the Words</label>
                                                <input id="input-filter-4" type="text" class="form-control flex-1" placeholder="Job, Work, Documentation">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-5" class="form-label text-xs">Doesn't Have</label>
                                                <input id="input-filter-5" type="text" class="form-control flex-1" placeholder="Job, Work, Documentation">
                                            </div>
                                            <div class="col-span-6">
                                                <label for="input-filter-6" class="form-label text-xs">Size</label>
                                                <select id="input-filter-6" class="form-select flex-1">
                                                    <option>10</option>
                                                    <option>25</option>
                                                    <option>35</option>
                                                    <option>50</option>
                                                </select>
                                            </div>
                                            <div class="col-span-12 flex items-center mt-3">
                                                <button class="btn btn-secondary w-32 ml-auto">Create Filter</button>
                                                <button class="btn btn-primary w-32 ml-2">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full sm:w-auto flex">
                            <button class="btn btn-primary shadow-md mr-2">Start a Video Call</button>
                            <div class="dropdown">
                                <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                                </button>
                                <div class="dropdown-menu w-40">
                                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Contacts </a>
                                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Settings </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Inbox Filter -->
                    <!-- BEGIN: Inbox Content -->
                    <div class="intro-y inbox box mt-5">
                        <div class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                            <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-gray-200 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                <input class="form-check-input" type="checkbox">
                                <div class="dropdown ml-1" data-placement="bottom-start">
                                    <a class="dropdown-toggle w-5 h-5 block dark:text-gray-300" href="javascript:;" aria-expanded="false"> <i data-feather="chevron-down" class="w-5 h-5"></i> </a>
                                    <div class="dropdown-menu w-32">
                                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2"> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">All</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">None</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Read</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Unread</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Starred</a> <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">Unstarred</a> </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="refresh-cw"></i> </a>
                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="more-horizontal"></i> </a>
                            </div>
                            <div class="flex items-center sm:ml-auto">
<!--                                <div class="dark:text-gray-300">1 - 50 of 5,238</div>-->
<!--                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="chevron-left"></i></a>-->
<!--                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="chevron-right"></i></a>-->
<!--                                <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300"> <i class="w-4 h-4" data-feather="settings"></i></a>-->
                            </div>
                        </div>
                        <div class="overflow-x-auto sm:overflow-x-visible"
                             v-for="(notification, index) in notifications.list"
                             :key="'notification_' + index"
                             v-if="activeTab == 'notifications'"
                        >
                            <div class="intro-y" >
                                <div class="inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                    <div class="flex px-5 py-3">
                                        <div class="w-72 flex-none flex items-center mr-5">
                                            <input class="form-check-input flex-none" type="checkbox" checked>
                                            <a href="javascript:;" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="star"></i> </a>
                                            <a href="javascript:;" class="w-5 h-5 flex-none ml-2 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="bookmark"></i> </a>
                                            <div class="w-6 h-6 flex-none image-fit relative ml-5">
                                                <Avatar :src="'uploads/' + notification.data.author.avatar" :username="notification.data.author.name + ' ' + notification.data.author.lastname" size="30" color="#FFF" background-color="#930f68"/>
                                            </div>
                                            <div class="inbox__item--sender truncate ml-3">{{notification.data.author.name + ' ' + notification.data.author.lastname}}</div>
                                        </div>
                                        <div class="w-64 sm:w-auto truncate"> <span class="inbox__item--highlight">{{notification.data.message}}</span> <button v-if="notification.data.link != undefined" type="button" class="btn ml-5" @click="$router.push({path: notification.data.link})">Przejdź</button> </div>
                                        <div class="inbox__item--time whitespace-nowrap ml-auto pl-10">{{$dayjs(notification.created_at).format('DD.MM.YYYY HH:mm')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-gray-600">

                        </div>
                    </div>
                    <!-- END: Inbox Content -->
                </div>
            </div>
        </div>
        <!-- END: Content -->
    </div>
    <!-- BEGIN: Dark Mode Switcher-->
    <div data-url="side-menu-dark-inbox.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
        <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
        <div class="dark-mode-switcher__toggle border"></div>
    </div>
    <!-- END: Dark Mode Switcher-->
    <!-- BEGIN: JS Assets-->
    <Modal :show="show" @closed="modalClosed">
        <h3 class="intro-y text-lg font-medium mt-5">Zadaj pytanie</h3>
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
                />
                <button class="btn btn-primary shadow-md mr-2" >Zaproś</button>
            </div>

        </div>
    </Modal>
</template>

<script>
import {onMounted, ref} from "vue";
import GetUsers from '../../compositions/GetUsers'
import GetNotifications from '../../compositions/GetNotifications'
import {useToast} from "vue-toastification";
import Avatar from "../../components/avatar/Avatar";
import Modal from "../../components/Modal";


export default {
    name: "Communication",
    components: {Avatar, Modal, GetUsers},
    setup(props, {emit}) {
        // const user = ref({});
        const toast = useToast();
        const users = ref([]);
        const notifications = ref([]);
        const show = ref(false);
        const activeTab = ref('notifications');

        const showAddToTeamModal = () => {
               show.value = !show.value;
            }
        const modalClosed = () => {
            show.value = false;
        }
        const getUsersRepositories = async () => {
            users.value = GetUsers();
        }
        const GetNotificationsReposistories = async() => {
            notifications.value = GetNotifications();
        }
        onMounted(function () {
            getUsersRepositories('');
            GetNotificationsReposistories('');
            // if (window.Laravel.user) {
            //     user.value = window.Laravel.user;
            // }
        })
        return {
            users,
            notifications,
            show,
            showAddToTeamModal,
            modalClosed,
            activeTab
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
