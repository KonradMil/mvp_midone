<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function SaveSolutionFinancials(data,id) {
    const list = ref([]);

    async function saveSolutionFinancials(data,id) {
        axios.post(`/api/solution/save/financials/${id}`, {data})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    toast.success(response.data.message)
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    saveSolutionFinancials(data,id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
