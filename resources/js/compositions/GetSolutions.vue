<template>

</template>

<script>
import {ref} from 'vue';

export default function GetSolutions() {
    const list = ref([]);

    async function getSolutions() {
        axios.post('/api/solution/user/get', {})
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

    getSolutions();

    return {
        list
    }
}
</script>

<style scoped>

</style>
