<template>

</template>

<script>
import {ref} from 'vue';

export default function GetSolutionsArchive() {
    const list = ref([]);

    async function getSolutionsArchive() {
        axios.post('/api/solution/user/get/archive', {})
            .then(response => {
                if (response.data.success) {
                    list.value = response.data.payload;
                } else {
                }
            })
    }

    getSolutionsArchive();

    return {
        list
    }
}
</script>

<style scoped>

</style>
