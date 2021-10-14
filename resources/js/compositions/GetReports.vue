<template>

</template>

<script>
import {ref} from 'vue';

export default function GetReports() {
    const list = ref([]);

    async function getReports() {
        axios.post('api/report/user/get', {})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getReports();

    return {
        list
    }
}
</script>

<style scoped>

</style>
