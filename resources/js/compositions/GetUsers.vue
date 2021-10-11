<template>

</template>

<script>
import {ref} from 'vue';

export default function GetUsers() {
    const list = ref([]);

    async function getUsers() {
        axios.get('api/communication', {})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getUsers();

    return {
        list
    }
}
</script>

<style scoped>

</style>
