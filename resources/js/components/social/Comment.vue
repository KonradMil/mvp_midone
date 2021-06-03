<template>
    <div class="w-full flex items-center mt-3">
        <div class="w-8 h-8 flex-none image-fit mr-3" v-if="comment.commentator.id != user.id">
            <Avatar :src="'/s3/avatars/' + comment.commentator.avatar" :username="comment.commentator.name + ' ' + comment.commentator.lastname" :size="35" color="#FFF" background-color="#930f68"/>
        </div>
        <div class="flex-1 relative text-gray-700" v-if="comment.commentator.id != user.id">
            <div class="form-control form-control-rounded border-transparent bg-gray-200 pr-10 placeholder-theme-13">
                {{ comment.comment }}
            </div>
        </div>
        <div class="flex-1 relative text-dark-700" v-if="comment.commentator.id == user.id">
            <div class="form-control form-control-rounded border-transparent bg-gray-400 pr-10 placeholder-theme-13">
                {{ comment.comment }}
            </div>
            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal">
            <TrashIcon></TrashIcon></a>
        </div>
        <div class="w-8 h-8 flex-none image-fit ml-3" v-if="comment.commentator.id == user.id">
            <Avatar :src="'/s3/avatars/' + user.avatar" :username="user.name + ' ' + user.lastname" :size="35" color="#FFF" background-color="#930f68"/>
            </div>
    </div>
</template>

<script>
import {defineComponent, computed} from "vue";
import Avatar from "../avatar/Avatar";
export default defineComponent({
    components: {
        Avatar
    },
    props: {
        user: Object,
        comment: Object
    },
    setup() {

    }
});
</script>
