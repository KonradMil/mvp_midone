<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function EditModel(model) {
    const list = ref([]);

    async function editModel(model) {
        axios.post('/api/model/edit/', {model})
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

    editModel(model);

    return {
        list
    }
}
</script>

<style scoped>

</style>
