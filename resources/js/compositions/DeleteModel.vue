<template>

</template>

<script>
import {ref, unref} from 'vue';
import {useToast} from "vue-toastification";
const toast = useToast();


export default async function DeleteModel(id) {

    async function deleteModel(id) {
        await axios.post('/api/model/user/delete', {id: id})
            .then(response => {

                if (response.data.success) {

                    toast.success(response.data.message);
                } else {
                    toast.error('Ups! Coś poszło nie tak!');
                }
            })
    }

    deleteModel(id);
}
</script>

<style scoped>

</style>
