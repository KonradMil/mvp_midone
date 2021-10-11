<template>

</template>

<script>
import {ref} from 'vue';

export default function GetKnowledgebasePosts(search) {
    const list = ref([]);

    async function getPosts(search) {
        axios.post('/api/knowledgebase/post/get', {search: search})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getPosts(search);

    return {
        list
    }
}
</script>

<style scoped>

</style>
