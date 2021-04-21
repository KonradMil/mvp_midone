<template>

</template>

<script>
import {ref} from 'vue';

export default function sendEmail(email) {
    const list = ref(false);

    axios.post('api/user/forgot-password', {
            email: email
        })
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
                    list.value = response.data.success;
                } else {
                    // toast.error(response.data.message);
                }
            })
    return {
        list
    }
}
</script>

<style scoped>

</style>
