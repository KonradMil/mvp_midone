<template>
    <tr>
    <td class="w-40">
            <div class="flex">
                <div class="w-10 h-10 image-fit zoom-in">
                    <Avatar :username="team.name" color="#FFF" background-color="#5e50ac"/>
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
    </tr>
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
        const isDisabled = ref(false);
        const toast = useToast();
        const tem = ref({});
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const del = async (team_id) => {
            axios.post('api/teams/user/delete', {id: team_id})
                .then(response => {

                    if (response.data.success) {
                        toast.success(response.data.message);
                        emitter.emit('deleteteam', {index: props.ind});
                        isDisabled.value = true;
                    } else {
                        // toast.error(response.data.message);
                        toast.warning('Nie możesz usunąć!');
                        isDisabled.value = true;
                    }
                    setTimeout(() =>{
                        isDisabled.value = false;
                    }, 2000);
                })

        }
        onMounted( () => {
            tem.value = props.team;
        });

        return {
            isDisabled,
            tem,
            del
        }
    }

}
</script>

<style scoped>

</style>
