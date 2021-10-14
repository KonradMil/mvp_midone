<template>

</template>

<script>
import {ref} from 'vue';

export default function GetModelsUnity(search) {
    const list = ref([]);

    async function getModels(search) {
        axios.post('/api/models/get/unity', {search: search})
            .then(response => {

                if (response.data.success) {

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
