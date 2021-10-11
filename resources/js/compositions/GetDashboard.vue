<template>

</template>

<script>
import {ref} from 'vue';

export default function GetDashboard(handle) {
    const list = ref([]);

    async function getDashboard(handle) {
        axios.post('/api/dashboard/get', {})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    handle(response.data.payload);
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getDashboard(handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
