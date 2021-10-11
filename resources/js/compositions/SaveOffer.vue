<template>

</template>

<script>
import {ref} from 'vue';
import {useToast} from "vue-toastification";

const toast = useToast();

export default function SaveOffer(data, handle) {
    const list = ref([]);

    async function saveOffer(data, handle) {
        axios.post('/api/offer/save', {data})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                    handle(response.data.payload);
                } else {
                }
            })
    }

    saveOffer(data, handle);

    return {
        list
    }
}
</script>

<style scoped>

</style>
