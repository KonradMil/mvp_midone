<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallenges() {
    const list = ref([]);

    async function getChallenges() {
        axios.post('api/challenge/user/get', {})
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

    getChallenges();

    return {
        list
    }
}
</script>

<style scoped>

</style>
