<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";


export default function SaveSolution(data, handle) {
    const list = ref([]);
    const toast = useToast();
    async function saveSolution(data, handle) {
        axios.post('/api/solution/save', {data})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    handle(response.data.payload);
                    toast.success('Zapisano.');
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    saveSolution(data, handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
