<template>

</template>

<script>
import {ref} from 'vue';

export default function SavePost(data) {
    const list = ref([]);

    async function savePost(data) {
        axios.post('/api/knowledgebase/post/add', {data})
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

    savePost(data);

    return {
        list
    }
}
</script>

<style scoped>

</style>
