<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function EditModel(id,data) {
    const list = ref([]);

    async function editModel(id,data) {
        axios.post('/api/model/edit/', {id : id,data : data})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
                    list.value = response.data.payload;
                    toast.success(response.data.message);
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    editModel(id,data);

    return {
        list
    }
}
</script>

<style scoped>

</style>
