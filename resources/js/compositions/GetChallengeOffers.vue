<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallengeOffers(id) {
    const list = ref([]);

    async function getChallengeOffers(id) {
        axios.post(`/api/offer/get/challenge/offers/${id}`, {})
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

    getChallengeOffers(id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
