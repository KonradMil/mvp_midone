<template>

</template>

<script>
import {ref} from 'vue';

export default function GetOffers(id) {
    const list = ref([]);

    async function getOffers(id) {
        axios.post('/api/offer/get/all', {id: id})
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

    getOffers(id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
