<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function AddSolutionTeam(name,id) {
    const list = ref([]);

    async function addSolutionTeam(name,id) {
        axios.post(`/api/solution/user/add/team/${id}`, {name})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
                    list.value = response.data.payload;
                    toast.success(response.data.message)
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    addSolutionTeam(name,id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
