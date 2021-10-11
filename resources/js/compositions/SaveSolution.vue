<template>

</template>

<script>
import {ref} from 'vue';

export default function SaveSolution(data) {
    const list = ref([]);

    async function saveSolution(data) {
        axios.post('/api/solution/user/create', {data})
            .then(response => {

                if (response.data.success) {

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
