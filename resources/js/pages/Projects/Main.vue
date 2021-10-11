<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Projekty</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <div class="dropdown ml-auto sm:ml-0">
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a
                                href=""
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                            >
                                <Share2Icon class="w-4 h-4 mr-2"/>
                                {{ $t('global.sharePost') }}
                            </a>
                            <a
                                href=""
                                class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                            >
                                <DownloadIcon class="w-4 h-4 mr-2"/>
                                {{ $t('global.downloadPost') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="guard === true" class="intro-y grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Blog Layout -->
            <div class="intro-y col-span-12 box pl-2 py-5 text-theme-1 dark:text-theme-10 font-medium" v-if="projects.length == 0">
                <div>
                    <p v-if="user.type == 'integrator'">
                        Nie masz jeszcze żadnych projektów.
                    </p>
                </div>
                    <div v-if="user.type === 'investor'">
                        <p>
                            Nie masz jeszcze żadnych projektów.
                        </p>
                    </div>
                </div>
            <div v-for="(challenge, index) in projects" :key="index" class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">
                    <div class="w-10 h-10 flex-none image-fit">
                        <img alt="DBR77" class="rounded-full" :src="'/' + challenge.screenshot_path"/>
                    </div>
                    <div class="ml-3 mr-auto" @click.prevent="$router.push( {path : '/projects/card/' + challenge.id})">
                        <a href="" class="font-medium">{{ challenge.name }}</a>
                        <div class="flex text-gray-600 truncate text-xs mt-0.5" style="flex-direction: column;">
                            <a class="text-theme-1 dark:text-theme-10 inline-block truncate" href="">
                                {{ types[challenge.type] }} -  {{ sels.challenge_statuses[challenge.stage]['name'] }}
                            </a>
                            <div class="w-full" v-if="challenge.stage == 1">Rozwiązania do: {{ $dayjs(challenge.solution_deadline).format('DD.MM.YYYY')  }}</div>
                            <div class="w-full" v-if="challenge.stage == 2">Oferty do: {{ $dayjs(challenge.offer_deadline).format('DD.MM.YYYY')  }}</div>
                        </div>
                    </div>
                    <div class="dropdown ml-3"  v-if="challenge.author_id == user.id && challenge.status != 1">
                        <a
                            href="javascript:;"
                            class="dropdown-toggle w-5 h-5 text-gray-600 dark:text-gray-300"
                            aria-expanded="false">
                            <MoreVerticalIcon class="w-5 h-5"/>
                        </a>
                        <div class="dropdown-menu w-40">
                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                <a href="" @click.prevent="$router.push({name: 'addChallenge', params: {challenge_id: challenge.id }});"
                                   class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <Edit2Icon class="w-4 h-4 mr-2"/>
                                    Edytuj
                                </a>
                                <a href="" @click.prevent="deleteChallenge(challenge.id)"
                                   class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <TrashIcon class="w-4 h-4 mr-2"/>
                                    Usuń
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="h-40 xxl:h-56 image-fit" @click="$router.push( {path : '/projects/card/' + challenge.id})">
                        <img
                            alt="DBR77"
                            class="rounded-md"
                            :src="'/' + challenge.screenshot_path"
                        />
                    </div>
                    <a href="" class="block font-medium text-base mt-5"></a>
                </div>
                <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5">
                    <Tippy v-if="!challenge.followed" tag="a" href="" @click.prevent="follow(challenge.id, index)"
                           class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10"
                           content="Follow">
                        <BookmarkIcon class="w-3 h-3"/>
                    </Tippy>
                    <Tippy v-if="challenge.followed" tag="a" href="" @click.prevent="unfollow(challenge.id, index)"
                           class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white"
                           content="Unfollow">
                        <BookmarkIcon class="w-3 h-3"/>
                    </Tippy>
                    <div class="intro-x flex mr-2">
                    </div>
                    <Tippy v-if="!challenge.liked" @click.prevent="like(challenge)" tag="a" href=""
                           class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-auto"
                           content="Like">
                        <ThumbsUpIcon class="w-3 h-3"/>
                    </Tippy>
                    <Tippy v-if="challenge.liked"
                           @click.prevent="dislike(challenge)" tag="a" href=""
                           class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 ml-auto"
                           content="Unlike">
                        <ThumbsUpIcon class="w-3 h-3"/>
                    </Tippy>
                </div>
                <div class="px-5 pt-3 pb-5 border-t border-gray-200 dark:border-dark-5">
                    <CommentSection
                        :object="challenge"
                        :user="user"
                        type="challenge"
                    />
                </div>
            </div>
            <!-- END: Blog Layout -->
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, provide, onMounted, getCurrentInstance, watch, onUpdated} from "vue";
import CommentSection from "../../components/social/CommentSection";
import {useToast} from "vue-toastification";

export default {
    name: "ProjectsMain",
    components: {CommentSection, Comment},
    props: {
        type: String
    },
    setup(props) {
        const challenges = ref([]);
        const user = ref({});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        const projects = ref([]);
        const goodProjects = ref([]);
        const guard = ref(false);
        const types = require("../../json/types.json");
        const sels = require("../../json/challenge.json");

        onMounted(function () {
            getProjects(function(){
                  guard.value = true;
            });
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        const getProjects = async(callback) => {
            axios.post('/api/challenge/user/get/projects', {})
                .then(response => {

                    if (response.data.success) {
                        projects.value = response.data.payload;
                        callback(response);
                    } else {

                    }
                })
        }

        const deleteChallenge = async(id) => {
            axios.post('/api/challenge/delete', {id: id})
                .then(response => {

                    if (response.data.success) {
                        toast.success('Wyzwanie usunięte');
                        window.location.reload();
                    } else {

                    }
                })
        }

        const follow = (id, index) => {
            axios.post('/api/challenge/user/follow', {id: id})
                .then(response => {

                    if (response.data.success) {
                        challenges.value.list[index].followed = true;
                        toast.success('Teraz śledzisz to wyzwanie.');
                    } else {

                    }
                })
        }

        const unfollow = (id, index) => {
            axios.post('/api/challenge/user/unfollow', {id: id})
                .then(response => {

                    if (response.data.success) {


                        challenges.value.list[index].followed  = false;
                        toast.success('Nie śledzisz już tego wyzwania.');
                    } else {

                    }
                })
        }

        const like = async (challenge) => {
            axios.post('api/challenge/user/like', {id: challenge.id})
                .then(response => {

                    if (response.data.success) {

                        // challenge.likes = challenge.likes + 1;
                        challenge.liked = true;

                        emitter.emit('liked', {id: challenge.id})
                        // getChallengeRepositories();
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const dislike = async (challenge) => {
            axios.post('api/challenge/user/dislike', {id: challenge.id})
                .then(response => {

                    if (response.data.success) {

                        // challenge.likes = challenge.likes + 1;
                        challenge.liked = false;

                        emitter.emit('disliked', {id: challenge.id})
                        // getChallengeRepositories();
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        return {
            guard,
            getProjects,
            projects,
            goodProjects,
            challenges,
            user,
            types,
            sels,
            like,
            dislike,
            follow,
            unfollow,
            deleteChallenge
        }
    },
            beforeRouteEnter(to, from, next) {
            if (!window.Laravel.isLoggedin) {
                window.location.href = "/";
            }
            next((vm) => {

            });
        }
}
</script>

<style scoped>

</style>
