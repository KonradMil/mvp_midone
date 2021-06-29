<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallengesArchive() {
    const list = ref([]);

    async function getChallengesArchive() {
        axios.post('/api/challenge/user/get/archive', {})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
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
