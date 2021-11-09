<template>
    <input :type="type"
           class="form-control placeholder-gray-600"
           :class="classes"
           :placeholder="$t(placeholder)"
           :value="val"
           @input="$emit('update:val', $event.target.value)"/>
</template>

<script>
export default {
    name: "Input",
    props: {
        type: {
            type: String,
            required: true
        },
        placeholder: {
            type: String
        },
        classes: {
            type: String
        },
        val: {}
    }
}
</script>

<style scoped>

</style>
