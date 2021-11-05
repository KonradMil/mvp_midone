<template>
    <div class="flex-initial pl-2">

        <p class="alert alert-warning show">Przed wprowadzeniem zmian upewnij się, że kursor znajduje się we właściwym polu.</p><br>

        <div class="mt-3">
            <label for="modal-form-1" class="form-label">Tytuł</label>
            <input
                id="modal-form-1"
                type="text"
                class="form-control"
                placeholder=""
                maxlength = "60"
                v-model="c.name"
                :disabled="((props.type === 'solution') && (user.type === 'investor'))"
            />
        </div>
        <div class="mt-3">
            <label for="modal-form-2" class="form-label">Opis</label>
            <textarea
                style="height: 200px;"
                id="modal-form-2"
                class="form-control"
                v-model="c.description"
                :disabled="((props.type === 'solution') && (user.type === 'investor'))"
            />
        </div>
    </div>
</template>

<script>
import {onMounted, provide, ref, watch} from "vue";
import {useStore} from "../../../../store";
import {useToast} from "vue-toastification";


const store = useStore();

export default {
    name: "DescriptionDialog",
    props: {
        object: Object,
        type: String
    },
    components: {

    },
    setup(props, context) {
        const c = ref({description: '', name: ''});
        const user = window.Laravel.user;
        const toast = useToast();
        const types = require("../../../../json/types.json");
        const images = ref([]);

        watch(c, (ca, prevLabel) => {
            context.emit("update:object", ca);
        }, {deep: true})

        const deleteImage = (index) => {
            images.value.splice(index, 1);
        }

        onMounted(() => {
            c.value = props.object

            // if (props.object.name != undefined && props.object.name != '') {
            //     c.value.name = props.object.name;
            // } else {
            //     c.value.name = '';
            // }
            // if (props.object.description != undefined && props.object.description != '') {
            //     c.value.description = props.object.description;
            // } else {
            //     c.value.description = '';
            // }
            // if (props.object.solution_deadline != undefined && props.object.solution_deadline != '') {
            //     c.value.solution_deadline = props.object.solution_deadline;
            // } else {
            //     c.value.solution_deadline = '';
            // }
            // if (props.object.offer_deadline != undefined && props.object.offer_deadline != '') {
            //     c.value.offer_deadline = props.object.offer_deadline;
            // } else {
            //     c.value.offer_deadline = '';
            // }
        });

        return {
            deleteImage,
            images,
            user,
            c,
            types,
            props
        }
    }
}
</script>

<style scoped>

</style>
