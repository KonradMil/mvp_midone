<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function SaveSolutionDescription(data) {
    const list = ref([]);
    console.log('DATA HERE');
    console.log(data);
    async function saveSolution(data) {
        axios.post('/api/solution/save/description', {data})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
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
