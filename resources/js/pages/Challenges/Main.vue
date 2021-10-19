<template>
    <div>
        <div class="mt-2" v-if="type == 'normal'">
            <TopMenuMain @tabChanged="getNewData" :user="user" :type="type"></TopMenuMain>
        </div>
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Blog Layout -->
            <div class="intro-y col-span-12 box pl-2 py-5 text-theme-1 dark:text-theme-10 font-medium" v-if="challenges.list == undefined || challenges.list.length == 0">
                <div>
                    <p v-if="user.type == 'integrator' && type==='normal'">
                        W tej chwili nie ma żadnych wyzwań, poinformujemy Cię jak tylko jakieś będą dostępne.
                    </p>
                    <p v-if="user.type == 'integrator' && type==='followed'">
                        Nie obserwujesz jeszcze żadnych wyzwań.
                    </p>
                    <p v-if="user.type == 'integrator' && type==='archive'">
                        Nie masz jeszcze żadnych archiwalnych wyzwań.
                    </p>
                    <div v-if="user.type === 'investor'">
                        <p v-if="type === 'normal'">
                            Nie dodałeś jeszcze żadnych wyzwań.
                        </p>
                        <p v-if="type==='followed'">
                            Nie obserwujesz jeszcze żadnych wyzwań.
                        </p>
                        <p v-if="type==='archive'">
                            Nie masz jeszcze żadnych archiwalnych wyzwań.
                        </p>
                        <button v-if="type==='normal'" class="btn btn-primary shadow-md mr-2 mt-2" @click="$router.push({name: 'addChallenge'})">{{ $t('challengesMain.addChallenge') }}</button>
                    </div>
                </div>
            </div>
            <div v-for="(challenge, index) in challenges.list" :key="index" class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">
<!--                    <div class="w-10 h-10 flex-none image-fit">-->
<!--                        <img alt="DBR77" class="rounded-full" :src="'/' + challenge.screenshot_path"/>-->
<!--                    </div>-->
                    <div class="mr-auto" @click.prevent="$router.push( {path : '/challenges/card/' + challenge.id})">
                        <a href="" class="font-medium">{{ challenge.name }}</a>
                        <div class="flex text-gray-600 truncate text-xs mt-0.5" style="flex-direction: column;">
                            <a class="text-theme-1 dark:text-theme-10 inline-block truncate" href="">
                                {{ types[challenge.type] }} - {{ sels.challenge_statuses[challenge.stage]['name'] }}
                            </a>
                            <div class="w-full" v-if="challenge.stage == 1">Rozwiązania do: {{ $dayjs.unix(challenge.solution_deadline).format('DD.MM.YYYY') }}</div>
                            <div class="w-full" v-if="challenge.stage == 2">Oferty do: {{ $dayjs.unix(challenge.offer_deadline).format('DD.MM.YYYY') }}</div>
                        </div>
                    </div>
                    <div class="dropdown ml-3" v-if="challenge.author_id == user.id && challenge.status != 1">
                        <a href="javascript:"
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
<!--                                <a href="" @click.prevent="deleteChallenge(challenge.id)"-->
<!--                                   class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">-->
<!--                                    <TrashIcon class="w-4 h-4 mr-2"/>-->
<!--                                    Usuń-->
<!--                                </a>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="h-40 xxl:h-56 image-fit" @click="$router.push( {path : '/challenges/card/' + challenge.id})">
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
                        :challenge_stage="challenge.stage"
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
import GetChallenges from "../../compositions/GetChallenges";
import GetChallengesFollowed from "../../compositions/GetChallengesFollowed";
import GetChallengesArchive from "../../compositions/GetChallengesArchive";
import CommentSection from "../../components/social/CommentSection";
import {useToast} from "vue-toastification";
import RequestHandler from "../../compositions/RequestHandler"
import TopMenuMain from "../../components/TopMenuMain"
import router from "../../router";

export default {
    name: "ChallengesMain",
    components: {TopMenuMain, CommentSection, Comment, GetChallenges},
    props: {
        type: String
    },
    setup(props) {
        const challenges = ref([]);
        const user = ref({});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        const guard = ref(false);

        const getNewData = (val) => {
            axios.post('api/challenges/get/tab/' + val)
                .then(response => {
                    if (response.data.success) {
                        challenges.value.list = response.data.payload;
                    } else {

                    }
                })
        }

        const getChallengeRepositories = async (callback) => {
            if (props.type === 'followed') {
                challenges.value = GetChallengesFollowed();
                callback();
            } else if (props.type === 'archive') {
                challenges.value = GetChallengesArchive();
                callback();
            } else {
                getNewData(0);
                // challenges.value = GetChallenges();
            }
        }

        const types = require("../../json/types.json");
        const sels = require("../../json/challenge.json");

        onMounted(function () {
            // getNewData(0);
            getChallengeRepositories(function () {
                guard.value = true;
            });
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
                if(user.type == 'robochallenge') {
                    router.push({path: '/robochallenge'})
                }
            }
        });

        const deleteChallenge = async (id) => {
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
            RequestHandler('challenge/user/unfollow', 'post', {id: id}, (val) => {
                challenges.value.list[index].followed = false;
                toast.success('Nie śledzisz już tego wyzwania.');
            });
        }

        const like = async (challenge) => {
            axios.post('api/challenge/user/like', {id: challenge.id})
                .then(response => {
                    if (response.data.success) {
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
                        challenge.liked = false;

                        emitter.emit('disliked', {id: challenge.id})
                    } else {

                    }
                })
        }

        return {
            guard,
            challenges,
            user,
            types,
            sels,
            like,
            dislike,
            getChallengeRepositories,
            follow,
            unfollow,
            deleteChallenge,
            getNewData
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next((vm) => {
            vm.getChallengeRepositories();
        });
    }
}
</script>
