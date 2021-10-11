<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function SaveChallengeTeams(data,id) {
    const list = ref([]);

    async function saveChallengeTeams(data,id) {
        axios.post(`/api/challenge/user/save/teams/${id}`, {data})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    toast.success(response.data.message)
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    saveChallengeTeams(data,id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
