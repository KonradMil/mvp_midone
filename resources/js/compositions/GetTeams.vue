<template>

</template>

<script>
import {ref} from 'vue';

export default function GetTeams(search,id,who,handle) {
    const list = ref([]);

    async function getTeams(search,id,who, handle) {
        axios.post('/api/teams/user/get', {search: search,id: id,who: who})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    handle(response.data.payload);
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getTeams(search,id,who,handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
