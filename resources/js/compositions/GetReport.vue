<template>

</template>

<script>
import {ref, unref} from 'vue';

export default async function GetReport(id, handle) {


    async function getReport(id) {
        await axios.post('/api/report/show', {id: id})
            .then(response => {

                if (response.data.success) {

                    handle(response.data);
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    let a = await getReport(id);



    return {
        ...a
    }

}
</script>

<style scoped>

</style>
