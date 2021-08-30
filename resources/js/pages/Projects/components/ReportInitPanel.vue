<template>
    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                {{$t('profiles.agreements')}}
            </h2>
        </div>
        <!-- END: Display Information -->
        <div class="pl-4 pb-5">
            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm ">
                <input
                    id="rodo"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    v-model="project_accept_local_vision"
                    disabled/>
                <label class="cursor-pointer select-none" for="rodo">
                    Akceptacja wizji lokalnej</label>
            </div>
            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                <input
                    id="rodo3"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    :checked="project_accept_offer"/>
                <label class="cursor-pointer select-none" for="rodo3">
                    Akceptacja oferty
                </label>
            </div>
            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5">
                <input
                    id="rodo2"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    :checked="project_accept_details"
                    disabled/>
                <label class="cursor-pointer select-none" for="rodo2">
                    Akceptacja założen projektu
                </label>
            </div>
<!--            <div class="border-b border-gray-200 dark:border-dark-5"></div>-->
<!--            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"-->
<!--                 v-if="user.type == 'integrator'">-->
<!--                <input-->
<!--                    id="q1"-->
<!--                    type="checkbox"-->
<!--                    class="form-check-input border mr-2 ring-0"-->
<!--                    @click="new_answer = !new_answer"-->
<!--                    :checked="new_answer"-->
<!--                />-->
<!--                <label class="cursor-pointer select-none" for="q1">-->
<!--                    {{$t('profiles.notifyQuestion')}}-->
<!--                </label>-->
<!--            </div>-->
<!--            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm"-->
<!--                 v-if="user.type == 'integrator'">-->
<!--                <input-->
<!--                    id="q2"-->
<!--                    type="checkbox"-->
<!--                    class="form-check-input border mr-2 ring-0"-->
<!--                    @click="solution_accepted = !solution_accepted"-->
<!--                    :checked="solution_accepted"/>-->
<!--                <label class="cursor-pointer select-none" for="q2">-->
<!--                    {{$t('profiles.informSolution')}}-->
<!--                </label>-->
<!--            </div>-->
<!--            <div v-if="user.type == 'integrator'"-->
<!--                 class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">-->
<!--                <input-->
<!--                    id="q3"-->
<!--                    type="checkbox"-->
<!--                    class="form-check-input border mr-2 ring-0"-->
<!--                    @click="offer_accepted = !offer_accepted"-->
<!--                    :checked="offer_accepted"/>-->
<!--                <label class="cursor-pointer select-none" for="q3">-->
<!--                    {{$t('profiles.informService')}}-->
<!--                </label>-->
<!--            </div>-->
            <button class="btn btn-primary w-20 mt-3">{{$t('profiles.save')}}</button>
        </div>
    </div>
</template>

<script>
import {ref} from "vue";
import {useToast} from "vue-toastification";

export default {
    name: 'ReportInitPanel.vue',
    components: {
    },
    setup() {
        const user = window.Laravel.user;
        const project_accept_local_vision = ref(false);
        const project_accept_offer = ref(false);
        const project_accept_details = ref(false);
        const toast = useToast();

        return {
            user,
            project_accept_local_vision,
            project_accept_offer,
            project_accept_details
        };
    },
}
</script>

<style scoped>

</style>
