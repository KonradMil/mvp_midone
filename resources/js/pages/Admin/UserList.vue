<template>

</template>

<script>
import {computed, onMounted, ref} from "vue";
import cash from "cash-dom";
import {useToast} from "vue-toastification";


export default {
    name: "UserList",
    setup() {
        const toast = useToast();

        onMounted(() => {

            cash("body")
                .removeClass("error-page");
        });


        return {

        }
    }
}
</script>

<style scoped>

</style>
