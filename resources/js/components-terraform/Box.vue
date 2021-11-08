<template>
    <div class="intro-y box" :class="classes">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "Box",
    props: {
        classes: {
            type: String
        }
    }
}
</script>

<style scoped>

</style>
