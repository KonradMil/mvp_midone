<template>
    <div class="intro-y box lg:mt-5" style="width: 350px; height: 280px; margin-top: -2px;">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Podgląd fazy 1
            </h2>
        </div>
        <!-- END: Display Information -->
        <div class="pl-4 pb-5">
            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm ">
                <input
                    id="rodo"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    v-model="project.project_accept_vision"
                    disabled/>
                <label class="cursor-pointer select-none" for="rodo">
                    Akceptacja wizji lokalnej</label>
            </div>
            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">
                <input
                    id="rodo3"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    :checked="project.project_accept_offer"
                     disabled/>
                <label class="cursor-pointer select-none" for="rodo3">
                    Akceptacja oferty
                </label>
            </div>
            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5">
                <input
                    id="rodo2"
                    type="checkbox"
                    class="form-check-input border mr-2 ring-0"
                    :checked="project.project_accept_details"
                     disabled/>
                <label class="cursor-pointer select-none" for="rodo2">
                    Akceptacja założen projektu
                </label>
            </div>
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
    props:{
        project: Object
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
