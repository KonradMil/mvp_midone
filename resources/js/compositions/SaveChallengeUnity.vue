<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";


export default function SaveChallenge(data, handle) {
    const list = ref([]);
    const toast = useToast();
    async function saveChallenge(data, handle) {
        axios.post('/api/challenge/user/save', {data})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
                    list.value = response.data.payload;
                    handle(response.data.payload);
                    toast.success('Zapisano.');
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    saveChallenge(data, handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
