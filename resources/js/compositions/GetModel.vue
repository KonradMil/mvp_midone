<template>

</template>

<script>
import {ref, unref} from 'vue';

export default async function GetModel(id, handle) {


    async function getModel(id) {
        await axios.post('/api/model/get', {id: id})
            .then(response => {

                if (response.data.success) {

                    handle(response.data);
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    let a = await getModel(id);



    return {
        ...a
    }

}
</script>

<style scoped>

</style>
