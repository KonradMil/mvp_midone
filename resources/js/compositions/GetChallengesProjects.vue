<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallengesProjects() {
    const list = ref([]);

    async function getChallengesProjects() {
        axios.post('/api/challenge/user/get/projects', {})
            .then(response => {

                if (response.data.success) {

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
