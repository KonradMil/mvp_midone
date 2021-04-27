<template>

</template>

<script>
import {ref} from 'vue';

export default async function GetModels(search) {


    async function getModels(search) {
        await axios.post('/api/models/get', {search: search})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
                    const list = response.data.payload;
                    console.log(list);
                    return list;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    let list = await getModels(search);
    return list;

}
</script>

<style scoped>

</style>
