<template>
<div v-for="(object, index) in objects">
<SingleWorkshopObject :object="object" :key="'obiket_' + index"/>
</div>
</template>

<script>
import {ref} from "vue";
import SingleWorkshopObject from "../../../../components/SingleWorkshopObject";

export default {
    name: "OwnObjects",
    components: {SingleWorkshopObject},
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
