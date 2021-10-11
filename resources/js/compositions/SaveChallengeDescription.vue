<template>

</template>

<script>
import {ref} from 'vue';

export default function SaveChallengeDescription(data) {
    const list = ref([]);


    async function saveChallenge(data) {
        axios.post('/api/challenge/user/save/description', {data})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    saveChallenge(data);

    return {
        list
    }
}
</script>

<style scoped>

</style>
