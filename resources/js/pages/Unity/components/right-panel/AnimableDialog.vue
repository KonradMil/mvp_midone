<template>
    <div>
        <label for="modal-form-1" class="form-label">Czas cyklu</label>
        <input
            id="modal-form-1"
            type="text"
            class="form-control"
            placeholder=""
            v-model="l.duration"
        />
    </div>

</template>
<script>
import {onMounted, ref, watch, watchEffect} from "vue";

export default {
    name: "AnimableDialog",
    components: {
    },
    props: {
        animable: Object
    },
    emits: ["update:animable"],
    setup(props, context) {
        const l = ref({duration: 1});

        watch(l, (lab, prevLabel) => {

            context.emit("update:animable", lab);
        }, {deep: true})

        onMounted(() => {
            if (props.animable.duration != undefined && props.animable.duration != '') {
                l.value.duration = props.animable.duration;
            } else {
                l.value.duration = 1;
            }
        });

        return {
            l
        }
    }
}
</script>

<style scoped>

</style>
