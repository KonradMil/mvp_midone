<template>
    <div class="mt-3">
        <label for="modal-form-1" class="form-label">Link</label>

    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Aktywni użytkownicy</label>

    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";

export default {
    name: "MultiplayerDialog",
    props: {

    },
    emits: ["update:comment"],
    setup(props, context) {
        const c = ref({url: '', participants: []});
        // watch(c, (ca, prevLabel) => {

        //     context.emit("update:comment", ca);
        // }, {deep: true})
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
