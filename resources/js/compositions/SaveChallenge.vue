<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function SaveChallenge(data, handle) {
    const list = ref([]);

    async function saveChallenge(data, handle) {
        axios.post('/api/challenge/user/create', {data})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    handle(response.data.payload);
                } else {
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
