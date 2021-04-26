<template>

</template>

<script>
import {ref} from 'vue';

export default function EditModel(id) {
    const list = ref([]);

    async function editModel(id) {
        axios.post('/api/models/edit', {id})
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

    editModel(id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
