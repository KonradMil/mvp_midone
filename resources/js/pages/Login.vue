<template>
    <div>
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a class="-intro-x flex items-center pt-5 cursor-default">
                        <img
                            alt="DBR77 Platforma Robotów "
                            class="w-2/4 mt-36"
                            src="/images/dbr_logo_white_platform.svg"
                        />
                    </a>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            {{ $t('login.loginTitle') }}
                        </h2>
                        <div v-if="resendEmail"
                             class="intro-x flex flex-col text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                            <span style="padding-bottom: 10px;">Link aktywacyjny nie dotarł?</span>
                            <button @click="resendConfirmationEmail" class="btn btn-secondary">
                                Wyślij link ponownie
                            </button>
                        </div>
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
                        <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                            <button @click="showAddToTeamModal">{{ $t('login.forgot') }}</button>
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" @click.prevent="handleSubmit">
                                {{ $t('login.login') }}
                            </button>
                            <button @click="$router.replace({name:'register'})" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">
                                {{ $t('login.signup') }}
                            </button>
                        </div>
                        <div class="social-auth flex flex-col intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button @click="handleSocialRegistration('facebook', $event)" class="btn btn-social btn-outline-secondary py-3 px-4 w-full xl:mr-3 align-top">
                                <div class="icon">
                                    <img src="icons/facebook.svg"/>
                                </div>
                                <div class="text">
                                    Logowanie Facebook
                                </div>
                            </button>
                            <button @click="handleSocialRegistration('google', $event)" class="btn btn-social btn-outline-secondary py-3 px-4 w-full xl:mr-3 align-top">
                                <div class="icon">
                                    <img src="icons/google.svg"/>
                                </div>
                                <div class="text">
                                    Logowanie Google
                                </div>
                            </button>
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">

                        </div>
                        <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                            {{ $t('login.pol1') }}<br/>
                            <a class="text-theme-1 dark:text-theme-10" href="/terms/terms-of-service" target="_blank">
                                {{ $t('login.pol2') }}
                            </a>
                            &
                            <a class="text-theme-1 dark:text-theme-10" href="/terms/privacy-policy" target="_blank">
                                {{ $t('login.pol3') }}
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

    <Modal :show="shows" @closed="shows = false;">
        <h3 class="intro-y text-lg font-medium mt-5">Dwustopniowa weryfikacja</h3>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div>
                Podaj kod z powiązanej aplikacji (Google Authenticator, Authy itd.)
            </div>
        </div>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                <input
                    type="email"
                    class="form-control w-56 box pr-10 placeholder-theme-13"
                    placeholder="Kod"
                    v-model="twofa_code"
                />
                <button class="btn btn-primary shadow-md mr-2" @click="checkTwoFa">Weryfikuj</button>
            </div>
        </div>
    </Modal>

</template>

<script>
import {onMounted, ref} from "vue";
import cash from "cash-dom";
import {useToast} from "vue-toastification";
import {useStore} from '../store';
import Modal from "../components/Modal";
import ResetPassword from "../compositions/ResetPassword";
import {useReCaptcha} from "vue-recaptcha-v3";
import RequestHandler from "../compositions/RequestHandler";

const toast = useToast();
const store = useStore();

export default {

    components: {
        Modal
    },

    setup() {
        const {executeRecaptcha, recaptchaLoaded} = useReCaptcha();
        const show = ref(false);
        const emailNew = ref('');
        const twofa_code = ref('');
        const email = ref('');
        const password = ref('');
        const shows = ref(false);
        const error = ref(null);
        const resendEmail = ref(false);
        const url_params = ref();

        const showAddToTeamModal = () => {
            show.value = true;
        }

        const checkTwoFa = () => {
            let email = window.email;
            axios.post('/api/check/twofa', {
                email: email,
                code: twofa_code.value
            }).then(response => {

                if (response.data.success) {
                    let user = response.data.payload;
                    store.dispatch('login/login', {
                        user
                    })
                    window.location.replace('/dashboard');
                } else {
                    toast.error(response.data.message);
                }
            })
        }

        const modalClosed = () => {
            show.value = false;
        }

        const reset = async () => {
            if (emailNew.value === '') {
                toast.error('Email nie może być pusty');
            } else {
                await ResetPassword(emailNew.value)
                toast.success('Link do zmiany hasła został wysłany na twojego maila!')
            }
        }

        const handleSubmit = async () => {
            if (password.value.length > 0) {
                await recaptchaLoaded();
                const recaptchaToken = await executeRecaptcha("login");

                RequestHandler('login', 'POST', {
                        email: email.value,
                        password: password.value,
                        recaptchaToken: recaptchaToken
                    },
                    (response) => {

                        let twoFactory = typeof response.data.twofa !== 'undefined' ? response.data.twofa : false;
                        let user = response.data.user;
                        let company = response.data.company;

                        if (twoFactory) {
                            window.email = user.email;
                            shows.value = true;
                        } else {

                            store.dispatch('login/login', {user});

                            if (window.invitationToken) {

                                if (!user.name || !user.lastname || !company.nip) {
                                    window.location.replace('/teams/claim_invitation?token=' + window.invitationToken + '&redirect_to=kreator');
                                } else {
                                    window.location.replace('/teams/claim_invitation?token=' + window.invitationToken + '&redirect_to=dashboard');
                                }

                            } else {
                                if(url_params.value['redirect'] != undefined) {
                                    window.location.replace(url_params.value['redirect']);
                                } else {
                                    if (!user.name || !user.lastname || !company.nip) {
                                        window.location.replace('/kreator');
                                    } else {
                                        window.location.replace('/dashboard');
                                    }
                                }
                            }
                        }
                    },
                    (error) => {
                        if (typeof error.response.data.accountInactive !== 'undefined') {
                            resendEmail.value = true;
                        }

                    });
            }
        }

        const resendConfirmationEmail = async (e) => {

            RequestHandler('email/verify/resend_email', 'POST', {
                email: email.value
            });

        }

        const handleSocialRegistration = (provider, e) => {
            e.preventDefault();
            window.location.href = "/auth/social/" + provider + "/sign_in";
        }

        onMounted(() => {
            const urlSearchParams = new URLSearchParams(window.location.search);
            url_params.value  = Object.fromEntries(urlSearchParams.entries());
            cash("body")
                .removeClass("main")
                .removeClass("error-page")
                .addClass("login");
        });

        return {
            handleSubmit,
            handleSocialRegistration,
            resendConfirmationEmail,
            show,
            emailNew,
            showAddToTeamModal,
            modalClosed,
            reset,
            twofa_code,
            checkTwoFa,
            executeRecaptcha,
            recaptchaLoaded,
            email,
            password,
            shows,
            error,
            resendEmail
        };
    },

    beforeRouteEnter(to, from, next) {

        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }

        next();

    }
}
</script>
