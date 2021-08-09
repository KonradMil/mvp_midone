<template>
    <vue-easy-lightbox
        :visible="lightboxVisible"
        :imgs="images"
        :index="lightBoxIndex"
        @hide="hideLightbox"
    ></vue-easy-lightbox>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div
                    class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                >
                    <h2 class="font-medium text-base mr-auto">{{$t('challengesMain.basicData')}}</h2>
                </div>
                <div class="px-5 pt-5">
                    <div class="font-medium text-lg"><strong>{{$t('global.name')}}</strong> {{ challenge.name }}</div>
                    <div class="font-medium text-lg dark:text-theme-10 text-theme-1"><strong>Etap:</strong> {{ stage }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-600 mt-2">
                        <strong>{{$t('challengesMain.basicInformation')}}:</strong> {{ types[challenge.type] }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-600 mt-2" style="word-break: keep-all; max-height: 100px; overflow-y: scroll; white-space: pre-wrap;">
                        <strong>{{$t('challengesNew.description')}}:</strong> {{ challenge.description }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-600 mt-2">
                        <strong>{{$t('challengesMain.deadlineSubmissionSolutions')}}:</strong>
                        <Litepicker
                            id="post-form-2"
                            v-model="challenge.solution_deadline"
                            v-if="inTeam"
                            :options="{
                autoApply: false,
                lang: 'pl',
                format: 'DD.MM.YYYY',
                showWeekNumbers: true,
                 buttonText: {'apply':'OK','cancel':'Anuluj'},
                dropdowns: {
                  minYear: 2021,
                  maxYear: null,
                  months: true,
                  years: true
                }
              }" class="form-control"/>
                        <span v-if="!inTeam"> {{ $dayjs(challenge.solution_deadline).format('DD.MM.YYYY') }} </span>
                    </div>
                    <div class="text-gray-700 dark:text-gray-600 mt-2">
                        <strong>{{$t('challengesMain.deadlineSubmissionOffers')}}:</strong>
                        <Litepicker
                            id="post-form-3"
                            v-model="challenge.offer_deadline"
                            v-if="inTeam"
                            :options="{
                                autoApply: false,
                                lang: 'pl',
                                format: 'DD.MM.YYYY',
                                showWeekNumbers: true,
                                buttonText: {'apply':'OK','cancel':'Anuluj'},
                                dropdowns: {
                                minYear: 2021,
                                maxYear: null,
                                months: true,
                                years: true
                            }
                        }" class="form-control"/>
                        <span v-if="!inTeam"> {{ $dayjs(challenge.offer_deadline).format('DD.MM.YYYY') }} </span>
                    </div>
                    <button v-if="inTeam && challenge.stage < 3" class="btn btn-secondary ml-auto my-1" @click="saveDate">
                        {{$t('challengesMain.changeDates')}}
                    </button>
                    <div class="flex items-center my-5">
                        <div
                            class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium"
                            v-if="$dayjs().isBefore($dayjs(challenge.offer_deadline))"
                        >
                            {{$t('challengesMain.nextDeadline')}}:
                            <span v-if="$dayjs().isAfter($dayjs(challenge.solution_deadline))">Składanie rozwiązań do: {{ $dayjs(challenge.solution_deadline).format('DD.MM.YYYY') }}</span>
                            <span v-if="$dayjs().isBefore($dayjs(challenge.solution_deadline))">Składanie ofert do: {{ $dayjs(challenge.offer_deadline).format('DD.MM.YYYY') }}</span>
                        </div>
                        <button v-if="!challenge.followed && challenge.stage < 3" class="btn btn-secondary ml-auto" @click="follow">
                            {{$t('challengesMain.follow')}}
                        </button>

                        <button v-if="challenge.followed && challenge.stage < 3" class="btn btn-secondary ml-auto" @click="unfollow">
                            {{$t('challengesMain.unFollow')}}
                        </button>
                    </div>
                </div>
            </div>
            <!-- END: Announcement -->
            <!-- BEGIN: Daily Sales -->
            <div class="intro-y box col-span-12 xxl:col-span-6">
                <div
                    class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5"
                >
                    <h2 class="font-medium text-base mr-auto">{{$t('challengesNew.photo')}}</h2>
                </div>

                <div class="p-10" v-if="challenge.screenshot_path != undefined">
                    <TinySlider :options="{
                            mode: 'gallery',
                            controls: true,
                            nav: true,
                            speed: 500,
                          }">
                        <div class="h-64 px-2" @click="showImage(0)">
                            <div class="h-full image-fit rounded-md overflow-hidden">
                                <img :alt="challenge.name" :src="'/' + challenge.screenshot_path"/>
                            </div>
                        </div>
                        <div class="h-64 px-2" v-for="(file, index) in challenge.files" @click="showImage(index + 1)">
                            <div class="h-full image-fit rounded-md overflow-hidden">
                                <img :alt="challenge.name" :src="'/' + file.path"/>
                            </div>
                        </div>
                    </TinySlider>
                </div>
            </div>
            <!-- END: Daily Sales -->

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
        inTeam: Boolean
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
