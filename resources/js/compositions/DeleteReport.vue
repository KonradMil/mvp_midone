<template>

</template>

<script>
import {ref, unref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();


export default async function DeleteReport(id) {

    async function deleteReport(id) {
        await axios.post('/api/report/user/delete', {id: id})
            .then(response => {

                if (response.data.success) {

                    toast.success(response.data.message);
                } else {

                    toast.error('Ups! Coś poszło nie tak!');
                }
            })
    }
    deleteReport(id);
}
</script>

<style scoped>

</style>
