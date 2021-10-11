<template>
    <div class="mt-3">
        <label for="modal-form-1" class="form-label">Tytuł</label>
        <input
            id="modal-form-1"
            type="text"
            class="form-control"
            placeholder=""
            v-model="c.title"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Komentarz</label>
        <textarea
            id="modal-form-2"
            class="form-control"
            v-model="c.message"
        />
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";

export default {
    name: "CommentDialog",
    props: {
      comment: Object
    },
    emits: ["update:comment"],
    setup(props, context) {
        const c = ref({message: '', title: ''});
        watch(c, (ca, prevLabel) => {

            context.emit("update:comment", ca);
        }, {deep: true})
        onMounted(() => {
            if (props.comment.message != undefined && props.comment.message != '') {
                c.value.message = props.comment.message;
            } else {
                c.value.message = '';
            }

            if (props.comment.title != undefined && props.comment.title != '') {
                c.value.title = props.comment.title;
            } else {
                c.value.title = '';
            }

            c.value.index = props.comment.index;
            c.value.labelPosition = props.comment.commentPosition;
            c.value.labelRotation = props.comment.commentRotation;
        });

        return {
            c
        }
    }
}
</script>

<style scoped>

</style>
