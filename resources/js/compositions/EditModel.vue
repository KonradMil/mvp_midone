<template>

</template>

<script>
import {ref} from 'vue';

export default function EditModel(data,id) {
    const list = ref([]);

    async function editModel(data,id) {
        axios.post(`/api/models/edit/${id}`, {data,id})
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

    editModel(data,id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
