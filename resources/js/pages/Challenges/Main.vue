<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{$t('challengesMain.challenges')}}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button class="btn btn-primary shadow-md mr-2" v-if="user.type == 'investor'" @click="$router.push({name: 'addChallenge'})">{{$t('challengesMain.addChallenge')}}</button>
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
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Blog Layout -->
            <div
                v-for="(challenge, index) in challenges.list"
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
                            :src="'/' + challenge.screenshot_path"
                        />
                    </div>
                    <div class="ml-3 mr-auto" @click="$router.push( {path : '/challenges/card/' + challenge.id})">
                        <a href="" class="font-medium">{{ challenge.name }}</a>
                        <div class="flex text-gray-600 truncate text-xs mt-0.5">
                            <a class="text-theme-1 dark:text-theme-10 inline-block truncate" href="">
                                {{ types[challenge.type] }}
                            </a>
                            <a class="text-theme-1 dark:text-theme-10 inline-block truncate" href="">
                                {{ sels.challenge_statuses[challenge.stage] }}
                            </a>
                            <span class="mx-1" v-if="challenge.stage == 1"><br/>• Rozwiązania do: {{ challenge.solution_deadline }}</span>
                            <span class="mx-1" v-if="challenge.stage == 2"><br/>• Oferty do: {{ challenge.offer_deadline }}</span>
                        </div>
                    </div>
                    <div class="dropdown ml-3">
                        <a
                            href="javascript:;"
                            class="dropdown-toggle w-5 h-5 text-gray-600 dark:text-gray-300"
                            aria-expanded="false">
                            <MoreVerticalIcon class="w-5 h-5"/>
                        </a>
                        <div class="dropdown-menu w-40">
                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                <a href=""
                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <Edit2Icon class="w-4 h-4 mr-2"/>
                                    {{ $t('challengesMain.editPost') }}
                                </a>
                                <a href=""
                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <TrashIcon class="w-4 h-4 mr-2"/>
                                    {{ $t('challengesMain.deletePost') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="h-40 xxl:h-56 image-fit" @click="$router.push( {path : '/challenges/card/' + challenge.id})">
                        <img
                            alt="Icewall Tailwind HTML Admin Template"
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
            <!-- BEGIN: Pagination -->
<!--            <div-->
<!--                class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"-->
<!--            >-->
<!--                <ul class="pagination">-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronsLeftIcon class="w-4 h-4"/>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronLeftIcon class="w-4 h-4"/>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">...</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">1</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link pagination__link&#45;&#45;active" href="">2</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">3</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">...</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronRightIcon class="w-4 h-4"/>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronsRightIcon class="w-4 h-4"/>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <select class="w-20 form-select box mt-3 sm:mt-0">-->
<!--                    <option>10</option>-->
<!--                    <option>25</option>-->
<!--                    <option>35</option>-->
<!--                    <option>50</option>-->
<!--                </select>-->
<!--            </div>-->
            <!-- END: Pagination -->
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, provide, onMounted, getCurrentInstance, watch, onUpdated} from "vue";
import GetChallenges from "../../compositions/GetChallenges";
import GetChallengesFollowed from "../../compositions/GetChallengesFollowed";
import CommentSection from "../../components/social/CommentSection";

export default {
    name: "ChallengesMain",
    components: {CommentSection, Comment, GetChallenges},
    props: {
      type: String
    },
    setup(props) {
        const challenges = ref([]);
        const user = ref({});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const getChallengeRepositories = async () => {
            if(props.type == 'followed') {
                challenges.value = GetChallengesFollowed();
            } else {
                challenges.value = GetChallenges();
            }

        }
        const types = require("../../json/types.json");
        const sels = require("../../json/challenge.json");

        onMounted(function () {
            getChallengeRepositories();
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        const follow = (id, index) => {
            axios.post('/api/challenge/user/follow', {id: id})
                .then(response => {
                    // console.log(response.data)
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
                    // console.log(response.data)
                    if (response.data.success) {
                        console.log(challenges.value);
                        console.log(challenges.value.list[index]);
                        challenges.value.list[index].followed  = false;
                        toast.success('Nie śledzisz już tego wyzwania.');
                    } else {

                    }
                })
        }

        const like = async (challenge) => {
            axios.post('api/challenge/user/like', {id: challenge.id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        // console.log(response.data);
                        // challenge.likes = challenge.likes + 1;
                        challenge.liked = true;
                        console.log(challenge);
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
                    // console.log(response.data)
                    if (response.data.success) {
                        // console.log(response.data);
                        // challenge.likes = challenge.likes + 1;
                        challenge.liked = true;
                        console.log(challenge);
                        emitter.emit('disliked', {id: challenge.id})
                        // getChallengeRepositories();
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        return {
            challenges,
            user,
            types,
            sels,
            like,
            dislike,
            getChallengeRepositories,
            follow,
            unfollow
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

<style scoped>

</style>
