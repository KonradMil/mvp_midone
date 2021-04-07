<template>
    <Comment v-if="current_object_focus == object.id && current_object_focus_showComments" v-for="comment in object.comments" :user="user" :comment="comment"/>
    <a
        @click.prevent="showComments(object.id)"
        href=""
        class="intro-x w-full block text-center rounded-md py-3 mt-3 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600"
    >
        <span v-if="(current_object_focus == object.id && !current_object_focus_showComments) || !(current_object_focus == object.id)">Zobacz komentarze</span>
        <span v-if="current_object_focus == object.id && current_object_focus_showComments">Ukryj komentarze</span>
    </a
    >
    <div class="w-full flex items-center mt-3">
        <div class="w-8 h-8 flex-none image-fit mr-3">
            <Avatar :src="'uploads/' + user.avatar" :username="user.name + ' ' + user.lastname" size="40" color="#FFF"
                    background-color="#930f68"/>
        </div>
        <div class="flex-1 relative text-gray-700">
            <form role="form" @submit.prevent>
                <input @keyup.enter="addCommentobject(object.id)"
                       type="text"
                       v-model="message"
                       class="form-control form-control-rounded border-transparent bg-gray-200 pr-10 placeholder-theme-13"
                       placeholder="Skomentuj..."
                />
            </form>
            <SmileIcon
                class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"
            />

        </div>
    </div>
</template>

<script>
import {ref} from "vue";
import Comment from "../../components/social/Comment";
import Avatar from "../avatar/Avatar";
export default {
name: "CommentSection",
    props: {
        object: Object,
        user: Object,
    },
    components: {
        Avatar,
    Comment
    },
    setup() {
        const current_object_focus = ref(0);
        const current_object_focus_showComments = ref(false);
        const message = ref('');

        const addCommentObject = async (id) => {
            current_object_focus.value = id;
            axios.post('api/post/user/comment', {id: id, message: message.value})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        objects.value.list.forEach(function(obj) {
                            console.log(obj);
                            console.log(obj.id);
                            console.log(current_object_focus);
                            if(obj.id == current_object_focus.value) {
                                obj.comments = response.data.payload;
                            }
                        });
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
            showComments
        }
    }
}
</script>

<style scoped>

</style>
