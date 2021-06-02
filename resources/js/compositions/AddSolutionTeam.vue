<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function AddSolutionTeam(name,id, handle) {
    const list = ref([]);

    async function addSolutionTeam(name,id, handle) {
        axios.post(`/api/solution/user/add/team/${id}`, {name})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    list.value = response.data.payload;
                    handle(response.data.payload);
                    toast.success(response.data.message)
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    addSolutionTeam(name,id, handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
