<template>
    <div
        v-for="(post, index) in posts.list"
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
                    :src="'s3/' + post.thumbnail"
                />
            </div>
            <div class="ml-3 mr-auto">
                <a href="" class="font-medium">{{ post.name }}</a>
                <div class="flex text-gray-600 truncate text-xs mt-0.5">
                    <a class="text-theme-1 dark:text-theme-10 inline-block truncate" href="">
                        {{ post.category }}
                    </a>
                </div>
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
                    :src="'s3/' + post.thumbnail"
                />
            </div>
            <a href="" class="block font-medium text-base mt-5"></a>
            <div class="text-gray-700 dark:text-gray-600 mt-2">
                {{ post.description }}
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
            <Tippy v-if="!post.liked"
                   @click.prevent="like(post)"
                   tag="a"
                   href=""
                   class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-auto"
                   content="Share"
            >
                <ThumbsUpIcon class="w-3 h-3"/>
            </Tippy>
            <Tippy v-if="post.liked"
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
            <div class="w-full flex text-gray-600 text-xs sm:text-sm">
                <div class="mr-2">
                    {{ $t('challengeMain.comments') }}: <span class="font-medium">{{ post.comments_count }}</span>
                </div>
                <div class="ml-auto">
                    Polubień: <span class="font-medium">{{ post.likes }}</span>
                </div>
            </div>
            <CommentSection
                :object="post"
                :user="user"
            />
        </div>
    </div>
</template>

<script>

import CommentSectionKnowledge from "../../components/social/CommentSectionKnowledge";

export default {
    name: "Post",
    components: {CommentSectionKnowledge},
    props: {
        user: Object,
        post: Object
    },
    setup() {

    }
}
</script>

<style scoped>

</style>
