<template>
    <div>
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <button class="btn btn-primary ml-2 shadow-md mr-2" @click="addNewSave()">{{ $t('lite.addSave') }}</button>
            <div v-for="(save, index) in saves" :key="index" class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                <SingleFreeSave :user="user" :save="save"></SingleFreeSave>
            </div>
        </div>
    </div>

</template>

<script>
import {defineComponent, ref, provide, onMounted, getCurrentInstance, watch, onUpdated} from "vue";
import {useToast} from "vue-toastification";
import VueEasyLightbox from 'vue-easy-lightbox'
import RequestHandler from '../../../compositions/RequestHandler'
import router from "../../../router";
import Modal from "../../../components/Modal"
import SingleFreeSave from "../../../components/SingleFreeSave";

export default {
    name: "PlaygroundSaves",
    components: {
        SingleFreeSave,
        VueEasyLightbox, Modal
    },
    setup(props) {
        const saves = ref([]);
        const user = ref({});
        const dataAr = ref([]);
        const toast = useToast();
        const guard = ref(false);


        onMounted(function () {
            getData();
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        const getData = async () => {
            axios.post('/api/playground/freesaves/get')
                .then(response => {
                    dataAr.value = response.data.exist;
                })
        }

        const addNewSave = () => {
            axios.post('/api/playground/freesaves/add')
                .then(response => {
                    router.push({path: 'studio-playground/' + response.data});
                })
        }

        const deleteSave = async (id) => {
            axios.post('/api/playground/freesaves/delete', {id: id})
                .then(response => {

                    if (response.data.success) {
                        toast.success('Wyzwanie usunięte');
                        window.location.reload();
                    } else {

                    }
                })
        }


        onMounted(() => {
            getData();
        });


        return {
            guard,
            saves,
            user,
            deleteSave,
            dataAr,
            addNewSave
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next((vm) => {
            // vm.getSaveRepositories();
        });
    }
}
</script>
