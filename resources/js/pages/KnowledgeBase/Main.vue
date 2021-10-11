<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{$t('global.knowledgeBase')}}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button class="btn btn-primary shadow-md mr-2" v-if="user.type == 'admin'" @click="$router.push({name: 'addKnowledgebasePost'})">
                    {{ $t('global.addPost') }}</button>
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
            <Post v-for="(post, index) in postsList" :user="user" :post="post" :key="'post_' + index"></Post>
            <!-- END: Blog Layout -->

        </div>
    </div>

</template>

<script>
import Post from "./Post";
import GetKnowledgebasePosts from "../../compositions/GetKnowledgebasePosts";
import {computed, onMounted, ref} from 'vue';

export default {
    name: "MainKnowledgebase",
    components: {Post},
    setup() {
        const posts = ref([]);
        const user = ref({});
        const getPostsRepositories = async () => {
            posts.value = GetKnowledgebasePosts();

        }

        const postsList = computed(() => {

           if(posts.value.list != undefined) {
               return posts.value.list;
           } else {
               return posts.value;
           }
        });

        onMounted(function () {
            getPostsRepositories();
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        return {
            user,
            posts,
            postsList
        }
    }
}
</script>

<style scoped>

</style>
