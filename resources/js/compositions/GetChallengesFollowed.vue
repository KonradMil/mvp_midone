<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallengesFollowed() {
    const list = ref([]);

    async function getChallengesFollowed() {
        axios.post('/api/challenge/user/get/followed', {})
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

    getChallengesFollowed();

    return {
        list
    }
}
</script>

<style scoped>

</style>
