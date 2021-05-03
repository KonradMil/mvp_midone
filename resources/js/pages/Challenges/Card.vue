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
                                :alt="challenge.name" :src="'/s3/' + challenge.screenshot_path"
                            />
                        </div>
                        <div class="ml-4 mr-auto">
                            <div class="font-medium text-base">
                                {{ challenge.name }}
                            </div>
                            <div class="text-gray-600">{{ types[challenge.type] }}</div>
                        </div>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a
                            class="flex items-center text-theme-1 dark:text-theme-10 font-medium"
                            href=""
                        >
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                            Informacje podstawowe
                        </a>
                        <a class="flex items-center mt-5" href="">
                            <BoxIcon class="w-4 h-4 mr-2"/>
                            Szczegóły techniczne
                        </a>
                        <a class="flex items-center mt-5" href="">
                            <LockIcon class="w-4 h-4 mr-2"/>
                            Rozwiązania
                        </a>
                        <a class="flex items-center mt-5" href="">
                            <SettingsIcon class="w-4 h-4 mr-2"/>
                            Oferty
                        </a>
                        <a class="flex items-center mt-5" href="">
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
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                        <button type="button" class="btn btn-primary py-1 px-2">
                            Edytuj
                        </button>
                        <button type="button" class="btn btn-primary py-1 px-2 ml-2" @click="$router.push({path: '/studio/challenge', params: {id: challenge.id, type: 'challenge', load: challenge}})">
                            Studio 3D
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                        >
                            Opublikuj
                        </button>
                    </div>
                </div>
                <WhatsNext></WhatsNext>
            </div>
            <!-- END: Profile Menu -->
            <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: Daily Sales -->
                    <div class="intro-y box col-span-12 xxl:col-span-6">
                        <div
                            class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5"
                        >
                            <h2 class="font-medium text-base mr-auto">Zdjęcia</h2>
                            <div class="dropdown ml-auto sm:hidden">
                                <a
                                    class="dropdown-toggle w-5 h-5 block"
                                    href="javascript:;"
                                    aria-expanded="false"
                                >
                                    <MoreHorizontalIcon
                                        class="w-5 h-5 text-gray-600 dark:text-gray-300"
                                    />
                                </a>
                                <div class="dropdown-menu w-40">
                                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                        <a
                                            href="javascript:;"
                                            class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                                        >
                                            <FileIcon class="w-4 h-4 mr-2"/>
                                            Download Excel
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary hidden sm:flex">
                                <FileIcon class="w-4 h-4 mr-2"/>
                                Download Excel
                            </button>
                        </div>
                        <div class="p-10" v-if="challenge.screenshot_path != undefined">
                            <TinySlider :options="{
                            mode: 'gallery',
                            controls: true,
                            nav: true,
                            speed: 500,
                          }">
                                <div class="h-64 px-2">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img :alt="challenge.name" :src="'/s3/' + challenge.screenshot_path"/>
                                    </div>
                                </div>
                                <div class="h-64 px-2">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img alt="Icewall Tailwind HTML Admin Template" :src="require(`../../../images/${$f()[1].images[1]}`)"/>
                                    </div>
                                </div>
                                <div class="h-64 px-2">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img alt="Icewall Tailwind HTML Admin Template" :src="require(`../../../images/${$f()[2].images[2]}`)"/>
                                    </div>
                                </div>
                            </TinySlider>
                        </div>
                    </div>
                    <!-- END: Daily Sales -->
                    <!-- BEGIN: Announcement -->
                    <div class="intro-y box col-span-12 xxl:col-span-6">
                        <div
                            class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                        >
                            <h2 class="font-medium text-base mr-auto">Announcement</h2>
                            <button
                                class="tiny-slider-navigator btn btn-outline-secondary px-2 mr-2"
                                @click="prevAnnouncement"
                            >
                                <ChevronLeftIcon class="w-4 h-4"/>
                            </button>
                            <button
                                class="tiny-slider-navigator btn btn-outline-secondary px-2"
                                @click="nextAnnouncement"
                            >
                                <ChevronRightIcon class="w-4 h-4"/>
                            </button>
                        </div>
                        <TinySlider ref-key="announcementRef" class="py-5">
                            <div class="px-5">
                                <div class="font-medium text-lg">Rubick Admin Template</div>
                                <div class="text-gray-700 dark:text-gray-600 mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's
                                    standard dummy text ever. <br/><br/>
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry since the 1500s.
                                </div>
                                <div class="flex items-center mt-5">
                                    <div
                                        class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium"
                                    >
                                        02 June 2021
                                    </div>
                                    <button class="btn btn-secondary ml-auto">
                                        View Details
                                    </button>
                                </div>
                            </div>
                            <div class="px-5">
                                <div class="font-medium text-lg">Rubick Admin Template</div>
                                <div class="text-gray-700 dark:text-gray-600 mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's
                                    standard dummy text ever. <br/><br/>
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry since the 1500s.
                                </div>
                                <div class="flex items-center mt-5">
                                    <div
                                        class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium"
                                    >
                                        02 June 2021
                                    </div>
                                    <button class="btn btn-secondary ml-auto">
                                        View Details
                                    </button>
                                </div>
                            </div>
                            <div class="px-5">
                                <div class="font-medium text-lg">Rubick Admin Template</div>
                                <div class="text-gray-700 dark:text-gray-600 mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's
                                    standard dummy text ever. <br/><br/>
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry since the 1500s.
                                </div>
                                <div class="flex items-center mt-5">
                                    <div
                                        class="px-3 py-2 bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 rounded font-medium"
                                    >
                                        02 June 2021
                                    </div>
                                    <button class="btn btn-secondary ml-auto">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </TinySlider>
                    </div>
                    <!-- END: Announcement -->
                    <!-- BEGIN: Projects -->
                    <div class="intro-y box col-span-12 xxl:col-span-6">
                        <div
                            class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                        >
                            <h2 class="font-medium text-base mr-auto">Projects</h2>
                            <button
                                class="tiny-slider-navigator btn btn-outline-secondary px-2 mr-2"
                                @click="prevNewProjects"
                            >
                                <ChevronLeftIcon class="w-4 h-4"/>
                            </button>
                            <button
                                class="tiny-slider-navigator btn btn-outline-secondary px-2"
                                @click="nextNewProjects"
                            >
                                <ChevronRightIcon class="w-4 h-4"/>
                            </button>
                        </div>
                        <TinySlider ref-key="newProjectsRef" class="py-5">
                            <div class="px-5">
                                <div class="font-medium text-lg">Rubick Admin Template</div>
                                <div class="text-gray-700 dark:text-gray-600 mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's
                                    standard dummy text ever since the 1500s.
                                </div>
                                <div class="mt-5">
                                    <div class="flex text-gray-600">
                                        <div class="mr-auto">Pending Tasks</div>
                                        <div>20%</div>
                                    </div>
                                    <div class="progress h-1 mt-2">
                                        <div
                                            class="progress-bar w-1/2 bg-theme-1"
                                            role="progressbar"
                                            aria-valuenow="0"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-5">
                                <div class="font-medium text-lg">Rubick Admin Template</div>
                                <div class="text-gray-700 dark:text-gray-600 mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's
                                    standard dummy text ever since the 1500s.
                                </div>
                                <div class="mt-5">
                                    <div class="flex text-gray-600">
                                        <div class="mr-auto">Pending Tasks</div>
                                        <div>20%</div>
                                    </div>
                                    <div
                                        class="w-full h-1 mt-2 bg-gray-400 dark:bg-dark-1 rounded-full"
                                    >
                                        <div class="w-1/2 h-full bg-theme-1 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-5">
                                <div class="font-medium text-lg">Rubick Admin Template</div>
                                <div class="text-gray-700 dark:text-gray-600 mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Lorem Ipsum has been the industry's
                                    standard dummy text ever since the 1500s.
                                </div>
                                <div class="mt-5">
                                    <div class="flex text-gray-600">
                                        <div class="mr-auto">Pending Tasks</div>
                                        <div>20%</div>
                                    </div>
                                    <div
                                        class="w-full h-1 mt-2 bg-gray-400 dark:bg-dark-1 rounded-full"
                                    >
                                        <div class="w-1/2 h-full bg-theme-1 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </TinySlider>
                    </div>
                    <!-- END: Projects -->
                    <!-- BEGIN: Latest Tasks -->
                    <div class="intro-y box col-span-12 xxl:col-span-6">
                        <div
                            class="flex items-center px-5 py-5 sm:py-0 border-b border-gray-200 dark:border-dark-5"
                        >
                            <h2 class="font-medium text-base mr-auto">Latest Tasks</h2>
                            <div class="dropdown ml-auto sm:hidden">
                                <a
                                    class="dropdown-toggle w-5 h-5 block"
                                    href="javascript:;"
                                    aria-expanded="false"
                                >
                                    <MoreHorizontalIcon
                                        class="w-5 h-5 text-gray-600 dark:text-gray-300"
                                    />
                                </a>
                                <div class="nav nav-tabs dropdown-menu w-40" role="tablist">
                                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                        <a
                                            id="latest-tasks-new-tab"
                                            href="javascript:;"
                                            data-toggle="tab"
                                            data-target="#latest-tasks-new"
                                            class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                                            role="tab"
                                            aria-controls="latest-tasks-new"
                                            aria-selected="true"
                                        >New</a
                                        >
                                        <a
                                            id="latest-tasks-last-week-tab"
                                            href="javascript:;"
                                            data-toggle="tab"
                                            data-target="#latest-tasks-last-week"
                                            class="block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                                            role="tab"
                                            aria-selected="false"
                                        >Last Week</a
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="nav nav-tabs ml-auto hidden sm:flex" role="tablist">
                                <a
                                    id="latest-tasks-mobile-new-tab"
                                    data-toggle="tab"
                                    data-target="#latest-tasks-new"
                                    href="javascript:;"
                                    class="py-5 ml-6 active"
                                    role="tab"
                                    aria-selected="true"
                                >New</a
                                >
                                <a
                                    id="latest-tasks-mobile-last-week-tab"
                                    data-toggle="tab"
                                    data-target="#latest-tasks-last-week"
                                    href="javascript:;"
                                    class="py-5 ml-6"
                                    role="tab"
                                    aria-selected="false"
                                >Last Week</a
                                >
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="tab-content">
                                <div
                                    id="latest-tasks-new"
                                    class="tab-pane active"
                                    role="tabpanel"
                                    aria-labelledby="latest-tasks-new-tab"
                                >
                                    <div class="flex items-center">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <a href="" class="font-medium">Create New Campaign</a>
                                            <div class="text-gray-600">10:00 AM</div>
                                        </div>
                                        <input
                                            class="form-check-switch ml-auto"
                                            type="checkbox"
                                            checked
                                        />
                                    </div>
                                    <div class="flex items-center mt-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <a href="" class="font-medium">Meeting With Client</a>
                                            <div class="text-gray-600">02:00 PM</div>
                                        </div>
                                        <input class="form-check-switch ml-auto" type="checkbox"/>
                                    </div>
                                    <div class="flex items-center mt-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <a href="" class="font-medium">Create New Repository</a>
                                            <div class="text-gray-600">04:00 PM</div>
                                        </div>
                                        <input class="form-check-switch ml-auto" type="checkbox"/>
                                    </div>
                                    <div class="flex items-center mt-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <a href="" class="font-medium">Meeting With Client</a>
                                            <div class="text-gray-600">10:00 AM</div>
                                        </div>
                                        <input
                                            class="form-check-switch ml-auto"
                                            type="checkbox"
                                            checked
                                        />
                                    </div>
                                    <div class="flex items-center mt-5">
                                        <div class="border-l-2 border-theme-1 pl-4">
                                            <a href="" class="font-medium">Create New Repository</a>
                                            <div class="text-gray-600">11:00 PM</div>
                                        </div>
                                        <input class="form-check-switch ml-auto" type="checkbox"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Latest Tasks -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, provide, onMounted, unref, toRaw} from "vue";
import GetCardChallenge from "../../compositions/GetCardChallenge";
import WhatsNext from "./WhatsNext";

export default defineComponent({
    name: 'Card',
    components: {
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
            types
        };
    }
});
</script>
