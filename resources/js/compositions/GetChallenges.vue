<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallenges() {
    const list = ref([]);

    async function getChallenges() {
        axios.post('/api/challenge/user/get', {})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getChallenges();

    return {
        list
    }
}
</script>

<style scoped>

</style>
