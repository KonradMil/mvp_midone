<template>

</template>

<script>
import {ref} from 'vue';

export default function GetQuestions(id, handle) {
    const list = ref([]);

    async function getQuestions(id, handle) {
        axios.post('/api/question/get', {id: id})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
                    list.value = response.data.payload;
                    handle(response.data.payload);
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getQuestions(id, handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
