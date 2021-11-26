<template>
    <div>
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <div v-if="dataAr.length > 0" v-for="(save, index) in dataAr" :key="index" class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
<!--                <SingleFreeSave :user="user" :save="save"></SingleFreeSave>-->
            </div>
            <div v-else class="intro-y col-span-12 box pl-2 py-5 text-theme-1 dark:text-theme-10 font-medium">
                <div>
                    <p>
                       Konkurs zostanie uruchomiony wkrótce. Zostaniesz o tym poinformowany.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, provide, onMounted, getCurrentInstance, watch, onUpdated} from "vue";
import {useToast} from "vue-toastification";
import VueEasyLightbox from 'vue-easy-lightbox'
import RequestHandler from '../../compositions/RequestHandler'
import router from "../../router";
import Modal from "../../components/Modal"
import SingleFreeSave from "../../components/SingleFreeSave";

export default {
    name: "ContestsMainPage",
    props: {
        organization: {
            type: String
        }
    },
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
            axios.get('/api/contest/' + props.organization + '/get/all')
                .then(response => {
                    // dataAr.value = response.data.freeSaves;
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

        return {
            guard,
            saves,
            user,
            deleteSave,
            dataAr
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
