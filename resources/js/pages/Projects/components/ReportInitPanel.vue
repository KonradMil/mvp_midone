<template>
    <div class="intro-y box lg:mt-5" style="width: 350px; height: 280px; margin-top: -2px;">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Raport z fazy inicjowania
            </h2>
        </div>
        <!-- END: Display Information -->
<!--        <div class="pl-4 pb-5">-->
<!--            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm ">-->
<!--                <input-->
<!--                    id="rodo"-->
<!--                    type="checkbox"-->
<!--                    class="form-check-input border mr-2 ring-0"-->
<!--                    :checked="project.project_accept_vision"-->
<!--                    disabled/>-->
<!--                <label class="cursor-pointer select-none" for="rodo">-->
<!--                    Akceptacja wizji lokalnej</label>-->
<!--                <div class="text-theme-9">-->
<!--                    Zaakceptowano-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm">-->
<!--                <input-->
<!--                    id="rodo3"-->
<!--                    type="checkbox"-->
<!--                    class="form-check-input border mr-2 ring-0"-->
<!--                    :checked="project.project_accept_offer"-->
<!--                     disabled/>-->
<!--                <label class="cursor-pointer select-none" for="rodo3">-->
<!--                    Akceptacja oferty-->
<!--                </label>-->
<!--            </div>-->
<!--            <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 mt-4 text-xs sm:text-sm pb-5">-->
<!--                <input-->
<!--                    id="rodo2"-->
<!--                    type="checkbox"-->
<!--                    class="form-check-input border mr-2 ring-0"-->
<!--                    :checked="project.project_accept_details"-->
<!--                     disabled/>-->
<!--                <label class="cursor-pointer select-none" for="rodo2">-->
<!--                    Akceptacja założen projektu-->
<!--                </label>-->
<!--            </div>-->
<!--        </div>-->
        <table class="table">
            <thead>
            <tr>
                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Lp.</th>
                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Krok w procesie</th>
                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border">1</td>
                <td class="border">Przygotowanie karty danych w projekcie</td>
                <td class="border">statis</td>
            </tr>
            <tr>
                <td class="border">2</td>
                <td class="border">Wizja lokalna</td>
                <td class="border">stat</td>
            </tr>
            <tr>
                <td class="border">3</td>
                <td class="border">Akceptacja założeń technicznych</td>
                <td class="border">satus</td>
            </tr>
            <tr>
                <td class="border">4</td>
                <td class="border">Podsumowanie z oferty</td>
                <td class="border">status</td>
            </tr>
            </tbody>
        </table>

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
        const toast = useToast();

        return {
            user,
        };
    },
}
</script>

<style scoped>

</style>
