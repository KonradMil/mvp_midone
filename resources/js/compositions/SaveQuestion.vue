<template>

</template>

<script>
import {getCurrentInstance, ref} from 'vue';

export default function SaveQuestion(data, handle) {
    const list = ref([]);


    async function saveQuestion(data, handle) {
        axios.post('/api/question/create', {data})
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


    saveQuestion(data, handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
