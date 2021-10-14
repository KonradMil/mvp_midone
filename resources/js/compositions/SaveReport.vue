<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();


export default function SaveReport(data, handle) {
    const list = ref([]);

    async function saveReport(data) {
        axios.post('/api/report/user/create', {data})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    handle(response.data.payload);
                    toast.success(response.data.message);
                } else {
                    toast.error(response.data.message);
                }
            })
    }

    saveReport(data);

    return {
        list
    }
}
</script>

<style scoped>

</style>
