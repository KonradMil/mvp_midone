<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function AddObjectTeam(who,name,id, handle) {
    const list = ref([]);

    async function addObjectTeam(who,name,id, handle) {
        axios.post('/api/teams/user/add/team', {who: who,name: name,id: id})
            .then(response => {

                if (response.data.success) {
                    list.value = response.data.payload;
                    handle(response.data.payload);
                    toast.success(response.data.message)
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    addObjectTeam(who,name,id, handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
