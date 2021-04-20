<template>
    <div class="mt-3">
        <label for="modal-form-1" class="form-label">Tytuł</label>
        <input
            id="modal-form-1"
            type="text"
            class="form-control"
            placeholder=""
            v-model="title"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Komentarz</label>
        <textarea
            id="modal-form-2"
            class="form-control"
            v-model="comment"
        />
    </div>
</template>

<script>
import {onMounted, ref} from "vue";

export default {
    name: "CommentDialog",
    setup(props) {
        const title = ref('');
        const comment = ref('');

        onMounted(() => {
            if (props.title != undefined && props.title != '') {
                title.value = props.title;
            }

            if (props.comment != undefined && props.comment != '') {
                comment.value = props.comment;
            }
        });

        return {
            comment,
            title
        }
    }
}
</script>

<style scoped>

</style>
