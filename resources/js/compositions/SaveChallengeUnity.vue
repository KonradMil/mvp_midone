<template>

</template>

<script>
import {ref} from 'vue';

export default function SaveChallenge(data) {
    const list = ref([]);

    async function saveChallenge(data) {
        axios.post('/api/challenge/user/save', {data})
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
