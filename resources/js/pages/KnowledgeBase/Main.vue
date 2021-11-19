<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{ $t('global.knowledgeBase') }}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button class="btn btn-primary shadow-md mr-2" v-if="user.type == 'admin'" @click="$router.push({name: 'addKnowledgebasePost'})">
                    {{ $t('global.addPost') }}
                </button>
                <div class="dropdown ml-auto sm:ml-0">
                    <div class="dropdown-menu w-40">
                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <Share2Icon class="w-4 h-4 mr-2"/>
                                {{ $t('global.sharePost') }}
                            </a>
                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                <DownloadIcon class="w-4 h-4 mr-2"/>
                                {{ $t('global.downloadPost') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <Post v-for="(post, index) in posts" :user="user" :post="post" :key="'post_' + index" @click="playVideo(post.youtube_link)"></Post>
        </div>
    </div>
    <transition name="modal">
        <TerraSimpleModal v-if="showVideo" @close="showVideo = false" :clasess="'video-modal'">
            <template v-slot:body>
                <LiteYouTubeEmbed
                    :id="video"
                    style="width:100%; max-width: 30vw;  margin: 0 auto;"
                />
<!--                <lite-youtube :videoid="video" ></lite-youtube>-->
            </template>
        </TerraSimpleModal>
    </transition>
</template>

<script>
import Post from "./Post";
import TerraSimpleModal from "../../components-terraform/TerraSimpleModal"
import {computed, onMounted, ref} from 'vue';
import DirectusCall from "../../compositions/DirectusCall"
import LiteYouTubeEmbed from 'vue-lite-youtube-embed'
import 'vue-lite-youtube-embed/dist/style.css'

export default {
    name: "MainKnowledgebase",
    components: {Post, TerraSimpleModal,LiteYouTubeEmbed},
    setup() {
        const posts = ref([]);
        const user = ref({});
        const showVideo = ref(false);
        const video = ref('');

        const getPosts = () => {
            DirectusCall('items/tutorials?access_token=aaaa&fields=*.*.*&sort[]=sort&filter[status]=published', (val) => {
                console.log('val', val);
                posts.value = val;
            });
        }

        const playVideo = (id) => {
            showVideo.value = true;
            video.value = id;
        }

        onMounted(function () {
            getPosts();
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        return {
            user,
            posts,
            playVideo,
            showVideo,
            video
        }
    }
}
</script>

<style scoped>

</style>
