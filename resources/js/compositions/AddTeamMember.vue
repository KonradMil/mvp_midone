<template>

</template>

<script>
import {ref} from 'vue';

export default function AddTeamMember(email,team_id) {
    const list = ref(false);

    async function addTeam(email, team_id) {
        axios.post('/api/teams/user/invite', {email: email, team_id: team_id})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
                    list.value = response.data.success;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    addTeam(email, team_id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
