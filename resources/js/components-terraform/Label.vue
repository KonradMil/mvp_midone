<template>
    <label class="form-label" :title="$t(title)">{{$t(title)}}</label>
</template>

<script>
export default {
    name: "Label",
    props: {
        title: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
