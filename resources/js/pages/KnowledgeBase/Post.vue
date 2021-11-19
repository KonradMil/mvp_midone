<template>
    <div class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
        <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">
            <div class="ml-3 mr-auto">
                <a href="" class="font-medium">{{ post.name }}</a>
                <div class="flex text-gray-600 truncate text-xs mt-0.5">
                    <a class="text-theme-1 dark:text-theme-10 inline-block truncate" href="" v-if="categories[post.category] != undefined">
                        {{ categories[post.category].name }}
                    </a>
                </div>
            </div>
            <div class="dropdown ml-3">
                <a
                    href="javascript:;"
                    class="dropdown-toggle w-5 h-5 text-gray-600 dark:text-gray-300"
                    aria-expanded="false">
                    <MoreVerticalIcon class="w-5 h-5"/>
                </a>
            </div>
        </div>
        <div class="p-5">
            <div class="item-image">
                <img v-lazy="'http://img.youtube.com/vi/' + post.youtube_link + '/maxresdefault.jpg'"/>
            </div>
            <a href="" class="block font-medium text-base mt-5"></a>
            <div class="text-gray-700 dark:text-gray-600 mt-2">
                {{ post.description }}
            </div>
        </div>
<!--        <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5">-->
<!--            <Tippy tag="a" href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full border border-gray-400 dark:border-dark-5 dark:bg-dark-5 dark:text-gray-300 text-gray-600 mr-2" content="Bookmark">-->
<!--                <BookmarkIcon class="w-3 h-3"/>-->
<!--            </Tippy>-->
<!--            <div class="intro-x flex mr-2">-->
<!--            </div>-->
<!--            <Tippy v-if="!post.liked" @click.prevent="like(post)" tag="a" href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-auto" content="Share">-->
<!--                <ThumbsUpIcon class="w-3 h-3"/>-->
<!--            </Tippy>-->
<!--            <Tippy v-if="post.liked" @click.prevent="" tag="a" href="" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 ml-auto" content="Like">-->
<!--                <ThumbsUpIcon class="w-3 h-3"/>-->
<!--            </Tippy>-->
<!--        </div>-->
<!--        <div class="px-5 pt-3 pb-5 border-t border-gray-200 dark:border-dark-5">-->

<!--            <CommentSection-->
<!--                :object="post"-->
<!--                :user="user"-->
<!--                type="knowledge"-->
<!--            />-->
<!--        </div>-->
    </div>
</template>

<script>

import CommentSection from "../../components/social/CommentSection";
import {getCurrentInstance, ref, onMounted} from "vue";

export default {
    name: "Post",
    components: {CommentSection},
    props: {
        user: Object,
        post: Object
    },
    setup(props, {emit}) {
        //GLOBAL
        const postObj = ref({})
        const categories = ref({})
        const play = ref([]);


        onMounted(function () {
            postObj.value = props.post;
            const c = require("../../json/knowledgebase_categories.json");
            categories.value = c.categories;
        });

        const playVideo = (id) => {
            if(play.value[id] != undefined) {
                play.value[id] = !play.value[id];
            } else {
                play.value[id] = true;
            }
        }

        return {
            play,
            playVideo,
            postObj,
            categories
        }
    }
}
</script>

<style scoped>

</style>
