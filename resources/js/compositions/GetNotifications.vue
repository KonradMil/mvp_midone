<template>

</template>

<script>
import {ref} from 'vue';

export default function GetNotifications() {
    const list = ref(false);

    async function getNotifications() {
        axios.post('api/notifications/get', {})
            .then(response => {
                if (response.data.success) {
                    // console.log(response.data);
                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getNotifications();

    return {
        list
    }
}
</script>

<style scoped>

</style>
