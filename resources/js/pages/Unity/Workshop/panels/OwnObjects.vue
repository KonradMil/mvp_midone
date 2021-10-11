<template>
    <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9 md:col-span-10 flex lg:block flex-col-reverse">
        <div v-if="objects.length == 0" class="text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
            Nie masz jeszcze żadnych zapisanych obiektów.
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div v-for="(object, index) in objects" :key="'workshop_object' + index" v-if="objects.length != 0" @click="send(object)" class="box intro-y col-span-12 lg:col-span-4 xxl:col-span-4 flex lg:block flex-col-reverse">
                <SingleWorkshopObject :object="object" :key="'obiekt_' + index" :own="true" />
            </div>
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
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const objects = ref([]);

        emitter.on('singleobjectdeleted', e => {
           objects.value.forEach((obj, index) => {
              if(obj.id == e.id) {
                  objects.value.splice(index,1);
              }
           });
        });

        emitter.on('singleobjectcopied', e => {
            getObjects();
        });

        const send = (object) => {

            emitter.emit('workshop_object_clicked', {object: object});
        }

        const getObjects = () => {
            axios.post('/api/workshop/models/get/all', {own: true})
                .then(response => {
                    if (response.data.success) {
                        objects.value = response.data.payload;
                    } else {

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
            send,
            objects,
        }
    }
}
</script>

<style scoped>

</style>
