<template>

</template>

<script>
import {ref} from 'vue';

export default function GetInvites(handle) {
    const list = ref(false);

    async function getInvites(handle) {
        axios.post('/api/teams/user/invites/get', {})
            .then(response => {
                if (response.data.success) {
                    // console.log(response.data);
                    list.value = response.data.payload;
                    console.log(handle);
                    try {
                        handle(response.data);
                    }catch (e) {

                    }

                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getInvites(handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
