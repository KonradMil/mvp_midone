<template>
    <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">
        <div class="w-10 h-10 flex-none image-fit">
            <img
                alt="Icewall Tailwind HTML Admin Template"
                class="rounded-full"
                :src="'/' + solution.screenshot_path"
            />
        </div>
        <div class="ml-3 mr-auto" @click="$router.push({name: 'solutionStudio', params: {id: solution.id, type: 'solution', load: solution }});">
            <a href="" class="font-medium">{{ solution.name }}</a>
        </div>
        <div class="dropdown ml-3">
            <a href="javascript:;"
                class="dropdown-toggle w-5 h-5 text-gray-600 dark:text-gray-300"
                aria-expanded="false">
                <MoreVerticalIcon class="w-5 h-5"/>
            </a>
            <div class="dropdown-menu w-40">
                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                    <a href=""
                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <Edit2Icon class="w-4 h-4 mr-2"/>
                        {{$t('challengesMain.editPost')}}
                    </a>
                    <a href=""
                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <TrashIcon class="w-4 h-4 mr-2"/>
                        {{$t('challengesMain.deletePost')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="p-5" @click="$router.push({name: 'solutionStudio', params: {id: solution.id, type: 'solution', load: solution }});">
        <div class="h-40 xxl:h-56 image-fit">
            <img
                alt="Icewall Tailwind HTML Admin Template"
                class="rounded-md"
                :src="'/' + solution.screenshot_path"
            />
        </div>
        <a href="" class="block font-medium text-base mt-5"></a>
        <div class="text-gray-700 dark:text-gray-600 mt-2" style="word-break: break-all; max-height: 100px; overflow-y: scroll;">
            {{ solution.description }}
        </div>
        <div class="mt-2" v-if="canAccept">
            <button class="btn btn-primary shadow-md mr-2" @click="acceptSolution">Akceptuj rozwiązanie</button>
        </div>
    </div>
    <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5">
        <Tippy
            tag="a"
            href=""
            class="intro-x w-8 h-8 flex items-center justify-center rounded-full border border-gray-400 dark:border-dark-5 dark:bg-dark-5 dark:text-gray-300 text-gray-600 mr-2"
            content="Bookmark">
            <BookmarkIcon class="w-3 h-3"/>
        </Tippy>
        <div class="intro-x flex mr-2">
        </div>
        <Tippy v-if="!solution.liked"
               @click.prevent="like(solution)"
               tag="a" href=""
               class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-auto"
               content="Share">
            <ThumbsUpIcon class="w-3 h-3"/>
        </Tippy>
        <Tippy v-if="solution.liked"
               @click.prevent=""
               tag="a" href=""
               class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 ml-auto"
               content="Like">
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
</template>

<script>
import CommentSection from "./social/CommentSection";
import {getCurrentInstance} from "vue";
export default {
    name: "SingleSolutionPost",
    components: {CommentSection},
    props: {
        user: Object,
        solution: Object,
        canAccept: Boolean
    },
    setup(props) {
        const solution = props.solution;
        const user = props.user;
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const like = async (solution) => {
            axios.post('/api/solution/user/like', {id: solution.id})
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

        const acceptSolution = () => {
            axios.post('/api/solution/accept', {id: solution.id})
                .then(response => {
                    if (response.data.success) {
                        // solution.liked = true;
                        // console.log(solution);
                        // emitter.emit('liked', {id: solution.id})
                        // getChallengeRepositories();
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        return {
            solution,
            user,
            like,
            props,
            acceptSolution
        }
    }
}
</script>

<style scoped>

</style>
