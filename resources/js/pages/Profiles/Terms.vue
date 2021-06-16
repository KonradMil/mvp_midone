<template>
    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                {{$t('profiles.agreements')}}
            </h2>
        </div>
        <!-- END: Display Information -->
        <div class="pl-4 pb-5">
            <div
                class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm "
            >
                <input
                    id="rodo"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    v-model="user.privacy_policy"
                    disabled
                />
                <label class="cursor-pointer select-none" for="rodo"
                >{{$t('profiles.acceptProvisions')}}</label
                >
                <a class="text-theme-1 dark:text-theme-10 ml-1" href="/terms/privacy-policy"
                   @click.prevent="$router.push({path: '/terms/privacy-policy'})"
                >{{$t('profiles.privacyPolicy')}}</a
                >.
            </div>
            <div
                class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"
            >
                <input
                    id="rodo3"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    :checked="user.terms"
                    disabled
                />
                <label class="cursor-pointer select-none" for="rodo3"
                >{{$t('profiles.accept')}}</label
                >
                <a class="text-theme-1 dark:text-theme-10 ml-1" href="/terms/terms-of-service"
                   @click.prevent="$router.push({path: '/terms/terms-of-service'})"
                > {{$t('profiles.termsService')}} </a
                > {{$t('profiles.servicesPlatform')}}
            </div>
            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5">
                <input
                    id="rodo2"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    :checked="user.pricing"
                    disabled/>
                <label class="cursor-pointer select-none" for="rodo2">
                    {{$t('profiles.accept')}}
                </label>
                <a class="text-theme-1 dark:text-theme-10 ml-1" href="/terms/price-list"
                   @click.prevent="$router.push({path: '/terms/price-list'})">
                    {{ $t('profiles.priceList')}}
                </a>.
            </div>
            <div class="border-b border-gray-200 dark:border-dark-5"></div>
            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"
                v-if="user.type == 'integrator'">
                <input
                    id="q1"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    @click="new_answer = !new_answer"
                    :checked="new_answer"
                />
                <label class="cursor-pointer select-none" for="q1">
                    {{$t('profiles.notifyQuestion')}}
                </label>
            </div>
            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"
                v-if="user.type == 'integrator'">
                <input
                    id="q2"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    @click="solution_accepted = !solution_accepted"
                    :checked="solution_accepted"/>
                <label class="cursor-pointer select-none" for="q2">
                    {{$t('profiles.informSolution')}}
                </label>
            </div>
            <div v-if="user.type == 'integrator'"
                class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                <input
                    id="q3"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    @click="offer_accepted = !offer_accepted"
                    :checked="offer_accepted"/>
                <label class="cursor-pointer select-none" for="q3">
                    {{$t('profiles.informService')}}
                </label>
            </div>
            <button class="btn btn-primary w-20 mt-3" @click="save">{{$t('profiles.save')}}</button>
        </div>
    </div>
</template>

<script>
import DarkModeSwitcher from "../../components/dark-mode-switcher/Main";
import {ref} from "vue";
import {useToast} from "vue-toastification";

export default {
    components: {
        DarkModeSwitcher,
    },
    setup() {
        const new_answer = ref(false);
        const solution_accepted = ref(false);
        const offer_accepted = ref(false);
        const user = window.Laravel.user;
        new_answer.value = user.new_answer;
        offer_accepted.value = user.offer_accepted;
        solution_accepted.value = user.solution_accepted;
        const toast = useToast();
        const save = () => {
            axios.post('/api/user/terms/save', {new_answer: new_answer.value, solution_accepted: solution_accepted.value, offer_accepted: offer_accepted.value})
                .then(response => {
                    if(response.data.success) {
                        toast.success('Zapisano poprawnie.');
                        window.location.reload();
                    } else {
                        toast.error('Błąd');
                    }
                })
        }
        return {
            save,
            user,
            new_answer,
            offer_accepted,
            solution_accepted
        };
    },
    data() {
        return {
            error: null,
            privacy_policy: '',
            pricing: '',
            terms:'',
        }
    },
}
</script>

<style scoped>

</style>
