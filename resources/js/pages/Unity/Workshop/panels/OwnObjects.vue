<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9 flex lg:block flex-col-reverse">
    <div v-if="objects.length == 0" class="text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
            Nie masz jeszcze żadnych zapisanych obiektów.
    </div>
<div v-for="(object, index) in objects" v-if="objects.length != 0">
<SingleWorkshopObject :object="object" :key="'obiekt_' + index"/>
</div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import SingleWorkshopObject from "../../../../components/SingleWorkshopObject";

export default {
    name: "OwnObjects",
    components: {SingleWorkshopObject},
    setup() {

        const objects = ref([]);


        const getObjects = () => {
            axios.post('/api/workshop/models/get/all')
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

        onMounted(() => {
            getObjects();
        });

        return {
            objects,
        }
    }
}
</script>

<style scoped>

</style>
