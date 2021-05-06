<template>
    <div class="mt-3">
        <label for="modal-form-1" class="form-label">Zespoły</label>
<!--        <input-->
<!--            id="modal-form-1"-->
<!--            type="text"-->
<!--            class="form-control"-->
<!--            placeholder=""-->
<!--            v-model="c.title"-->
<!--        />-->
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Wiadomości</label>
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
    name: "TeamsDialog",
    props: {
      comment: Object
    },
    setup(props, context) {
        const c = ref({message: '', addedTeams: [], teams: []});
        watch(c, (ca, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:comment", ca);
        }, {deep: true})
        onMounted(() => {

        });

        return {
            c
        }
    }
}
</script>

<style scoped>

</style>
