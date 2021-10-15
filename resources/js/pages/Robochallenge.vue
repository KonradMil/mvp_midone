<template>
    <div>
        <DarkModeSwitcher/>
        <div class="container sm:px-10">en
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
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 my-5 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">

                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            RoboHakaton
                        </h2>
                        <div class="intro-x mt-2 text-gray-500">
                            Formularz zgłoszeniowy do konkursu
                        </div>

                        <div class="intro-x mt-4">
                            <input
                                type="text"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block"
                                placeholder="Imię"
                                v-model="firstName"
                            />
                            <input
                                type="text"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                placeholder="Nazwisko"
                                v-model="lastName"
                            />
                            <input
                                type="text"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                placeholder="Nr telefonu"
                                v-model="phoneNumber"
                            />
                            <input
                                type="text"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                placeholder="Nazwa firmy (opcjonalnie)"
                                v-model="companyName"
                            />
                            <input
                                type="text"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                placeholder="Email"
                                v-model="email"
                            />
                            <input
                                @keyup.enter="handleSubmit"
                                type="password"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                placeholder="Hasło"
                                v-model="password"
                            />
                            <input
                                @keyup.enter="handleSubmit"
                                type="password"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                placeholder="Powtórz hasło"
                                v-model="passwordConfirmation"
                            />
                        </div>

                        <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <input
                                    id="cb-rules-consent"
                                    type="checkbox"
                                    class="form-check-input border mr-2"
                                    v-model="competitionRulesConsent"
                                />
                                <label class="cursor-pointer select-none" for="cb-rules-consent">
                                    Oświadczam, że zapoznałem się oraz akceptuję
                                    <a
                                        href="https://cdn.dbr77.com/wp-content/uploads/2021/10/Regulamin-konkursu-DBR77-RoboHakaton.pdf"
                                        class="text-theme-1 dark:text-theme-10 mx-1 cursor-pointer"
                                        target="_blank"
                                    >
                                        Regulamin
                                    </a>
                                    konkursu
                                </label>
                            </div>
                        </div>

                        <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <input
                                    id="cb-privacy-policy-consent"
                                    type="checkbox"
                                    class="form-check-input border mr-2"
                                    v-model="privacyPolicyConsent"
                                />
                                <label class="cursor-pointer select-none" for="cb-privacy-policy-consent">
                                    Oświadczam, że zapoznałem się z oraz akceptuję
                                    <a @click.prevent="$router.push({path: '/terms/privacy-policy'})" class="text-theme-1 dark:text-theme-10 mx-1 cursor-pointer">
                                        Politykę Prywatności
                                    </a>
                                    platformy DBR77
                                </label>
                            </div>
                        </div>

                        <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <input
                                    id="cb-data-processing-consent"
                                    type="checkbox"
                                    class="form-check-input border mr-2"
                                    v-model="dataProcessingConsent"
                                />
                                <label class="cursor-pointer select-none" for="cb-data-processing-consent">
                                    Wyrażam zgodę na przetwarzanie moich danych osobowych w związku z udziałem w konkursie.
                                </label>
                            </div>
                        </div>

                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button class="btn btn-primary py-3 px-4 w-full xl:w-64 xl:mr-3 align-top" @click="handleSubmit">
                                Wyślij zgłoszenie
                            </button>
                        </div>

                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted} from "vue";
import DarkModeSwitcher from "../components/dark-mode-switcher/Main.vue";
import cash from "cash-dom";
import {useToast} from "vue-toastification";
import {useStore} from '../store';
import Modal from "../components/Modal";

const toast = useToast();
const store = useStore();

export default {

    components: {
        DarkModeSwitcher,
        Modal
    },

    setup() {
        onMounted(() => {
            cash("body")
                .removeClass("main")
                .removeClass("error-page")
                .addClass("login");
        });
    },

    data() {
        return {
            firstName: "",
            lastName: "",
            phoneNumber: "",
            companyName: "",
            email: "",
            password: "",
            passwordConfirmation: "",
            competitionRulesConsent: 0,
            privacyPolicyConsent: 0,
            dataProcessingConsent: 0
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault();

            this.$axios.post(
                '/api/robochallenge',
                {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    phoneNumber: this.phoneNumber,
                    companyName: this.companyName,
                    email: this.email,
                    password: this.password,
                    passwordConfirmation: this.passwordConfirmation,
                    competitionRulesConsent: this.competitionRulesConsent,
                    privacyPolicyConsent: this.privacyPolicyConsent,
                    dataProcessingConsent: this.dataProcessingConsent
                }
            ).then((response) => {

                if(typeof response.data.success !== "undefined") {
                    toast.success(response.data.success);

                    this.firstName = "",
                    this.lastName = "",
                    this.phoneNumber = "",
                    this.companyName = "",
                    this.email = "",
                    this.password = "",
                    this.passwordConfirmation = "",
                    this.competitionRulesConsent = 0,
                    this.privacyPolicyConsent = 0,
                    this.dataProcessingConsent = 0

                }

            }).catch(function(error){

                if(error.response.data.errors !== "undefined") {

                    let message = "";

                    for(let k in error.response.data.errors) {
                        message += (parseInt(k)+1) + ". "+error.response.data.errors[k]+"\n";
                    }

                    toast.error(message)

                }

            });

        }
    },
}
</script>
