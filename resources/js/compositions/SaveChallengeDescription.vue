<template>

</template>

<script>
import {ref} from 'vue';

export default function SaveChallengeDescription(data) {
    const list = ref([]);
    console.log('DATA HERE');
    console.log(data);
    async function saveChallenge(data) {
        axios.post('/api/challenge/user/save/description', {data})
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

    saveChallenge(data);

    return {
        list
    }
}
</script>

<style scoped>

</style>
