<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

export default function AddTeamMember(email,team_id) {
    const list = ref(false);
    const toast = useToast();

    async function addTeam(email, team_id) {
        axios.post('/api/teams/user/invite', {email: email, team_id: team_id})
            .then(response => {
                if (response.data.success) {
                    list.value = response.data.success;
                } else {
                    toast.error(response.data.message);
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
