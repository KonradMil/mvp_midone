<template>
    <div>
        <!--        <DarkModeSwitcher/>-->
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Register Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a class="-intro-x flex items-center pt-5 cursor-default">
                        <img
                            alt="DBR77 Platforma Robotów "
                            class="w-2/4 mt-36"
                            src="/images/dbr_logo_white_platform.svg"
                        />
                    </a>
                </div>
                <!-- END: Register Info -->
                <!-- BEGIN: Register Form -->

                <div class="h-screen xl:h-auto flex py-15 xl:py-18 my-10 xl:my-0 ">
                    <form class="validate-form" @submit.prevent="handleSubmit">
                        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 mt-20 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                            <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                                {{ $t('register.signup') }}
                            </h2>

                            <div class="intro-x mt-8">
                                <div class="mt-3"><label>{{ $t('register.iam') }}</label>
                                    <div class="flex flex-col sm:flex-row mt-2">

                                        <div class="form-check mr-2">
                                            <input id="radio-switch-4"
                                                   v-model="validate.type.$model"
                                                   class="form-check-input"
                                                   type="radio"
                                                   name="horizontal_radio_button"
                                                   value="integrator"/>
                                            <Tippy
                                                tag="a"
                                                class="dark:text-gray-300 text-gray-600"
                                                content="Podmiot świadczący usługi związane z automatyzacją stanowisk przemysłowych w zakładzie produkcyjnym.">
                                                <label class="form-check-label" for="radio-switch-4">{{ $t('common.integratorem') }}</label>
                                            </Tippy>
                                        </div>
                                        <div class="form-check mr-2 mt-2 sm:mt-0">
                                            <input id="radio-switch-5"
                                                   v-model="validate.type.$model"
                                                   class="form-check-input"
                                                   type="radio"
                                                   name="horizontal_radio_button"
                                                   value="investor"/>
                                            <Tippy
                                                tag="a"
                                                class="dark:text-gray-300 text-gray-600"
                                                content="Przedsiębiorca zamierzający zautomatyzować stanowisko przemysłowe w zakładzie produkcyjnym.">
                                                <label class="form-check-label"
                                                       for="radio-switch-5">{{ $t('common.investorem') }}</label>
                                            </Tippy>
                                        </div>
                                    </div>
                                    <template v-if="validate.type.$error">
                                        <div v-for="(error, index) in validate.type.$errors"
                                            :key="index"
                                            class="text-theme-6 mt-2">
                                            {{ $t('validation.' + error.$message) }}
                                        </div>
                                    </template>
                                </div>
                                <input
                                    type="text"
                                    class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                    placeholder="Email"
                                    v-model.trim="validate.email.$model"/>
                                <template v-if="validate.email.$error">
                                    <div v-for="(error, index) in validate.email.$errors"
                                         :key="index"
                                         class="text-theme-6 mt-2">
                                        {{ $t('validation.' + error.$message) }}
                                    </div>
                                </template>
                                <input
                                    type="password"
                                    class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                    :placeholder="$t('login.password')" autocomplete="new-password"
                                    v-model.trim="validate.password.$model"/>
                                <template v-if="validate.password.$error">
                                    <div v-for="(error, index) in validate.password.$errors"
                                         :key="index"
                                         class="text-theme-6 mt-2">
                                        {{ $t('validation.' + error.$message) }}
                                    </div>
                                </template>
                                <div class="intro-x w-full grid grid-cols-12 gap-4 h-1 mt-3">
                                    <div v-if="score === 1" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 2" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 2" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 3" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 3" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 3" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 4" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 4" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 4" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 4" class="col-span-3 h-full rounded bg-theme-9"></div>
                                    <div v-if="score === 0 || score == undefined"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                    <div v-if="score === 0 || score == undefined"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                    <div v-if="score === 0 || score == undefined"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                    <div v-if="score === 0 || score == undefined"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                    <div v-if="score === 1"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                    <div v-if="score === 1"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                    <div v-if="score === 1"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                    <div v-if="score === 2"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                    <div v-if="score === 2"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                    <div v-if="score === 3"
                                         class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                </div>
                                <a class="intro-x text-gray-600 block mt-2 text-xs sm:text-sm cursor-default">
                                    {{ $t('register.safepassword') }}
                                </a>
                                <input
                                    type="password"
                                    class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                    :placeholder="$t('register.passwordConfirm')"
                                    v-model="validate.passwordConfirm.$model"/>
                                <template v-if="validate.passwordConfirm.$error">
                                    <div v-for="(error, index) in validate.passwordConfirm.$errors"
                                        :key="index"
                                        class="text-theme-6 mt-2">
                                        {{ $t('validation.' + error.$message) }}
                                    </div>
                                </template>
                                <password-meter @score="onScore" :password="validate.password.$model"/>
                            </div>

                            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                                <input
                                    id="rodo"
                                    type="checkbox"
                                    class="form-check-input border mr-2"
                                    v-model="validate.rodo.$model"
                                />
                                <label class="cursor-pointer select-none" for="rodo">
                                    Akceptuję postanowienia
                                </label>
                                <a href="/terms/privacy-policy"
                                   class="text-theme-1 dark:text-theme-10 ml-1 cursor-pointer"
                                   @click.prevent="$router.push({path: '/terms/privacy-policy'})"> polityki
                                    prywatności.</a>.
                            </div>
                            <template v-if="validate.rodo.$error">
                                <div
                                    v-for="(error, index) in validate.rodo.$errors"
                                    :key="index"
                                    class="text-theme-6 mt-2">
                                    {{ $t('validation.' + error.$message) }}
                                </div>
                            </template>
                            <div
                                class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                                <input id="rodo3" type="checkbox" class="form-check-input border mr-2"
                                       v-model="validate.rodo3.$model"/>
                                <label class="cursor-pointer select-none" for="rodo3">Akceptuję </label>
                                <a href="/terms/terms-of-service" class="text-theme-1 dark:text-theme-10 mx-1 cursor-pointer" @click.prevent="$router.push({path: '/terms/terms-of-service'})">
                                    warunki świadczenia
                                    &#32;</a> usług na platformie DBR77.com.
                            </div>
                            <template v-if="validate.rodo3.$error">
                                <div
                                    v-for="(error, index) in validate.rodo3.$errors"
                                    :key="index"
                                    class="text-theme-6 mt-2">
                                    {{ $t('validation.' + error.$message) }}
                                </div>
                            </template>
                            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                                <input
                                    id="rodo2"
                                    type="checkbox"
                                    class="form-check-input border mr-2"
                                    v-model="validate.rodo2.$model"/>
                                <label class="cursor-pointer select-none" for="rodo2">
                                    Akceptuję
                                </label>
                                <a href="/terms/price-list" class="text-theme-1 dark:text-theme-10 ml-1 cursor-pointer" @click.prevent="$router.push({path: '/terms/price-list'})"> cennik usług</a>.
                            </div>
                            <template v-if="validate.rodo2.$error">
                                <div v-for="(error, index) in validate.rodo2.$errors"
                                     :key="index"
                                     class="text-theme-6 mt-2">
                                    {{ $t('validation.' + error.$message) }}
                                </div>
                            </template>

                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                                    {{ $t('register.signup') }}
                                </button>
                                <button @click.prevent="$router.push('login')" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">
                                    {{ $t('login.login') }}
                                </button>
                            </div>
                            <div class="social-auth flex flex-col intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button @click="handleSocialRegistration('facebook', $event)"
                                        class="btn btn-social btn-outline-secondary py-3 px-4 w-full xl:mr-3 align-top">
                                    <div class="icon">
                                        <img src="icons/facebook.svg"/>
                                    </div>
                                    <div class="text">
                                        Rejestracja Facebook
                                    </div>
                                </button>
                                <button @click="handleSocialRegistration('google', $event)"
                                        class="btn btn-social btn-outline-secondary py-3 px-4 w-full xl:mr-3 align-top">
                                    <div class="icon">
                                        <img src="icons/google.svg"/>
                                    </div>
                                    <div class="text">
                                        Rejestracja Google
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- END: Register Form -->
            </div>
        </div>
    </div>

    <Modal :show="modalSocialConsents" @closed="modalSocialConsents=false;socialSignupProvider=null;">

        <h3 class="intro-y text-lg font-medium mt-5">Uzupełnij wymagane informacje</h3>

        <div class="mt-5 p-5 box">

            <label>{{ $t('register.iam') }}</label>
            <div class="flex flex-col sm:flex-row mt-2">

                <div class="form-check mr-2">
                    <input id="social-account-type-integrator"
                           v-model="validate.type.$model"
                           class="form-check-input"
                           type="radio"
                           name="horizontal_radio_button"
                           value="integrator"/>
                    <Tippy
                        tag="a"
                        href=""
                        class="dark:text-gray-300 text-gray-600"
                        content="Podmiot świadczący usługi związane z automatyzacją stanowisk przemysłowych w zakładzie produkcyjnym.">
                        <label class="form-check-label"
                               for="radio-switch-4">{{ $t('common.integratorem') }}</label>
                    </Tippy>
                </div>
                <div class="form-check mr-2 mt-2 sm:mt-0">
                    <input id="social-account-type-investor"
                           v-model="validate.type.$model"
                           class="form-check-input"
                           type="radio"
                           name="horizontal_radio_button"
                           value="investor"/>
                    <Tippy
                        tag="a"
                        href=""
                        class="dark:text-gray-300 text-gray-600"
                        content="Przedsiębiorca zamierzający zautomatyzować stanowisko przemysłowe w zakładzie produkcyjnym.">
                        <label class="form-check-label"
                               for="radio-switch-5">{{ $t('common.investorem') }}</label>
                    </Tippy>
                </div>
            </div>

            <template v-if="socialAccountTypeError">
                <div
                    class="text-theme-6 mt-2"
                >
                    {{ $t('validation.Value is required') }}
                </div>
            </template>

            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-12 text-xs sm:text-sm">
                <input
                    v-model="validate.rodo.$model"
                    id="social-signup-privacy-policy"
                    type="checkbox"
                    class="form-check-input border mr-2"
                />
                <label class="cursor-pointer select-none" for="rodo">
                    Akceptuję postanowienia
                    <a href="/terms/privacy-policy"
                       class="text-theme-1 dark:text-theme-10 ml-1 cursor-pointer"
                       @click.prevent="$router.push({path: '/terms/privacy-policy'})"> polityki
                        prywatności</a>.
                </label>

            </div>
            <template v-if="socialPrivacyPolicyConsentError">
                <div class="text-theme-6 mt-2">
                    {{ $t('validation.Value is required') }}
                </div>
            </template>

            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-5 text-xs sm:text-sm">
                <input id="social-signup-rodo3"
                       type="checkbox"
                       class="form-check-input border mr-2"
                       v-model="validate.rodo3.$model"
                >
                <label class="cursor-pointer select-none" for="rodo3">
                    Akceptuję
                    <a href="/terms/terms-of-service"
                       class="text-theme-1 dark:text-theme-10 mx-1 cursor-pointer"
                       @click.prevent="$router.push({path: '/terms/terms-of-service'})"
                    > warunki świadczenia &#32;</a>
                    usług na platformie DBR77.com.
                </label>
            </div>
            <template v-if="socialRulesConsentError">
                <div
                    class="text-theme-6 mt-2">
                    {{ $t('validation.Value is required') }}
                </div>
            </template>

            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                <input
                    id="social-signup-rodo2"
                    type="checkbox"
                    class="form-check-input border mr-2"
                    v-model="validate.rodo2.$model"
                >
                <label class="cursor-pointer select-none" for="rodo2"
                >
                    Akceptuję
                </label>
                <a href="/terms/price-list" class="text-theme-1 dark:text-theme-10 ml-1 cursor-pointer"
                   @click.prevent="$router.push({path: '/terms/price-list'})"> cennik usług</a>.
            </div>
            <template v-if="socialPricingConsentError">
                <div
                    class="text-theme-6 mt-2"
                >
                    {{ $t('validation.Value is required') }}
                </div>
            </template>
        </div>

        <button @click="continueSocialRegistration" class="btn btn-primary mt-5 float-right">
            {{ $t('global.continue') }}
        </button>

    </Modal>

