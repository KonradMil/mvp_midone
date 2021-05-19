<template>

</template>

<script>
import {ref} from 'vue';

export default function GetInvites() {
    const list = ref(false);

    async function getInvites() {
        axios.post('/api/teams/user/invites/get', {})
            .then(response => {
                if (response.data.success) {
                    // console.log(response.data);
                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getInvites();

    return {
        list
    }
}
</script>

<style scoped>

</style>
