<template>
    <div>
        <DarkModeSwitcher/>
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Register Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="" class="-intro-x flex items-center pt-5">
                        <img
                            alt="DBR77 Platforma Robotów "
                            class="w-2/4"
                            src="https://dbr77.com/wp-content/uploads/2020/02/logo_dbr_white.png"
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
                <!-- END: Register Info -->
                <!-- BEGIN: Register Form -->

                <div class="h-screen xl:h-auto flex py-15 xl:py-18 my-10 xl:my-0 ">
                    <form class="validate-form" @submit.prevent="handleSubmit">
                    <div
                        class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 mt-20 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto"
                    >
                        <h2
                            class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left"
                        >
                            {{$t('register.signup')}}
                        </h2>
                        <div
                            class="intro-x mt-2 text-gray-500 dark:text-gray-500 xl:hidden text-center"
                        >
                            A few more clicks to sign in to your account. Manage all your
                            e-commerce accounts in one place
                        </div>
                        <div class="intro-x mt-8">
                            <div class="mt-3"><label>{{$t('register.iam')}}</label>
                                <div class="flex flex-col sm:flex-row mt-2">
                                    <div class="form-check mr-2">
                                        <input id="radio-switch-4" v-model="validate.type.$model" class="form-check-input"
                                                                        type="radio" name="horizontal_radio_button"
                                                                        value="integrator"/> <label
                                        class="form-check-label"
                                        for="radio-switch-4">{{$t('common.integratorem')}}</label></div>
                                    <div class="form-check mr-2 mt-2 sm:mt-0">
                                        <input id="radio-switch-5"  v-model="validate.type.$model"
                                                                                     class="form-check-input"
                                                                                     type="radio"
                                                                                     name="horizontal_radio_button"
                                                                                     value="investor"/>
                                        <label class="form-check-label"
                                               for="radio-switch-5">{{$t('common.investorem')}}</label></div>
                                </div>
                                <template v-if="validate.type.$error">
                                    <div
                                        v-for="(error, index) in validate.type.$errors"
                                        :key="index"
                                        class="text-theme-6 mt-2"
                                    >
                                        {{ $t('validation.' + error.$message)}}
                                    </div>
                                </template>
                            </div>
                            <input
                                type="text"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                placeholder="Email"
                                v-model.trim="validate.email.$model"
                            />
                            <template v-if="validate.email.$error">
                                <div
                                    v-for="(error, index) in validate.email.$errors"
                                    :key="index"
                                    class="text-theme-6 mt-2"
                                >
                                    {{ $t('validation.' + error.$message) }}
                                </div>
                            </template>
                            <input
                                type="password"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                :placeholder="$t('login.password')" autocomplete="new-password"
                                v-model.trim="validate.password.$model"
                            />
                            <template v-if="validate.password.$error">
                                <div
                                    v-for="(error, index) in validate.password.$errors"
                                    :key="index"
                                    class="text-theme-6 mt-2"
                                >
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
                                <div v-if="score === 0 || score == undefined" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                <div v-if="score === 0 || score == undefined" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                <div v-if="score === 0 || score == undefined" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                <div v-if="score === 0 || score == undefined" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                <div v-if="score === 1" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                <div v-if="score === 1" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                <div v-if="score === 1" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                <div v-if="score === 2" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                <div v-if="score === 2" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                                <div v-if="score === 3" class="col-span-3 h-full rounded bg-gray-200 dark:bg-dark-2"></div>
                            </div>
                            <a
                                href=""
                                class="intro-x text-gray-600 block mt-2 text-xs sm:text-sm"
                            >{{$t('register.safepassword')}}</a
                            >
                            <input
                                type="password"
                                class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4"
                                :placeholder="$t('register.passwordConfirm')"
                                v-model="validate.passwordConfirm.$model"
                            />
                            <template v-if="validate.passwordConfirm.$error">
                                <div
                                    v-for="(error, index) in validate.passwordConfirm.$errors"
                                    :key="index"
                                    class="text-theme-6 mt-2"
                                >
                                    {{ $t('validation.' + error.$message) }}
                                </div>
                            </template>
                            <password-meter @score="onScore" :password="validate.password.$model" />
                        </div>
                        <div
                            class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"
                        >
                            <input
                                id="rodo"
                                type="checkbox"
                                class="form-check-input border mr-2"
                                v-model="validate.rodo.$model"
                            />
                            <label class="cursor-pointer select-none" for="rodo"
                            >Akceptuję postanowienia </label
                            >
                            <div class="text-theme-1 dark:text-theme-10 ml-1"
                            @click.prevent="$router.push({path: '/terms/privacy-policy'})"> polityki prywatności.</div>.
                        </div>
                        <template v-if="validate.rodo.$error">
                            <div
                                v-for="(error, index) in validate.rodo.$errors"
                                :key="index"
                                class="text-theme-6 mt-2">
                                {{ $t('validation.' + error.$message) }}
                            </div>
                        </template>
                        <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                            <input id="rodo3" type="checkbox" class="form-check-input border mr-2" v-model="validate.rodo3.$model"/>
                            <label class="cursor-pointer select-none" for="rodo3">Akceptuję </label>
                            <div class="text-theme-1 dark:text-theme-10 ml-1" @click.prevent="$router.push({path: '/terms/terms-of-service'})"> warunki świadczenia  </div>  usług na platformie DBR77.com.
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
                            <label class="cursor-pointer select-none" for="rodo2"
                            >
                                Akceptuję
                            </label>
                            <div class="text-theme-1 dark:text-theme-10 ml-1"
                                 @click.prevent="$router.push({path: '/terms/price-list'})"> cennik usług</div>.
                        </div>
                        <template v-if="validate.rodo2.$error">
                            <div
                                v-for="(error, index) in validate.rodo2.$errors"
                                :key="index"
                                class="text-theme-6 mt-2"
                            >
                                {{ $t('validation.' + error.$message) }}
                            </div>
                        </template>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button type="submit"
                                class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top"
                            >
                                {{$t('register.signup')}}
                            </button>
                            <button    @click="$router.push('login')"
                                class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top"
                            >
                                {{$t('login.login')}}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- END: Register Form -->
            </div>
        </div>
    </div>
