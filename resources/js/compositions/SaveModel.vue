<template>

</template>

<script>
import {ref} from 'vue';

export default function SaveModel(data) {
    const list = ref([]);

    async function saveModel(data) {
        axios.post('/api/models/add', {data})
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

    saveModel(data);

    return {
        list
    }
}
</script>

<style scoped>

</style>
