<template>
    <div class="intro-y box lg:mt-5" style="width: 700px; height: 350px; margin-top: -2px;">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Raport z fazy planowania
            </h2>
        </div>
        <table class="table" style="max-width: 650px; margin-left: 20px;">
            <thead>
            <tr>
                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap" style="width: 10px;">Lp.</th>
                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Krok w procesie</th>
                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border" style="width: 10px;">1</td>
                <td class="border">Plan komunikacji</td>
                <td class="border">
                    <div class="text-theme-9" v-if="project.accept_communication === 1 && project.accept_communication !== 3">Akceptacja ze strony integratora</div>
                    <div class="text-theme-9" v-if="project.accept_communication === 2 && project.accept_communication !== 3">Akceptacja ze strony inwestora</div>
                    <div class="text-theme-9" v-if="project.accept_communication === 3">Zaakceptowały obie strony</div>
                    <div class="" v-if="project.accept_communication === 0">W trakcie</div>
                </td>
            </tr>
            <tr>
                <td class="border" style="width: 10px;">2</td>
                <td class="border">Mapa ryzyka w projekcie</td>
                <td class="border">
                    W trakcie
                </td>
            </tr>
            <tr>
                <td class="border" style="width: 10px;">3</td>
                <td class="border">Koncepcja stanowiska</td>
                <td class="border">
                    W trakcie
                </td>
            </tr>
            <tr>
                <td class="border" style="width: 10px;">4</td>
                <td class="border">Harmonogram wg wzoru</td>
                <td class="border">
                    W trakcie
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {ref} from "vue";
import {useToast} from "vue-toastification";

export default {
    name: 'ReportSecondStage.vue',
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
