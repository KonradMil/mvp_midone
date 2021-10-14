<template>
    <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">
        <div class="w-10 h-10 flex-none image-fit">
        </div>
        <div class="ml-3 mr-auto">
            <a href="" class="font-medium">{{ object.name }}</a>
        </div>
        <div class="dropdown ml-3">
            <a href="javascript:;"
                class="dropdown-toggle w-5 h-5 text-gray-600 dark:text-gray-300"
                aria-expanded="false">
                <MoreVerticalIcon class="w-5 h-5"/>
            </a>
            <div class="dropdown-menu w-40">
                <div class="dropdown-menu__content box dark:bg-dark-1 p-2" v-if="own">
                    <a href="" @click.prevent="editObject"
                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <Edit2Icon class="w-4 h-4 mr-2"/>
                        Edytuj obiekt
                    </a>
                    <a href="" @click.prevent="deleteObject"
                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <TrashIcon class="w-4 h-4 mr-2"/>
                        Usuń obiekt
                    </a>
                    <a href="" @click.prevent="publishObject"
                       class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <SendIcon class="w-4 h-4 mr-2"/>
                        Opublikuj
                    </a>
                </div>
                <div class="dropdown-menu__content box dark:bg-dark-1 p-2" v-if="!own">
                    <a href="" @click.prevent="copyObject"
                       class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <DownloadIcon class="w-4 h-4 mr-2"/>
                        Importuj do swoich
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="p-5">
        <div class="h-40 xxl:h-56 image-fit">
            <img
                alt="DBR77"
                class="rounded-md"
                :src="'/' + object.screenshot_path"
            />
        </div>
        <a href="" class="block font-medium text-base mt-5"></a>
        <div class="text-gray-700 dark:text-gray-600 mt-2">
            {{ object.description }}
        </div>
    </div>
    <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5" v-if="!own">
        <div class="intro-x flex mr-2">
        </div>
        <Tippy v-if="!object.liked"
               @click.prevent="like(object)"
               tag="a" href=""
               class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-14 dark:bg-dark-5 dark:text-gray-300 text-theme-10 ml-auto"
               content="Share">
            <ThumbsUpIcon class="w-3 h-3"/>
        </Tippy>
        <Tippy v-if="object.liked"
               @click.prevent=""
               tag="a" href=""
               class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-theme-1 text-white ml-2 ml-auto"
               content="Like">
            <ThumbsUpIcon class="w-3 h-3"/>
        </Tippy>
    </div>
</template>

<script>
import CommentSection from "./social/CommentSection";
import {getCurrentInstance} from "vue";
export default {
    name: "SingleWorkshopObject",
    props: {
       object: Object,
        own: Boolean
    },
    setup(props) {
        const object = props.object;
        const user = window.Laravel.user;
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const like = async (solution) => {
            axios.post('/api/workshop/object/like', {id: object.id})
                .then(response => {
                    if (response.data.success) {
                        object.liked = true;

                    } else {

                    }
                })
        }

        const editObject = () => {
            emitter.emit('loadObjectWorkshop', {action: 'edit', object: object})
        }

        const deleteObject = () => {
            emitter.emit('singleworkshopobject', {action: 'delete', id: object.id})
        }

        const publishObject = () => {

            emitter.emit('singleworkshopobject', {action: 'publish', object: object})
        }
        const copyObject = () => {
            emitter.emit('singleworkshopobject', {action: 'copy', id: object.id})
        }

        return {
            object,
            user,
            like,
            props,
            editObject,
            deleteObject,
            publishObject,
            copyObject
        }
    }
}
</script>

<style scoped>

</style>
