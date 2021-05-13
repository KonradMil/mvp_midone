<template>
    <div v-if="challenge != undefined">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Wyzwanie</h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Profile Menu -->
            <div
                class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse"
            >
                <div class="intro-y box mt-5 lg:mt-0">
                    <div class="relative flex items-center p-5">
                        <div class="w-12 h-12 image-fit">
                            <img
                                v-if="challenge.screenshot_path != undefined"
                                class="rounded-full"
                                :alt="challenge.name" :src="'/' + challenge.screenshot_path"
                            />
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="font-medium text-base">
                                {{ challenge.name }} <span class="text-theme-1 dark:text-theme-10" v-if="challenge.status == 0"> - Szkic</span>
                            </div>
                            <div class="text-gray-600">{{ types[challenge.type] }}</div>
                        </div>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a
                            class="flex items-center"
                            href=""
                            @click.prevent="activeTab = 'podstawowe'"
                            :class="(activeTab == 'podstawowe')? ' text-theme-1 dark:text-theme-10 font-medium' : ''"
                        >
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                            Informacje podstawowe
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'techniczne'"
                           :class="(activeTab == 'techniczne')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'"
                        >
                            <BoxIcon class="w-4 h-4 mr-2"/>
                            Szczegóły techniczne
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'rozwiazania'"
                           :class="(activeTab == 'rozwiazania')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'"
                        >
                            <LockIcon class="w-4 h-4 mr-2"/>
                            Rozwiązania
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'oferty'"
                           :class="(activeTab == 'oferty')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'"
                        >
                            <SettingsIcon class="w-4 h-4 mr-2"/>
                            Oferty
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'pytania'"
                           :class="(activeTab == 'pytania')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'"
                        >
                            <SettingsIcon class="w-4 h-4 mr-2"/>
                            Pytania
                        </a>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a class="flex items-center" href="">
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                            Zespoły
                        </a>

                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex" v-if="challenge.author_id == user.id">
                        <button type="button" class="btn btn-primary py-1 px-2">
                            Edytuj
                        </button>
                        <button type="button" class="btn btn-primary py-1 px-2 ml-2" @click="$router.push({name: 'challengeStudio', params: {id: challenge.id, type: 'challenge', load: challenge}})">
                            Studio 3D
                        </button>
                        <button
                            v-if="challenge.status == 0"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click="publish(challenge.id)"
                        >
                            Opublikuj
                        </button>
                        <button
                            v-if="challenge.status == 1 && challenge.solutions.length == 0"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click="unpublish(challenge.id)"
                        >
                            Odpublikuj
                        </button>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex" v-if="challenge.author_id != user.id && user.type == 'integrator'">

                        <button
                            v-if="challenge.stage == 1"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                        >
                            Dodaj rozwiązanie
                        </button>
                        <button
                            v-if="challenge.stage == 2"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                        >
                            Złóż ofertę
                        </button>
                    </div>
                </div>
                <WhatsNext :user="user" :challenge="challenge"></WhatsNext>
            </div>
            <!-- END: Profile Menu -->
           <BasicInformationPanel :challenge="challenge" v-if="activeTab == 'podstawowe'"></BasicInformationPanel>
            <TechnicalInformationPanel :challenge="challenge" v-if="activeTab == 'techniczne'"></TechnicalInformationPanel>
            <QuestionsPanel v-if="activeTab == 'pytania'" :id="challenge.id"></QuestionsPanel>
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, provide, onMounted, unref, toRaw, computed} from "vue";
import GetCardChallenge from "../../compositions/GetCardChallenge";
import WhatsNext from "./WhatsNext";
import BasicInformationPanel from "./components/BasicInformationPanel";
import TechnicalInformationPanel from "./components/TechnicalInformationPanel";
import QuestionsPanel from "./components/QuestionsPanel";

export default defineComponent({
    name: 'Card',
    components: {
        QuestionsPanel,
        TechnicalInformationPanel,
        BasicInformationPanel,
        WhatsNext
    },
    props: {
        id: Number
    },
    setup(props, {emit}) {
        const announcementRef = ref();
        const newProjectsRef = ref();
        const challenge = ref({});
        const solutions = ref({});
        const questions = ref({});
        const activeTab = ref('podstawowe');
        const user = ref({});
        const types = require("../../json/types.json");
        const getCardChallengeRepositories = async (id) => {
            await axios.post('/api/challenge/user/get/card', {id: id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log(response.data.payload);
                        challenge.value = response.data.payload;
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }




        onMounted(function () {
            console.log(props);
            getCardChallengeRepositories(props.id);
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })


        provide("bind[announcementRef]", el => {
            announcementRef.value = el;
        });

        provide("bind[newProjectsRef]", el => {
            newProjectsRef.value = el;
        });

        const publish = (id) => {
            axios.post('/api/challenge/publish', {id: id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log(response.data.payload);
                        challenge.value = response.data.payload;
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const unpublish = (id) => {
            axios.post('/api/challenge/unpublish', {id: id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log(response.data.payload);
                        challenge.value = response.data.payload;
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const prevAnnouncement = () => {
            const el = announcementRef.value;
            el.tns.goTo("prev");
        };
        const nextAnnouncement = () => {
            const el = announcementRef.value;
            el.tns.goTo("next");
        };
        const prevNewProjects = () => {
            const el = newProjectsRef.value;
            el.tns.goTo("prev");
        };
        const nextNewProjects = () => {
            const el = newProjectsRef.value;
            el.tns.goTo("next");
        };

        return {
            prevAnnouncement,
            nextAnnouncement,
            prevNewProjects,
            nextNewProjects,
            challenge,
            types,
            activeTab,
            user,
            publish,
            unpublish
        };
    }
});
</script>
