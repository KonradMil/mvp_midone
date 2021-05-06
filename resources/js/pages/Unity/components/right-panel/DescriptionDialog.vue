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
        <label for="modal-form-2" class="form-label">Opis</label>
        <textarea
            id="modal-form-2"
            class="form-control"
            v-model="c.description"
        />
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";

export default {
    name: "DescriptionDialog",
    props: {
        object: Object
    },
    setup(props, context) {
        const c = ref({description: '', title: ''});
        watch(c, (ca, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:comment", ca);
        }, {deep: true})
        onMounted(() => {
            if (props.object.title != undefined && props.object.title != '') {
                c.value.title = props.object.title;
            } else {
                c.value.title = '';
            }

            if (props.object.description != undefined && props.object.description != '') {
                c.value.description = props.object.description;
            } else {
                c.value.description = '';
            }
        });

        return {
            c
        }
    }
}
</script>

<style scoped>

</style>
