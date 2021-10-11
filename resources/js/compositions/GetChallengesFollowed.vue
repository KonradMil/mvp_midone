<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallengesFollowed() {
    const list = ref([]);

    async function getChallengesFollowed() {
        axios.post('/api/challenge/user/get/followed', {})
            .then(response => {

                if (response.data.success) {

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
