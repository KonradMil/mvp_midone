<template>
    <div>
        <DarkModeSwitcher/>
        <div class="container sm:px-10">en
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a target="_blank" href="" class="-intro-x flex items-center pt-5">
                        <img
                            alt="DBR77 Platforma Robotów "
                            class="w-2/4"
                            src="/logo_dbr_white.png"
                        />
                    </a>
                    <div class="my-auto">
                        <img
                            alt="DBR77 Platforma Robotów "
                            class="-intro-x w-1/2 -mt-16"
                            src="/s3/twopointo/images/workers.svg"
                        />
                        <div
                            class="-intro-x text-white font-medium text-4xl leading-tight mt-10"
                        >
                            Pierwszy na świecie <br/>marketplace Robotów
                        </div>

                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div
                        class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto"
                    >
                        <h2
                            class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left"
                        >
                            {{$t('login.loginTitle')}}
                        </h2>
                        <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">
                            Pierwszy na świecie marketplace Robotów
                        </div>
                        <div class="intro-x mt-8">
                            <input
                                type="text"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block"
                                placeholder="Email"
                                v-model="email"
                                @keyup.enter="handleSubmit"
                            />
                            <input
                                @keyup.enter="handleSubmit"
                                type="password"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                :placeholder="$t('login.password')"
                                v-model="password"
                            />
                        </div>
                        <div
                            class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4"
                        >
<!--                            <div class="flex items-center mr-auto">-->
<!--                                <input-->
<!--                                    id="remember-me"-->
<!--                                    type="checkbox"-->
<!--                                    class="form-check-input border mr-2"-->
<!--                                />-->
<!--                                <label class="cursor-pointer select-none" for="remember-me"-->
<!--                                >Remember me</label-->
<!--                                >-->
<!--                            </div>-->
                            <button @click="showAddToTeamModal">{{$t('login.forgot')}}</button>
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button
                                class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                                @click="handleSubmit">
                                {{$t('login.login')}}
                            </button>
                            <button
                                @click="$router.replace({name:'register'})"
                                class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">
                                {{$t('login.signup')}}
                            </button>
                        </div>
                        <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                            {{$t('login.pol1')}} <br/>
                            <a class="text-theme-1 dark:text-theme-10" href="/terms/terms-of-service" @click.prevent="$router.push({path: '/terms/terms-of-service'})">
                                {{$t('login.pol2')}}
                            </a>
                            &
                            <a class="text-theme-1 dark:text-theme-10" href="/terms/privacy-policy" @click.prevent="$router.push({path: '/terms/privacy-policy'})">
                                {{$t('login.pol3')}}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
    </div>
    <Modal :show="show" @closed="modalClosed">
        <h3 class="intro-y text-lg font-medium mt-5">Zresetuj hasło</h3>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div>
                Na podany adres email zostanie wysłany link do resetu hasła.
            </div>
        </div>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                <input
                    type="email"
                    class="form-control w-56 box pr-10 placeholder-theme-13"
                    placeholder="Email"
                    v-model="emailNew"
                />
                <button class="btn btn-primary shadow-md mr-2" @click="reset">Wyślij</button>
            </div>

        </div>

    </Modal>
</template>

<script>
    import {onMounted, ref} from "vue";
    import DarkModeSwitcher from "../components/dark-mode-switcher/Main.vue";
    import cash from "cash-dom";
    import { useToast } from "vue-toastification";
    import {useStore} from '../store';
    import Modal from "../components/Modal";
    import ResetPassword from "../compositions/ResetPassword";

    const toast = useToast();
    const store = useStore();
    export default {
        components: {
            DarkModeSwitcher,
            Modal
        },
        setup() {
            const show = ref(false);
            const emailNew = ref('');

            const showAddToTeamModal = () => {
                show.value = true;
                }
            const modalClosed = () => {
                show.value = false;
            }
            const reset = async () => {
                if(emailNew.value === '') {
                    toast.error('Email nie może być pusty');
                } else {
                    await ResetPassword(emailNew.value)
                    toast.success('Link do zmiany hasła został wysłany na twojego maila!')
                }
            }

            console.log(store);
            onMounted(() => {
                cash("body")
                    .removeClass("main")
                    .removeClass("error-page")
                    .addClass("login");
            });

            return {
                show,
                emailNew,
                showAddToTeamModal,
                modalClosed,
                reset
            };
        },
        data() {
            return {
                email: "",
                password: "",
                error: null
            }
        },
        methods: {
            handleSubmit(e) {
                e.preventDefault()
                if (this.password.length > 0) {
                    this.$axios.get('/sanctum/csrf-cookie').then(response => {
                        this.$axios.post('api/login', {
                            email: this.email,
                            password: this.password
                        })
                            .then(response => {
                                console.log(response.data)
                                if (response.data.success) {
                                    console.log(response.data.success);
                                    let user = response.data.payload;
                                    console.log(user);
                                    // window.Laravel.isLoggedin = true;
                                    store.dispatch('login/login', {
                                        user
                                    })
                                    // toast.success(response.data.message)
                                    console.log(store);
                                    if(user.name !== undefined || user.name !== '') {
                                        window.location.replace('/dashboard');
                                    } else {
                                        window.location.replace('/kreator');
                                    }

                                    // this.$router.go('/kreator');
                                } else {
                                    toast.error(response.data.message);
                                }
                            })
                            // .catch(function (error) {
                            //     this.toast.error(error);
                            // });
                    })
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            if (window.Laravel.isLoggedin) {
                return next('dashboard');
            }
            next();
        }
    }
</script>
