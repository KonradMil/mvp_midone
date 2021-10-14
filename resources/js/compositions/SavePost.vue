<template>

</template>

<script>
import {ref} from 'vue';

export default function SavePost(data) {
    const list = ref([]);

    async function savePost(data) {
        axios.post('/api/knowledgebase/post/add', {data})
            .then(response => {

                if (response.data.success) {

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
