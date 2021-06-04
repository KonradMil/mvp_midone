<template>

</template>

<script>
import {ref} from 'vue';

export default function GetModelsUnity(search) {
    const list = ref([]);

    async function getModels(search) {
        axios.post('/api/models/get/unity', {search: search})
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

    getModels(search);

    return {
        list
    }
}
</script>

<style scoped>

</style>
