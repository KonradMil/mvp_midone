<template>

</template>

<script>
import {ref} from 'vue';

export default function AcceptInvite(id) {
    const list = ref(false);

    async function acceptInvite(id) {
        axios.post('/api/teams/user/invite/accept', {id: id})
            .then(response => {
                if (response.data.success) {

                    list.value = response.data.success;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    acceptInvite(id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
