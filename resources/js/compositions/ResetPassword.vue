<template>

</template>

<script>
import {ref} from 'vue';

export default function ResetPassword(email) {

    const list = ref(false);

    async function resetPassword(email) {
        axios.post('api/forgot-password', {email: email})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.success;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    resetPassword(email);

    return {
        list
    }
}
</script>

<style scoped>

</style>
