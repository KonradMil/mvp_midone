<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function SaveSolutionDescription(data) {
    const list = ref([]);


    async function saveSolution(data) {
        axios.post('/api/solution/save/description', {data})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    toast.success('Zapisano edycje');
                } else {
                    toast.error('Błąd podczas zapisu!');
                }
            })
    }

    saveSolution(data);

    return {
        list
    }
}
</script>

<style scoped>

</style>
