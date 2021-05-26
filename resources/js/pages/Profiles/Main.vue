<template>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{$t('profiles.profile')}}
            </h2>
        </div>
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box mt-5">
                    <div class="relative flex items-center p-5">
                        <div class="w-14 h-14 image-fit">
                            <Avatar :src="'/s3/avatars/' + user.avatar" :username="user.name + ' ' + user.lastname" size="60"
                                    color="#FFF" background-color="#930f68"/>
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="font-medium text-base">{{ user.name }} {{user.lastname}}</div>
                            <div class="text-gray-600">{{ user.type }}</div>
                        </div>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a class="flex items-center px-3 py-2 rounded-md cursor-pointer dark:text-theme-10 font-medium" :class="(activeTab === 'personalia') ? 'bg-theme-20 dark:bg-dark-1 font-medium text-white' : ''" @click.prevent="activeTab = 'personalia'"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> {{$t('profiles.personality')}} </a>
                        <a class="flex items-center px-3 py-2 rounded-md cursor-pointer" href="" :class="(activeTab === 'company') ? 'bg-theme-20 dark:bg-dark-1 font-medium text-white' : ''" @click.prevent="activeTab = 'company'" > <i data-feather="box" class="w-4 h-4 mr-2"></i> {{$t('profiles.company')}} </a>
                        <a class="flex items-center px-3 py-2 rounded-md cursor-pointer" href="" :class="(activeTab === 'change_password') ? 'bg-theme-20 dark:bg-dark-1 font-medium text-white' : ''" @click.prevent="activeTab = 'change_password'" > <i data-feather="lock" class="w-4 h-4 mr-2"></i> {{$t('profiles.changePassword')}} </a>
<!--                        <a class="flex items-center mt-5" href=""> <i data-feather="settings" class="w-4 h-4 mr-2"></i> User Settings </a>-->
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
<!--                        <a class="flex items-center" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Email Settings </a>-->
                        <a class="flex items-center px-3 py-2 rounded-md cursor-pointer" :class="(activeTab === 'terms') ? 'bg-theme-20 dark:bg-dark-1 font-medium text-white' : ''" @click.prevent="activeTab = 'terms'"> <i data-feather="box" class="w-4 h-4 mr-2"></i> {{$t('profiles.agreements')}} </a>
                        <a class="flex items-center px-3 py-2 rounded-md cursor-pointer" :class="(activeTab === 'socials') ? 'bg-theme-20 dark:bg-dark-1 font-medium text-white' : ''" @click.prevent="activeTab = 'socials'" > <i data-feather="lock" class="w-4 h-4 mr-2"></i> {{$t('profiles.socialMedia')}} </a>
<!--                        <a class="flex items-center px-3 py-2 rounded-md cursor-pointer" :class="(activeTab === 'bidders-list') ? 'bg-theme-20 dark:bg-dark-1 font-medium text-white' : ''" @click.prevent="activeTab = 'bidders-list'"> <i data-feather="settings" class="w-4 h-4 mr-2"></i> {{$t('profiles.biddersList')}} </a>-->
                    </div>
                </div>
            </div>
            <!-- END: Profile Menu -->
            <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                <!-- BEGIN: Display Information -->
                <div class="intro-y box lg:mt-5" v-if="activeTab==='personalia'">
                    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">
                            {{$t('profiles.personality')}}
                        </h2>
                    </div>
                    <form @submit.prevent="handleSubmit">
                    <div class="p-5">
                        <div class="flex flex-col-reverse xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 xxl:col-span-6">
                                        <div class="mt-3">
                                            <label for="update-profile-form-2" class="form-label">{{$t('profiles.name')}}</label>
                                            <input
                                                id="update-profile-form-2"
                                                type="text"
                                                class="form-control"
                                                :placeholder="user.name"
                                                v-model="name"
                                            />                                </div>
                                        <div class="mt-3">
                                            <label for="update-profile-form-3" class="form-label">{{$t('profiles.lastname')}}</label>
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
                                            <label for="update-profile-form-4" class="form-label">{{$t('profiles.phone')}}</label>
                                            <input id="update-profile-form-4" type="text" class="form-control" placeholder="Input text" value="65570828">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-20 mt-3" @click="save">{{$t('profiles.save')}}</button>
                            </div>
                            <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                                <div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                        <Avatar :src="'/s3/avatars/' + avatar_path" :username="user.name + ' ' + user.lastname" size="160"
                                                color="#FFF" background-color="#930f68"/>
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
                                            {{$t('profiles.changeAvatar')}}
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

                <div id="social-media-button" class="p-5" v-if="activeTab==='socials'">
                  <Socials></Socials>
                </div>
                <div class="col-span-12 lg:col-span-8 xxl:col-span-9" v-if="activeTab === 'terms'">
                    <Terms></Terms>
                </div>
                <div class="col-span-12 lg:col-span-8 xxl:col-span-9" v-if="activeTab === 'change_password'">
                    <!-- BEGIN: Change Password -->
                    <ChangePassword></ChangePassword>
                    <!-- END: Change Password -->
                </div>
                <div class="col-span-12 lg:col-span-8 xxl:col-span-9" v-if="activeTab === 'company'">
                    <!-- BEGIN: Company -->
                   <Company></Company>
                    <!-- END: Company -->
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
import GetTeams from "../../compositions/GetTeams"
import Company from "./Company"
import Terms  from "./Terms"
import ChangePassword from "./ChangePassword";
import Socials from "./Socials";

