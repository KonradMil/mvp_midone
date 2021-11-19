<template>
    <div class="modal-mask" :class="clasess">
        <div class="modal-close " @click="$emit('close')"></div>
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-body">
                    <slot name="body">

                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    props: {
        clasess: String,
        title: String,
        subtitle: String,
        button_title: String
    }
}
</script>

<style scoped>

</style>
