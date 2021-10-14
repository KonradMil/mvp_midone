<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallengesArchive() {
    const list = ref([]);

    async function getChallengesArchive() {
        axios.post('/api/challenge/user/get/archive', {})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getChallengesArchive();

    return {
        list
    }
}
</script>

<style scoped>

</style>
