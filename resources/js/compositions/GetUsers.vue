<template>

</template>

<script>
import {ref} from 'vue';

export default function GetUsers() {
    const list = ref([]);

    async function getUsers() {
        axios.get('api/communication', {})
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

    getUsers();

    return {
        list
    }
}
</script>

<style scoped>

</style>
