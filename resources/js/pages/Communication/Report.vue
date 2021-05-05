<template>
    <tr >
        <td class="w-40">
            <div class="flex" v-if="rep.files != undefined">
                <div class="w-10 h-10 image-fit zoom-in" v-if="rep.files.length != '0'">
                    {{ rep.files[0].original_name }}
                </div>
            </div>
        </td>
        <td>
            <a href="" class="font-medium whitespace-nowrap">{{ rep.title }}</a>
            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{rep.type}}</div>
        </td>
        <td class="text-center">{{ $dayjs(rep.created_at).format('DD.MM.YYYY HH:mm') }}</td>
        <td class="w-40">
            <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ rep.description }} </div>
        </td>
        <td class="table-report__action w-56">
            <div class="flex justify-center items-center">
                <a class="flex items-center mr-3" href="javascript:" @click.prevent="$router.push({path: '/report/show/' + rep.id })"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Podgląd </a>
                <a @click.prevent="del(rep.id)" class="flex items-center text-theme-6" href="" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
            </div>
        </td>
    </tr>
</template>

<script>
import {useToast} from "vue-toastification";
import {getCurrentInstance, onMounted, ref} from "vue";

export default {
    name: "Report",
    props: {
        report: Object,
        ind: Number
    },
    setup(props, {emit}) {
        const toast = useToast();
        const rep = ref({});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const del = async (report_id) => {
            axios.post('api/report/user/delete', {id: report_id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        toast.success(response.data.message);
                        emitter.emit('deletereport', {index: props.ind});
                    } else {
                        // toast.error(response.data.message);
                    }
                })

        }

        onMounted( () => {
           rep.value = props.report;
        });

        return {
            del,
            rep
        }
    }

}
</script>

<style scoped>

</style>
