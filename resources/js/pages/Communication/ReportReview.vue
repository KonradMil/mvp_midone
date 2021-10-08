<template>
    <div class="intro-y box p-5">
        <div>
            <label for="crud-form-1" class="form-label">Tytuł wiadomości</label>
            <input id="crud-form-1"
                   type="text"
                   class="form-control w-full"
                   placeholder=""
                   v-model="report.title"
                   disabled>
        </div>
        <div class="mt-3">
            <label for="crud-form-2" class="form-label">Czego dotyczy</label>
            <input id="crud-form-2"
                   type="text"
                   class="form-control w-full"
                   placeholder=""
                   v-model="report.type"
                   disabled>
        </div>
        <div class="pt-5">
            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5">
                    {{$t('challengesNew.description')}}
                </div>
                <div class="mt-5">
                    <textarea v-model="report.description" class="w-full h-36 form-control" style="width: 100%;" disabled></textarea>
                </div>
            </div>
        </div>
        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
            <div class="mt-5" v-if="report.files !== undefined">
                <div class="mt-3" v-if="report.files.length > 0">
                    <label class="form-label"> Pliki</label>
                    <div class="rounded-md pt-4">
                        <div class="row flex h-full">
                            <div class=" h-full" v-for="(file, index) in report.files" :key="'file_' + index">
                                <div class="pos-image__preview image-fit w-44 h-46 rounded-md m-5" style="overflow: hidden;">
                                    <img class="w-full h-full"
                                         :alt="file.original_name"
                                         :src="'/' + file.path"/>
                                    <div style="width: 94%; bottom: 0; position: relative; margin-top: 100%; margin-left: 10px; font-size: 16px; font-weight: bold;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3" v-else>
                    <span class="font-medium dark:text-theme-10 text-theme-1">Brak plików</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {onMounted, provide, ref} from "vue";
import GetUsers from '../../compositions/GetUsers'
import Dropzone from '../../global-components/dropzone/Main'
import Avatar from "../../components/avatar/Avatar";
import Modal from "../../components/Modal";

export default {
    name: "reportReview",
    components: {
        Avatar,
        Modal,
        GetUsers,
        Dropzone,
    },
    props : {
        id: Number,
        report: Object
    },
    setup(props, {emit}) {
        const users = ref([]);
        const user =ref({});
        const reports = ref([]);
        const files = ref([]);
        const dropzoneSingleRef = ref();
        const guard = ref(false);

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        const GetUsersRepositories = async () => {
            users.value = GetUsers();
        }

        onMounted(function () {
            GetUsersRepositories('');
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })
        return {
            guard,
            users,
            user,
            reports,
            files
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>

<style scoped>

</style>
