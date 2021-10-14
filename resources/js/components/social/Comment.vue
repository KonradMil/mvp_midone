<template>
    <div class="w-full flex items-center mt-3">
        <div class="w-8 h-8 flex-none image-fit mr-3" v-if="comment.commentator.id != user.id">
            <Avatar :src="'/s3/avatars/' + comment.commentator.avatar" :username="comment.commentator.name + ' ' + comment.commentator.lastname" :size="35" color="#FFF" background-color="#5e50ac"/>
        </div>
        <div class="flex-1 relative text-gray-700" v-if="comment.commentator.id != user.id">
            <div class="form-control form-control-rounded border-transparent bg-gray-200 pr-10 placeholder-theme-13">
                {{ comment.comment }}
            </div>
        </div>
        <div class="flex-1 relative text-dark-700" v-if="comment.commentator.id == user.id">
            <div class="form-control form-control-rounded border-transparent bg-gray-400 pr-10 placeholder-theme-13">
                {{ comment.comment }}
                   <a :disabled="isDisabled" @click.prevent="del(comment.id)" href="javascript:;"><TrashIcon class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-red-500"></TrashIcon></a>
            </div>

        </div>
        <div class="w-8 h-8 flex-none image-fit ml-3" v-if="comment.commentator.id == user.id">
            <Avatar :src="'/s3/avatars/' + user.avatar" :username="user.name + ' ' + user.lastname" :size="35" color="#FFF" background-color="#5e50ac"/>
            </div>
    </div>
</template>

<script>
import {defineComponent, computed, ref, getCurrentInstance} from "vue";
import Avatar from "../avatar/Avatar";
import {useToast} from "vue-toastification";

const toast = useToast();

export default defineComponent({
    components: {
        Avatar
    },
    props: {
        user: Object,
        comment: Object,
        ind: Number,
    },
    setup(props) {
        const isDisabled = ref('');
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const del = async (id) => {
            axios.post('/api/user/comment/delete', {id: id})
                .then(response => {
                    if (response.data.success) {
                        toast.success(response.data.message);
                        emitter.emit('deletecomment', {index: props.ind});
                        isDisabled.value = true;
                    } else {
                        toast.warning('Nie możesz usunąć!');
                        isDisabled.value = true;
                    }
                    setTimeout(() =>{
                        isDisabled.value = false;
                    }, 2000);
                })

        }

        return {
            isDisabled,
            del
        }
    }
});
</script>