const toast = useToast();

export default defineComponent({
    components: {
        ChangePassword,
        Avatar,
        DarkModeSwitcher,
        Dropzone,
        Company,
        Terms,
        Socials
    },
    setup() {
        const activeTab = ref('personalia');
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
                console.log("resp.xhr.response");
                console.log(resp.xhr.response);
                avatar_path.value = JSON.parse(resp.xhr.response).payload;
                let user = JSON.parse(resp.xhr.response).user;
                store.dispatch('login/login', {
                    user
                });
                location.reload();
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
            if(notifications.value.list === undefined) {
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
                // toast.warning('Imie i nazwisko musi sie skladac z conajmniej 3 znakow');
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
            avatar_path,
            activeTab,
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
        saveCompany(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/company/create', {
                    regon : this.regon,
                    nip: this.nip,
                    company_name: this.company_name,
                    city: this.city,
                    street: this.street,
                    flat_nr: this.loc_nr,
                    house_nr: this.house_nr,
                    postcode: this.postcode,
                    province: this.voivodeship,
                    country: this.country,
                    krs: this.krs
                })
                    .then(response => {
                        console.log(response.data)
                        // ??
                        if (response.data.success) {
                            toast.success(('Success!'))
                        } else {
                            toast.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        toast.error(error);
                    });
            })
        },
        searchNip() {
            if (this.nip !== '') {
                this.search(this.nip);
            } else {
                toast.warning('NIP nie może być pusty');
            }

        },
        searchRegon() {
            if (this.regon !== '') {
                this.search(this.regon);
            } else {
                toast.warning('REGON nie może być pusty');
            }
        },
        searchKRS() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/company/search/krs', {
                    krs: this.krs
                })
                    .then(response => {
                        console.log(response.data)
                        if (response.data.success) {
                            if (response.data.success) {
                                this.regon = response.data.payload[0].regon;
                                this.nip = response.data.payload[0].nip;
                                this.city = response.data.payload[0].postalCityName;
                                this.company_name = response.data.payload[0].company_name;
                                this.street = response.data.payload[0].streetName;
                                this.loc_nr = response.data.payload[0].flatNr;
                                this.house_nr = response.data.payload[0].homeNr;
                                this.postcode = response.data.payload[0].postalCode;
                                this.voivodeship = response.data.payload[0].voivodshipName;
                                this.country = 'Polska';
                            } else {
                                toast.error(response.data.message);
                            }

                        } else {
                            toast.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        toast.error(error);
                    });
            })
        },
        search(val) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/company/search/nip', {
                    nip: val
                })
                    .then(response => {
                        console.log(response.data)
                        if (response.data.success) {
                            this.regon = response.data.payload[0].regon;
                            this.nip = response.data.payload[0].nip;
                            this.city = response.data.payload[0].postalCityName;
                            this.company_name = response.data.payload[0].company_name;
                            this.street = response.data.payload[0].streetName;
                            this.loc_nr = response.data.payload[0].flatNr;
                            this.house_nr = response.data.payload[0].homeNr;
                            this.postcode = response.data.payload[0].postalCode;
                            this.voivodeship = response.data.payload[0].voivodshipName;
                            this.country = 'Polska';
                        } else {
                            toast.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        toast.error(error);
                    });
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
