<template>

</template>

<script>
import {ref} from 'vue';

export default function SaveChallengeDetails(data,id) {
    const list = ref([]);

    async function saveChallengeDetails(data,id) {
        axios.post(`/api/challenge/user/save/description/${id}`, {data})
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

    saveChallengeDetails(data,id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
