<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{$t('challengesMain.challenges')}}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button class="btn btn-primary shadow-md mr-2" @click="$router.push({name: 'addSolution'})">{{$t('challengesMain.addChallenge')}}</button>
                <div class="dropdown ml-auto sm:ml-0">
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a
                                href=""
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                            >
                                <Share2Icon class="w-4 h-4 mr-2"/>
                                Share Post
                            </a>
                            <a
                                href=""
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                            >
                                <DownloadIcon class="w-4 h-4 mr-2"/>
                                Download Post
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Blog Layout -->
            <div
                v-for="(solution, index) in solutions.list"
                :key="index"
                class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box"
            >
                <div
                    class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4"
                >
                    <div class="w-10 h-10 flex-none image-fit">
                        <img
                            alt="Icewall Tailwind HTML Admin Template"
                            class="rounded-full"
                            :src="'s3/' + solution.screenshot_path"
                        />
                    </div>
                    <div class="ml-3 mr-auto">
                        <a href="" class="font-medium">{{ solution.name }}</a>
                    </div>
                    <div class="dropdown ml-3">
                        <a
                            href="javascript:;"
                            class="dropdown-toggle w-5 h-5 text-gray-600 dark:text-gray-300"
                            aria-expanded="false"
                        >
                            <MoreVerticalIcon class="w-5 h-5"/>
                        </a>
                        <div class="dropdown-menu w-40">
                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                <a
                                    href=""
                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                                >
                                    <Edit2Icon class="w-4 h-4 mr-2"/>
                                    Edit Post
                                </a>
                                <a
                                    href=""
                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                                >
                                    <TrashIcon class="w-4 h-4 mr-2"/>
                                    Delete Post
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="h-40 xxl:h-56 image-fit">
                        <img
                            alt="Icewall Tailwind HTML Admin Template"
                            class="rounded-md"
                            :src="'s3/' + solution.screenshot_path"
                        />
                    </div>
                    <a href="" class="block font-medium text-base mt-5"></a>
                    <div class="text-gray-700 dark:text-gray-600 mt-2">
                        {{ solution.description }}
                    </div>
                </div>
                <div
                    class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5"
                >
                    <Tippy
                        tag="a"
                        href=""
                        class="intro-x w-8 h-8 flex items-center justify-center rounded-full border border-gray-400 dark:border-dark-5 dark:bg-dark-5 dark:text-gray-300 text-gray-600 mr-2"
                        content="Bookmark"
                    >
                        <BookmarkIcon class="w-3 h-3"/>
                    </Tippy>
                    <div class="intro-x flex mr-2">
                    </div>
                    <Tippy v-if="!solution.liked"
                           @click.prevent="like(solution)"
                           tag="a"
                           href=""
                           class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-auto"
                           content="Share"
                    >
                        <ThumbsUpIcon class="w-3 h-3"/>
                    </Tippy>
                    <Tippy v-if="solution.liked"
                           @click.prevent=""
                           tag="a"
                           href=""
                           class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 ml-auto"
                           content="Like"
                    >
                        <ThumbsUpIcon class="w-3 h-3"/>
                    </Tippy>
                </div>
                <div class="px-5 pt-3 pb-5 border-t border-gray-200 dark:border-dark-5">
                    <CommentSection
                        :object="solution"
                        :user="user"
                        type="solution"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, provide, onMounted, getCurrentInstance} from "vue";
import GetSolutions from "../../compositions/GetSolutions";
import CommentSection from "../../components/social/CommentSection";


export default {
    name: "SolutionsMain",
    components: {CommentSection, Comment, GetSolutions},
    setup: function () {
        const solutions = ref([]);
        const user = ref({});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const getSolutionRepositories = async () => {
            solutions.value = GetSolutions();
        }
        const types = require("../../json/types.json");

        onMounted(function () {
            getSolutionRepositories();
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })

        const like = async (solution) => {
            axios.post('api/solution/user/like', {id: solution.id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        // console.log(response.data);
                        // challenge.likes = challenge.likes + 1;
                        solution.liked = true;
                        console.log(solution);
                        emitter.emit('liked', {id: solution.id})
                        // getChallengeRepositories();
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }



        return {
            solutions,
            user,
            types,
            like
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>

<style scoped>

</style>
