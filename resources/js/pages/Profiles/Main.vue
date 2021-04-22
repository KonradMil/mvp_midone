<template>


    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Update Profile
            </h2>
        </div>
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box mt-5">
                    <div class="relative flex items-center p-5">
                        <div class="w-14 h-14 image-fit">
                            <Avatar :src="'uploads/' + user.avatar" :username="user.name + ' ' + user.lastname" size="60"
                                    color="#FFF" background-color="#930f68"/>
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="font-medium text-base">{{ user.name }} {{user.lastname}}</div>
                            <div class="text-gray-600">{{ user.type }}</div>
                        </div>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a class="flex items-center text-theme-1 dark:text-theme-10 font-medium" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Personalia </a>
                        <a class="flex items-center mt-5" href=""> <i data-feather="box" class="w-4 h-4 mr-2"></i> Firma </a>
                        <button  @click="$router.push('change-password')" class="flex items-center mt-5" href=""> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Zmień hasło </button>
<!--                        <a class="flex items-center mt-5" href=""> <i data-feather="settings" class="w-4 h-4 mr-2"></i> User Settings </a>-->
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
<!--                        <a class="flex items-center" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Email Settings </a>-->
                        <button class="flex items-center" @click="showAdd"> <i data-feather="box" class="w-4 h-4 mr-2"></i> Zgody </button>
                        <a class="flex items-center mt-5" href=""> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Konta społecznościowe </a>
                        <a class="flex items-center mt-5" href=""> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Bidders list </a>
                    </div>
                </div>
            </div>
            <!-- END: Profile Menu -->
            <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                <!-- BEGIN: Display Information -->
                <div class="intro-y box lg:mt-5" v-if="!show">
                    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">
                            Display Information
                        </h2>
                    </div>
                    <form @submit.prevent="handleSubmit">
                    <div class="p-5">
                        <div class="flex flex-col-reverse xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 xxl:col-span-6">
                                        <div class="mt-3">
                                            <label for="update-profile-form-2" class="form-label">Name</label>
                                            <input
                                                id="update-profile-form-2"
                                                type="text"
                                                class="form-control"
                                                :placeholder="user.name"
                                                v-model="name"
                                            />                                </div>
                                        <div class="mt-3">
                                            <label for="update-profile-form-3" class="form-label">Last name</label>
                                            <input
                                                id="update-profile-form-3"
                                                type="text"
                                                class="form-control"
                                                :placeholder="user.lastname"
                                                v-model="lastname"
                                            />                                </div>
                                    </div>
                                    <div class="col-span-12 xxl:col-span-6">
                                        <div class="mt-3">
                                            <label for="update-profile-form-1" class="form-label">Email</label>
                                            <input
                                                id="update-profile-form-1"
                                                type="email"
                                                class="form-control"
                                                placeholder="Mail"
                                                v-model="email"
                                            />
                                        </div>
                                        <div class="mt-3">
                                            <label for="update-profile-form-4" class="form-label">Phone Number</label>
                                            <input id="update-profile-form-4" type="text" class="form-control" placeholder="Input text" value="65570828">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-20 mt-3" @click="save">Save</button>
                            </div>
                            <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                                <div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                        <Avatar :src="'uploads/' + avatar_path" :username="user.name + ' ' + user.lastname" size="160"
                                                color="#FFF" background-color="#930f68"/>
                                        <div title="Remove this profile photo?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-6 right-0 top-0 -mr-2 -mt-2"> <i data-feather="x" class="w-4 h-4"></i> </div>
                                    </div>
                                    <Dropzone
                                        ref-key="dropzoneSingleRef"
                                        :options="{
                                        url: '/api/avatar/store',
                                        thumbnailWidth: 150,
                                        maxFilesize: 4,
                                        maxFiles: 1,
                                        previewTemplate: '<div style=\'display: none\'></div>'
                                        }"
                                        class="dropzone">
                                        <div class="text-lg font-medium">
                                            Change avatar
                                        </div>
                                    </Dropzone>
<!--                                    <div class="mx-auto cursor-pointer relative mt-5">-->
<!--                                        <button type="button" class="btn btn-primary w-full">Change Photo</button>-->
<!--                                        <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0">-->
<!--                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- END: Display Information -->
                <div class="col-span-12 lg:col-span-8 xxl:col-span-9" v-show="show">
                    <!-- BEGIN: Display Information -->
                <div class="intro-y box lg:mt-5">
                    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">
                            Display Information
                        </h2>
                    </div>
                    <!-- END: Display Information -->
                    <div
                        class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm "
                    >
                        <input
                            id="rodo"
                            type="checkbox"
                            class="form-check-input border mr-2"
                            :checked="user.privacy_policy"
                        />
                        <label class="cursor-pointer select-none" for="rodo"
                        >Akceptuję postanowienia </label
                        >
                        <a class="text-theme-1 dark:text-theme-10 ml-1" href=""
                        >polityki prywatności.</a
                        >.
                    </div>
                    <div
                        class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"
                    >
                        <input
                            id="rodo3"
                            type="checkbox"
                            class="form-check-input border mr-2"
                            :checked="user.terms"
                        />
                        <label class="cursor-pointer select-none" for="rodo3"
                        >Akceptuję </label
                        >
                        <a class="text-theme-1 dark:text-theme-10 ml-1" href=""
                        > warunki świadczenia </a
                        > usług na platformie DBR77.com.
                    </div>
                    <div
                        class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm border-b border-gray-200 dark:border-dark-5"
                    >
                        <input
                            id="rodo2"
                            type="checkbox"
                            class="form-check-input border mr-2"
                            :checked="user.pricing"
                        />
                         <label class="cursor-pointer select-none" for="rodo2"
                        >Akceptuję </label
                        >
                        <a class="text-theme-1 dark:text-theme-10 ml-1" href=""
                        >cennik usług</a
                        >.
                     </div>
                    <div
                        class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"
                    >
                        <input
                            id="1"
                            type="checkbox"
                            class="form-check-input border mr-2"
                        />
                        <label class="cursor-pointer select-none" for="rodo2"
                        >Poinformuj mnie o pojawieniu się odpowiedzi na moje pytanie.</label
                        >
                    </div>
                    <div
                        class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"
                    >
                        <input
                            id="2"
                            type="checkbox"
                            class="form-check-input border mr-2"
                        />
                        <label class="cursor-pointer select-none" for="rodo2"
                        >Informuj mnie o akceptacji rozwiązania </label
                        >
                    </div>
                    <div
                        class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"
                    >
                        <input
                            id="3"
                            type="checkbox"
                            class="form-check-input border mr-2"
                        />
                        <label class="cursor-pointer select-none" for="rodo2"
                        >Informuj mnie o akceptacji oferty </label
                        >
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content -->
    <!-- BEGIN: JS Assets-->
