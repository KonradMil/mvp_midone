<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallengesProjects() {
    const list = ref([]);

    async function getChallengesProjects() {
        axios.post('/api/challenge/user/get', {})
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

    getChallengesProjects();

    return {
        list
    }
}
</script>

<style scoped>

</style>
