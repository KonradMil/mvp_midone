<template>
<div v-for="(object, index) in objects">
    1
</div>
</template>

<script>
import {ref} from "vue";

export default {
    name: "OwnObjects",
    setup() {
        const objects = ref([]);

        const getObjects = () => {
            this.$axios.post('/api/workshop/objects/get')
                .then(response => {
                    if (response.data.success) {
                      objects.value = response.data.payload;
                    } else {
                        console.log(response)
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
        }

        return {
            objects,
            getObjects
        }
    }
}
</script>

<style scoped>

</style>
