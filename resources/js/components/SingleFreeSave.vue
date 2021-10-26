<template>
    <div>
        <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">
            <div class="ml-3 mr-auto">
                <a href="" class="font-medium">{{ save.name }}</a>
            </div>
        </div>
        <div class="p-5 border-t border-gray-200 dark:border-dark-5" >
            <div class="h-40 xxl:h-56 image-fit">
                <img @click="$router.push({path: 'studio-playground/' + save.id})"
                     alt="DBR77"
                     class="rounded-md"
                     :src="'/' + save.screenshot_path"
                />
            </div>
        </div>
    </div>
</template>

<script>
import CommentSection from "./social/CommentSection";
import {computed, onMounted, ref} from "vue";
import {useToast} from "vue-toastification";
import useEmitter from "../composables/useEmitter";

export default {
    name: "SingleFreeSave",
    components: {CommentSection},
    props: {
        save: Object,
        user: Object,
    },
    setup(props,context) {
        const toast = useToast();
        const user = window.Laravel.user;
        const emitter =  useEmitter();


        onMounted(() => {

        });


        return {
            user,
            props,

        }
    }
}
</script>
