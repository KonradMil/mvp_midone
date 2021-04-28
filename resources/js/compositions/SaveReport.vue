<template>

</template>

<script>
import {ref} from 'vue';

export default function SaveReport(data) {
    const list = ref([]);

    async function saveReport(data) {
        axios.post('/api/report/user/create', {data})
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

    saveReport(data);

    return {
        list
    }
}
</script>

<style scoped>

</style>
