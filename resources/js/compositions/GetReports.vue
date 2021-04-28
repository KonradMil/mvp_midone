<template>

</template>

<script>
import {ref} from 'vue';

export default function GetReports() {
    const list = ref([]);

    async function getReports() {
        axios.post('api/report/user/get', {})
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

    getReports();

    return {
        list
    }
}
</script>

<style scoped>

</style>
