<template>

</template>

<script>
import {ref} from 'vue';

export default function GetNotifications(number = 5) {
    const list = ref(false);

    async function getNotifications(number) {
        axios.post('/api/notifications/get', {number : number})
            .then(response => {
                if (response.data.success) {

                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getNotifications(number);

    return {
        list
    }
}
</script>

<style scoped>

</style>