</template>


<script>

import {onMounted, reactive, ref, toRefs} from "vue";
import PasswordMeter from 'vue-simple-password-meter';
import {useStore} from '../store';
import {email, minLength, required,} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";
import {useToast} from "vue-toastification";
import {useReCaptcha} from "vue-recaptcha-v3";
import RequestHandler from "../compositions/RequestHandler";
import Modal from "../components/Modal";
import router from "../router";

const toast = useToast();
const store = useStore();

export default {
    components: {
        PasswordMeter,
        Modal
    },

    props: {
        token: String
    },

    setup(props, {emit}) {

        const {executeRecaptcha, recaptchaLoaded} = useReCaptcha();

        onMounted(() => {

            cash("body")
                .removeClass("main")
                .removeClass("error-page")
                .addClass("login");
        });

        const password = ref("");

        const score = ref(null);

        const onScore = (payload) => {
            score.value = payload.score;
        };

        const formData = reactive({
            type: "",
            email: "",
            password: "",
            passwordConfirm: "",
            rodo: "",
            rodo2: "",
            rodo3: "",
        });

        const rules = {
            email: {
                required,
                email,
            },
            rodo: {
                required
            },
            rodo2: {
                required
            },
            rodo3: {
                required
            },
            password: {
                required,
                minLength: minLength(6)
            },
            passwordConfirm: {
                required,
                minLength: minLength(6),
                // sameAs: sameAs(formData.password)
            },
            type: {
                required
            }
        };

        const validate = useVuelidate(rules, toRefs(formData));

        // const s = this.methods.handleSubmit();
        const save = () => {

            if (formData.password !== formData.passwordConfirm) {
                toast.warning('Hasła muszą być takie same');
                return false;
            }

            if (!(formData.rodo && formData.rodo2 && formData.rodo3)) {
                toast.error('Wszystkie zgody muszą być zaznaczone.');
                return false;
            } else if (formData.email === '') {
                toast.error('Email nie może byc pusty');
                return false;
            }
            validate.value.$touch();
            return !validate.value.$invalid;
        };

        const goTo = () => {
                router.push({ path: '/login' })
            };

        const register = async () => {

            await recaptchaLoaded();
            const recaptchaToken = await executeRecaptcha("register");

            RequestHandler('/sanctum/csrf-cookie', 'GET', {}, () => {
                RequestHandler('register', 'POST', {
                    type: formData.type,
                    email: formData.email,
                    password: formData.password,
                    token: props.token,
                    recaptchaToken: recaptchaToken
                }, () =>{
                    goTo();
                });
            });

        };

        return {
            validate,
            formData,
            save,
            password,
            onScore,
            score,
            register,
        };
    },

    data() {
        return {
            error: null,
            modalSocialConsents: false,
            socialSignupProvider: null,
            socialAccountTypeError: false,
            socialPrivacyPolicyConsentError: false,
            socialRulesConsentError: false,
            socialPricingConsentError: false
        }
    },

    methods: {

        handleSubmit(e) {

            let a = this.save();
            if (!a) {
                return false;
            }

            if (this.formData.password !== this.formData.passwordConfirm) {
                return false;
            }

            this.register();
        },

        isSocialSignUpDataValid(displayErrors = true) {

            let isDataValid = true;

            this.socialAccountTypeError = false;
            this.socialPrivacyPolicyConsentError = false;
            this.socialRulesConsentError = false;
            this.socialPricingConsentError = false;

            if (this.formData.type !== 'integrator' && this.formData.type !== 'investor') {

                isDataValid = false;

                if (displayErrors) {
                    this.socialAccountTypeError = true;
                }

            }

            if (!this.formData.rodo) {

                isDataValid = false;

                if (displayErrors) {
                    this.socialPrivacyPolicyConsentError = true;
                }

            }

            if (!this.formData.rodo3) {

                isDataValid = false;

                if (displayErrors) {
                    this.socialRulesConsentError = true;
                }

            }

            if (!this.formData.rodo2) {
                isDataValid = false;

                if (displayErrors) {
                    this.socialPricingConsentError = true;
                }
            }

            return isDataValid;
        },

        handleSocialRegistration(provider, e) {

            e.preventDefault();
            this.socialSignupProvider = provider;

            if (this.isSocialSignUpDataValid(false)) {
                this.continueSocialRegistration(e);
            } else {
                this.modalSocialConsents = true;
            }
        },

        continueSocialRegistration(e) {
            if (this.isSocialSignUpDataValid()) {

                window.location.href =
                    "/auth/social/" + this.socialSignupProvider + "/sign_up?"
                    + "privacyPolicyConsent=1&"
                    + "serviceRulesConsent=1&"
                    + "pricingConsent=1&"
                    + "accountType=" + this.formData.type;

            }
        }
    },

    validate() {
        if (this.password.length > 0) {

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
