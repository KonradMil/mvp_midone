<template>

</template>

<script>
import {ref} from 'vue';

export default function GetTeams(search) {
    const list = ref([]);

    async function getTeams(search) {
        axios.post('/api/teams/user/get', {search: search})
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

    getTeams(search);

    return {
        list
    }
}
</script>

<style scoped>

</style>
