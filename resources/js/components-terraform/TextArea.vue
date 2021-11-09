<template>
    <textarea class="form-control" :class="classes" :value="val" @input="$emit('update:val', $event.target.value)"></textarea>
</template>

<script>
export default {
    name: "TextArea",
    props: {
        classes: {
            type: String
        },
        val: {}
    }
}
</script>
