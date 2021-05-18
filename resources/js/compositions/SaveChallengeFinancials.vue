<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function SaveChallengeFinancials(data,id) {
    const list = ref([]);

    async function saveChallengeFinancials(data,id) {
        axios.post(`/api/challenge/user/save/financials/${id}`, {data})
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

    saveChallengeFinancials(data,id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
