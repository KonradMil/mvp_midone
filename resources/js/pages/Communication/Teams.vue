<template>
    <td class="w-40">
            <div class="flex">
                <div class="w-10 h-10 image-fit zoom-in">
                    <Avatar :username="team.name" color="#FFF" background-color="#930f68"/>
                </div>
            </div>
        </td>
        <td>
            <a href="" class="font-medium whitespace-nowrap">{{ team.name }}</a>
            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">Sport &amp; Outdoor</div>
        </td>
        <td class="text-center">{{ $dayjs(team.created_at).format('DD.MM.YYYY HH:mm') }}</td>
        <td class="w-40">
            <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ team.users.length }} </div>
        </td>
        <td class="table-report__action w-56">
            <div class="flex justify-center items-center">
                <a class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                <a @click.prevent="$router.push({path: '/user/team/delete/' + team.id})" class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
            </div>
        </td>
</template>

<script>
import {useToast} from "vue-toastification";
import {getCurrentInstance, onMounted, ref} from "vue";
import Avatar from "../../components/avatar/Avatar";

export default {
    name: "Teams",
    components: {
        Avatar
    },
    props: {
        team: Object,
        ind: Number
    },
    setup(props, {emit}) {
        const toast = useToast();
        const tem = ref({});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        onMounted( () => {
            tem.value = props.team;
        });

        return {
            tem
        }
    }

}
</script>

<style scoped>

</style>
