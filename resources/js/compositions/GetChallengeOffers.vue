<template>

</template>

<script>
import {ref} from 'vue';

export default function GetChallengeOffers(id) {
    const list = ref([]);

    async function getChallengeOffers(id) {
        axios.post(`/api/offer/get/challenge/offers/${id}`, {})
            .then(response => {

                if (response.data.success) {

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
