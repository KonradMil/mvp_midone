<template>

</template>

<script>
import {ref} from 'vue';

export default function AddTeam(name) {
    const list = ref(false);

    async function addTeam(name) {
        axios.post('/api/teams/user/create', {name: name})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.success;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    addTeam(name);

    return {
        list
    }
}
</script>

<style scoped>

</style>
