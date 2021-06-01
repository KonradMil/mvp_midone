<template>

</template>

<script>
import {ref} from 'vue';

export default function GetOffers() {
    const list = ref([]);

    async function getOffers() {
        axios.post('/api/offer/get/all', {})
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

    getOffers();

    return {
        list
    }
}
</script>

<style scoped>

</style>
