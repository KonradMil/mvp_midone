<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function EditModel() {
    const list = ref([]);

    async function editModel() {
        axios.post('/api/model/edit/')
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

    editModel();

    return {
        list
    }
}
</script>

<style scoped>

</style>
