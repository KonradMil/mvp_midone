<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function EditModel(data,id) {
    const list = ref([]);

    async function editModel(data,id) {
        axios.post(`/api/model/edit/${id}`, {data})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    toast.success(response.data.message);
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    editModel(data,id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