</template>


<script>
    import {defineComponent, onMounted, ref, reactive, toRefs} from "vue";
    import DarkModeSwitcher from "../components/dark-mode-switcher/Main.vue";
    import PasswordMeter from 'vue-simple-password-meter';
    import {useStore} from '../store';
    import {
        required,
        minLength,
        email,
        sameAs,
    } from "@vuelidate/validators";
    import { useVuelidate } from "@vuelidate/core";
    import {useToast} from "vue-toastification";
    const toast = useToast();
    const store = useStore();

    export default {
        components: {
            DarkModeSwitcher,
            PasswordMeter,
        },
        props: {
          token: String
        },
        setup(props, {emit}) { onMounted(() => {


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
                    // async isUnique (value) {
                    //     if (value === '') return true
                    //     const response = await fetch(`/api/email/unique/${value}`)
                    //     return Boolean(await response.json())
                    // }
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
                console.log('here');
                if(formData.password != formData.passwordConfirm) {
                    toast.warning('Hasła muszą być takie same');
                    return false;
                }
                console.log((formData.rodo && formData.rodo2 && formData.rodo3));
                console.log(formData.rodo);
                console.log(formData.rodo2);
                console.log(formData.rodo3);
                if(!(formData.rodo && formData.rodo2 && formData.rodo3)) {
                    toast.error('Wszystkie zgody muszą być zaznaczone.');
                    return false;
                }

                else if(formData.email === '')
                {
                    toast.error('Email nie może byc pusty');
                    return false;
                }
                validate.value.$touch();
                if (validate.value.$invalid) {
                    return false;
                } else {
                    return true;
                }
            };


            return {
                validate,
                formData,
                save,
                password,
                onScore,
                score,
            };
        },
        data() {
            return {
                error: null
            }
        },
        methods: {
            handleSubmit(e) {
                let a = this.save();
                if(!a) {
                    return false;
                }
                console.log('here');
                if(this.formData.password != this.formData.passwordConfirm) {
                    return false;
                }
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/api/register', {
                        type: this.formData.type,
                        email: this.formData.email,
                        password: this.formData.password,
                        token: this.token
                    })
                        .then(response => {
                            if (response.data.success) {
                                let user = response.data.payload;
                                store.dispatch('login/login', {
                                    user
                                });
                                window.location.replace('/kreator');
                            } else {
                                toast.warning(response.data.message);
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
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
