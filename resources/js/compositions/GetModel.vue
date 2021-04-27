<template>

</template>

<script>
import {ref} from 'vue';

export default function GetModel(id) {
    const list = ref([]);

    async function getModel(id) {
        axios.post('/api/model/get', {id: id})
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

    getModel(id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
