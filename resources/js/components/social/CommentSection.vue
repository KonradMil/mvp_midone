<template>
    <div class="w-full flex text-gray-600 text-xs sm:text-sm">
        <div class="mr-2" v-if="obj != undefined">
            {{ $t('CommentSection.comments') }}: <span class="font-medium">{{ obj.comments_count }}</span>
        </div>
        <div class="ml-auto" v-if="obj != undefined">
            {{$t('CommentSection.likes')}}: <span class="font-medium">{{ obj.likes }}</span>
        </div>
    </div>
    <div v-if="object != undefined">
        <Comment v-if="(current_object_focus == obj.id && current_object_focus_showComments)"
                 v-for="(comment, index) in comments"
                 :key="'comment_' + index"
                 :user="user"
                 :comment="comment"
                 :ind="index"/>
    </div>
    <div v-if="comments != undefined && obj != undefined && comments.length != 0" >
        <a
            @click.prevent="showComments(obj.id)"
            href=""
            class="intro-x w-full block text-center rounded-md py-3 mt-3 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600">

              <span
                  v-if="((current_object_focus == object.id && !current_object_focus_showComments) || !(current_object_focus == obj.id)) && comments.length != 0">{{$t('CommentSection.showComments')}}</span>
            <span v-if="(current_object_focus == object.id && current_object_focus_showComments) && comments.length != 0">{{$t('CommentSection.hideComments')}}</span>
        </a>
    </div>
    <div class="w-full flex items-center mt-3" v-if="guard !==3">
        <div class="w-8 h-8 flex-none image-fit mr-3">
            <Avatar :src="'/s3/avatars/' + user.avatar" :username="user.name + ' ' + user.lastname" :size="35" color="#FFF"
                    background-color="#5e50ac"/>
        </div>
        <div class="flex-1 relative text-gray-700">
            <form role="form" @submit.prevent>
                <input v-if="guard !==3"
                       @keyup.enter="addCommentObject(object.id)"
                       type="text"
                       v-model="message"
                       class="form-control form-control-rounded border-transparent bg-gray-200 pr-10 placeholder-theme-13"
                       :placeholder="$t('global.comment')"
                />
            </form>
            <SmileIcon
                class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"
            />

        </div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import Comment from "../../components/social/Comment";
import Avatar from "../avatar/Avatar";

export default {
    name: "CommentSection",
    props: {
        object: Object,
        user: Object,
        type: String,
        challenge_stage: Number,
        solution_archive: Number,
    },
    components: {
        Avatar,
        Comment
    },
    setup(props, {emit}) {
        const current_object_focus = ref(0);
        const current_object_focus_showComments = ref(false);
        const message = ref('');
        const comments = ref([]);
        const obj = ref([]);
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const user = window.Laravel.user;
        const guard = ref();

        onMounted(function () {
            if(props.object.stage===undefined){
                guard.value = props.object.archive + 2;
            }else{
                guard.value = props.object.stage;
            }


            comments.value = props.object.comments;
            obj.value = props.object;
        });


        //LIKED
        emitter.on('liked', e =>  like(e.id) )

        const like = (id) => {



            if(obj.value.id === id) {
                obj.value.likes = obj.value.likes + 1;
            }
        }

        emitter.on('deletecomment', e => {
            if(Array.isArray(comments.value))
            {
                comments.value.splice(e.index, 1);
                obj.value.comments_count = obj.value.comments_count - 1;
            }
        });
        emitter.on('disliked', e =>  dislike(e.id) )

        const dislike = (id) => {



            if(obj.value.id === id) {
                obj.value.likes = obj.value.likes - 1;
            }
        }

        const addCommentObject = async (id) => {
            current_object_focus.value = id;
            axios.post('/api/user/comment', {id: id, message: message.value, type: props.type})
                .then(response => {
                    if (response.data.success) {
                        comments.value = response.data.payload.comments;
                        obj.value = response.data.payload;
                        showComments(id);
                        current_object_focus_showComments.value = true;
                        message.value = '';
                    } else {
                        // toast.error(response.data.message);
                    }
                })
        }

        const showComments = (id) => {
            current_object_focus.value = id;
            current_object_focus_showComments.value = !current_object_focus_showComments.value;
        }

        return {
            addCommentObject,
            message,
            current_object_focus,
            current_object_focus_showComments,
            showComments,
            comments,
            obj,
            user,
            guard
        }
    }
}
</script>

<style scoped>

</style>
