<template>
    <div>LOADING</div>
</template>
<script>
import {computed, onMounted, ref} from "vue";
import cash from "cash-dom";
import {useToast} from "vue-toastification";


export default {
    name: "Secret",
    setup() {
        const toast = useToast();


        onMounted(() => {
            cash("body").removeClass("error-page");
            setTimeout(() => {
                let user = JSON.parse($cookies.get('letmein'));
                store.dispatch('login/login', {
                    user
                })
            }, 1000)
        });

        return {

        }
    }
}
</script>

<style scoped>

</style>
