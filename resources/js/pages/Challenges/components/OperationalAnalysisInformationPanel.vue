<template>
    <div class="intro-y box mt-5">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Bordered Table
            </h2>
            <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                <label class="form-check-label ml-0 sm:ml-2" for="show-example-2">Show example code</label>
                <input data-target="#bordered-table" class="show-code form-check-switch mr-0 ml-3" type="checkbox" id="show-example-2">
            </div>
        </div>
        <div class="p-5" id="bordered-table">
            <div class="preview">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">First Name</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Last Name</th>
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Username</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="border">1</td>
                            <td class="border">Angelina</td>
                            <td class="border">Jolie</td>
                            <td class="border">@angelinajolie</td>
                        </tr>
                        <tr>
                            <td class="border">2</td>
                            <td class="border">Brad</td>
                            <td class="border">Pitt</td>
                            <td class="border">@bradpitt</td>
                        </tr>
                        <tr>
                            <td class="border">3</td>
                            <td class="border">Charlie</td>
                            <td class="border">Hunnam</td>
                            <td class="border">@charliehunnam</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="source-code hidden">
                <button data-target="#copy-bordered-table" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
                <div class="overflow-y-auto mt-3 rounded-md">
                    <pre class="source-preview" id="copy-bordered-table"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTagdiv class=&quot;overflow-x-auto&quot;HTMLCloseTag HTMLOpenTagtable class=&quot;table&quot;HTMLCloseTag HTMLOpenTagtheadHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTag#HTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagFirst NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagLast NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagUsernameHTMLOpenTag/thHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/theadHTMLCloseTag HTMLOpenTagtbodyHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag1HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagAngelinaHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagJolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@angelinajolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag2HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagBradHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagPittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@bradpittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag3HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagCharlieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTagHunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border&quot;HTMLCloseTag@charliehunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/tbodyHTMLCloseTag HTMLOpenTag/tableHTMLCloseTag HTMLOpenTag/divHTMLCloseTag </code> </pre>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref} from "vue";
import {useToast} from "vue-toastification";
import VueEasyLightbox from 'vue-easy-lightbox'

export default {
    name: "BasicInformationPanel",
    props: {
        challenge: Object,

    },
    components: {
        VueEasyLightbox
    },
    setup(props) {
        const challenge = computed(() => {
            return props.challenge;
        });
        const toast = useToast();
        const types = require("../../../json/types.json");
        const lightboxVisible = ref(false);
        const images = computed(() => {
            let a = [];
            a.push('/' + props.challenge.screenshot_path);
            if (props.challenge.files != undefined) {
                if (props.challenge.files.length > 0) {
                    props.challenge.files.forEach((val) => {
                        a.push('/' + val.path);
                    });
                }
            }
            return a;
        })
        const lightBoxIndex = ref(0);

        onMounted(() => {
            console.log("props.challenge");
            console.log(props.challenge);
            // images.value.push('/' + props.challenge.screenshot_path);
        });

        const showImage = (index) => {
            console.log(index);
            lightboxVisible.value = true;
            lightBoxIndex.value = index;
        }

        const hideLightbox = () => {
            lightboxVisible.value = false;
        }

        const follow = () => {
            axios.post('/api/challenge/user/follow', {id: props.challenge.id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        challenge.value.followed = true;
                        toast.success('Teraz śledzisz to wyzwanie.');
                    } else {

                    }
                })
        }

        const unfollow = () => {
            axios.post('/api/challenge/user/unfollow', {id: props.challenge.id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        challenge.value.followed = false;
                        toast.success('Nie śledzisz już tego wyzwania.');
                    } else {

                    }
                })
        }

        const saveDate = () => {
            axios.post('/api/challenge/change/dates', {id: challenge.value.id, offer_deadline: challenge.value.offer_deadline, solution_deadline: challenge.value.solution_deadline})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        toast.success('Daty zmienione.');
                    } else {

                    }
                })
        }

        const stage = computed(function () {
            switch (challenge.value.stage) {
                case 0:
                    return 'Szkic';
                    break;
                case 1:
                    return 'Oczekiwanie na rozwiązania';
                    break;
                case 2:
                    return 'Oczekiwanie na oferty';
                    break;
                case 3:
                    return 'Podisywanie umowy';
                    break;
                case 4:
                    return 'Planowanie projektu';
                    break;
                case 5:
                    return 'Wdrażanie';
                    break;
                case 6:
                    return 'Fakturowanie';
                    break;
            }
        });

        return {
            stage,
            challenge,
            types,
            follow,
            unfollow,
            lightboxVisible,
            lightBoxIndex,
            images,
            showImage,
            hideLightbox,
            saveDate
        }
    }
}
</script>

<style scoped>

</style>
