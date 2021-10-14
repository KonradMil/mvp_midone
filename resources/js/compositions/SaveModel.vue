<template>

</template>

<script>
import {ref} from 'vue';

export default function SaveModel(data) {
    const list = ref([]);

    async function saveModel(data) {
        axios.post('/api/models/add', {data})
            .then(response => {

                if (response.data.success) {

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
