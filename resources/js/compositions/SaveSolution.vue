<template>

</template>

<script>
import {ref} from 'vue';

export default function SaveSolution(data) {
    const list = ref([]);

    async function saveSolution(data) {
        axios.post('/api/solution/user/create', {data})
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

    saveSolution(data);

    return {
        list
    }
}
</script>

<style scoped>

</style>
