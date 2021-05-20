<template>
    <div class="intro-y box p-5">
        <div>
            <label for="crud-form-1" class="form-label">Title</label>
            <input id="crud-form-1"
                   type="text"
                   class="form-control w-full"
                   placeholder=""
                   v-model="report.title"
                   disabled
            >
        </div>
        <div class="mt-3">
            <label for="crud-form-2" class="form-label">Czego dotyczy</label>
            <input id="crud-form-2"
                   type="text"
                   class="form-control w-full"
                   placeholder=""
                   v-model="report.type"
                   disabled
            >
        </div>
        <div class="pt-5">
            <div
                class="border border-gray-200 dark:border-dark-5 rounded-md p-5"
            >
                <div
                    class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"
                >
                    {{$t('challengesNew.description')}}
                </div>
                <div class="mt-5">
                    <textarea v-model="report.description" class="w-full h-36 form-control" style="width: 100%;" disabled></textarea>
                </div>
            </div>
        </div>
        <div
            class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5"
        >
            <div class="mt-5">
                <div class="mt-3">
                    <label class="form-label"> {{ $t('global.file') }}</label>
                    <div
                        class="rounded-md pt-4"
                    >
                        <div class="flex flex-wrap px-4">
                            <div class="flex" v-if="report.files != undefined">
                                <div class="w-10 h-10 image-fit zoom-in" v-if="report.files.length != '0'">
                                    {{ report.files[0].original_name }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</template>
<script>
import {onMounted, provide, ref} from "vue";
import cash from "cash-dom";
import GetUsers from '../../compositions/GetUsers'
import GetReport from '../../compositions/GetReport'
import Dropzone from '../../global-components/dropzone/Main'
import {useToast} from "vue-toastification";
import Avatar from "../../components/avatar/Avatar";
import Modal from "../../components/Modal";
import GetModel from "../../compositions/GetModel";

export default {
    name: "reportReview",
    components: {
        Avatar,
        Modal,
        GetUsers,
        Dropzone,
    },
    props : {
        id: Number
    },
    setup(props, {emit}) {
        const users = ref([]);
        const user =ref({});
        const report = ref('');
        const reports = ref([]);
        const title = ref('');
        const type = ref('');
        const description = ref('');
        const files = ref([]);
        const dropzoneSingleRef = ref();
        const report_id = ref(null);

        provide("bind[dropzoneSingleRef]", el => {
            dropzoneSingleRef.value = el;
        });

        const GetReportRepo = async () => {
            GetReport(report_id, (res) => {
                report.value = res.payload[0];
            })
        }

        const GetUsersRepositories = async () => {
            users.value = GetUsers();
        }

        onMounted(function () {
            GetUsersRepositories('');
            GetReportRepo('');
            report_id.value = props.id;

            // const elDropzoneSingleRef = dropzoneSingleRef.value;
            // console.log(elDropzoneSingleRef);
            // elDropzoneSingleRef.dropzone.on("success", (resp) => {
            //     files.value.push(JSON.parse(resp.xhr.response).payload);
            //
            // });
            // elDropzoneSingleRef.dropzone.on("error", () => {
            //     toast.error("Błąd");
            // });
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })
        return {
            users,
            user,
            reports,
            report,
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
