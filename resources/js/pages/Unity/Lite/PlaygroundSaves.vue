<template>
    <div>
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <button class="btn btn-primary shadow-md mr-2" @click="$router.push({name: 'studio-playground'})">{{ $t('lite.addSave') }} </button>

            <!-- BEGIN: Blog Layout -->
            <div class="intro-y col-span-12 box pl-2 py-5 text-theme-1 dark:text-theme-10 font-medium" v-if="saves == undefined || saves.length == 0">

            </div>
            <div v-for="(save, index) in saves" :key="index" class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">
                    <div class="w-10 h-10 flex-none image-fit">
                        <img alt="DBR77" class="rounded-full" :src="'/' + save.screenshot_path"/>
                    </div>
                    <div class="ml-3 mr-auto" @click.prevent="$router.push( {path : '/challenges/card/' + save.id})">
                        <a href="" class="font-medium">{{ save.name }}</a>
                    </div>
                    <div class="dropdown ml-3">
                        <a href="javascript:" class="dropdown-toggle w-5 h-5 text-gray-600 dark:text-gray-300" aria-expanded="false">
                            <MoreVerticalIcon class="w-5 h-5"/>
                        </a>
                        <div class="dropdown-menu w-40">
                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                <a href="" @click.prevent="$router.push({name: 'addChallenge', params: {challenge_id: save.id }});" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <Edit2Icon class="w-4 h-4 mr-2"/>
                                    Edytuj
                                </a>
                                <a href="" @click.prevent="deleteSave(save.id)" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                    <TrashIcon class="w-4 h-4 mr-2"/>
                                    Usuń
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="h-40 xxl:h-56 image-fit" @click="$router.push( {path : '/challenges/card/' + save.id})">
                        <img
                            alt="DBR77"
                            class="rounded-md"
                            :src="'/' + save.screenshot_path"/>
                    </div>
                    <a href="" class="block font-medium text-base mt-5"></a>
                </div>
                <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5">

                </div>
            </div>
            <!-- END: Blog Layout -->
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, provide, onMounted, getCurrentInstance, watch, onUpdated} from "vue";
import {useToast} from "vue-toastification";
import RequestHandler from '../../../compositions/RequestHandler'

export default {
    name: "PlaygroundSaves",
    components: {},
    setup(props) {
        const saves = ref([]);
        const user = ref({});
        const toast = useToast();
        const guard = ref(false);

        const getSaveRepositories = async (callback) => {
            RequestHandler('playground/saves', 'get', {}, (response) => {
                saves.value = response.data.payload;
            });
        }

        onMounted(function () {
            getSaveRepositories();
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        const deleteSave = async (id) => {
            axios.post('/api/playground/saves/delete', {id: id})
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
            getSaveRepositories,
            deleteSave
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next((vm) => {
            vm.getSaveRepositories();
        });
    }
}
</script>
