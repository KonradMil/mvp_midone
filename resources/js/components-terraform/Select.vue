<template>
        <select class="own-select form-control" :class="classes" :value="val" @change="$emit('update:val', $event.target.value)">
            <option selected disabled value="">Wybierz...</option>
            <option v-for="(option, index) in options" :key="'option_' + index">{{option}}</option>
            <slot></slot>
        </select>
</template>

<script>
import {ref, watch} from "vue";

export default {
    name: "Select",
    props: {
        classes: {
            type: String
        },
        options: {
            type: Array
        },
        val: {}
    },
    setup(props, {emit}) {

    }
}
</script>

<style scoped>

</style>