</template>

<script>
import {defineComponent, onMounted, ref, computed, getCurrentInstance, watch, provide, reactive, toRefs} from "vue";
import store, {useStore} from "../../store";
import Avatar from "../../components/avatar/Avatar";
import router from '../../router';
import GetNotifications from "../../compositions/GetNotifications";
import { useI18n } from 'vue-i18n';
import DarkModeSwitcher from "../../components/dark-mode-switcher/Main";
import Dropzone from '../../global-components/dropzone/Main'
import {useToast} from "vue-toastification";
import cash from "cash-dom";
import {email, minLength, required} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";

const toast = useToast();

export default defineComponent({
    components: {
        Avatar,
        DarkModeSwitcher,
        Dropzone
    },
    setup() {
        const show = ref(false);
        const toast = useToast();
        const dropzoneSingleRef = ref();
        const avatar_path = ref();
        const user = window.Laravel.user;
        const echo = window.Echo;
        const notifications = ref([]);
        const lang = ref('pl');
        const { t, locale } = useI18n({ useScope: 'global' });
        const email = ref("");
        const name = ref("");
        const lastname = ref("");
        const formData = reactive ({
            name: '',
            lastname: '',
            email: ''
        })
        const rules = {
            email: {required, email},
            name: {required, minLength: minLength(3)},
            lastname: {required, minLength: minLength(3)}
        }

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        onMounted(() => {
            const elDropzoneSingleRef = dropzoneSingleRef.value;
            console.log(elDropzoneSingleRef);
            elDropzoneSingleRef.dropzone.on("success", (resp) => {
                console.log(resp.xhr.response);
                avatar_path.value = JSON.parse(resp.xhr.response).payload;
            });
            elDropzoneSingleRef.dropzone.on("error", () => {
                toast.error("Błąd");
            });
            avatar_path.value = '';
            cash("body")
                .removeClass("error-page")

        });

        const changeLang = () => {
            locale.value = lang.value;
            store.dispatch('main/setCurrentLang', lang.value);
        }

        watch(() => lang.value, (val) => {
            changeLang();
        });

        echo.private('App.Models.User.' + user.id)
            .notification((notification) => {
                console.log(notification);
                getNotificationsRepositories();
            });

        const showAdd = async () => {
              show.value = !show.value
        }
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
            lang.value = store.state.main.currentLang;
            notifications.value = user.notifications;
            avatar_path.value = user.avatar;
        })

        const validate = useVuelidate(rules, toRefs(formData));

        const save = () => {
            console.log('here');
            if(formData.name < minLength || formData.name < minLength) {
                toast.warning('Imie i nazwisko musi sie skladac z conajmniej 3 znakow');
            }
            validate.value.$touch();
            if (validate.value.$invalid) {
                return false;
            } else {
                return true;
            }
        };

        return {
            searchDropdown,
            showSearchDropdown,
            hideSearchDropdown,
            user,
            goTo,
            notifications,
            notificationsComp,
            changeLang,
            lang,
            formData,
            validate,
            save,
            showAdd,
            show,
            avatar_path
        };
    },
    mounted() {
        console.log(store.state);
        this.name = store.state.login.user.name;
        this.lastname = store.state.login.user.lastname;
        this.email = store.state.login.user.email;
    },
    data() {
        return {
            email:"",
            error: null,
            name: "",
            lastname: "",
            // avatar_path: '',
            minLength: 3,
            privacy_policy: '',
            pricing: '',
            terms:''
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
        },
        handleSubmit() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/profile/update', {
                    name: this.name,
                    lastname: this.lastname,
                    email: this.email
                })
                    .then(response => {
                        console.log(response.data)
                        // const toast = useToast();
                        // if(this.name === '' || this.lastname === ''){
                        //     toast.error('Uzupełnij imie i nazwisko!');
                        // }
                        if (response.data.success) {
                            let user = response.data.payload;
                            store.dispatch('login/login', {
                                user
                            });
                            toast.success('zapisano poprawnie!');
                            // this.$router.go(0);
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
});
</script>

<style scoped>

</style>
