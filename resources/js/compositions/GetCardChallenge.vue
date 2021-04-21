<template>

</template>

<script>
import {ref} from 'vue';

export default function GetCardChallenge(id) {
    let list = ref({});

    async function getCardChallenge(id) {
        await  axios.post('/api/challenge/user/get/card', {id: id})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    console.log(response.data.payload);
                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getCardChallenge(id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
