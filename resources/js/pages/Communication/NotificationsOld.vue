<template>
    <div class="inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
            <div class="flex px-5 py-3">
                <div class="w-72 flex-none flex items-center mr-5">
                    <input class="form-check-input flex-none" type="checkbox" checked>
                    <a href="javascript:;" class="w-5 h-5 flex-none ml-4 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="star"></i> </a>
                    <a href="javascript:;" class="w-5 h-5 flex-none ml-2 flex items-center justify-center text-gray-500"> <i class="w-4 h-4" data-feather="bookmark"></i> </a>
                    <div class="w-6 h-6 flex-none image-fit relative ml-5">
                        <Avatar :src="(not.list != undefined)? '/s3/avatars/' + not.list.author.avatar : ''" :username="not.list.author.name + ' ' + not.list.author.lastname" :size="30" color="#FFF" background-color="#5e50ac"/>
                    </div>
                    <div class="inbox__item--sender truncate ml-3">{{not.list.author.name + ' ' + not.list.author.lastname}}</div>
                </div>
                <div class="w-64 sm:w-auto truncate"> <span class="inbox__item--highlight">{{not.list.message}}</span> <button v-if="not.list.link != undefined" type="button" class="btn ml-5" @click="$router.push({path: not.list.link})">{{$t('communication.goTo')}}</button> </div>
                <div class="inbox__item--time whitespace-nowrap ml-auto pl-10">{{$dayjs(not.created_at).format('DD.MM.YYYY HH:mm')}}</div>
            </div>
        </div>
</template>

<script>
import {getCurrentInstance, onMounted, provide, ref, watch} from "vue";
import {useStore} from "../../store";

const store = useStore();

export default {
    name: "NotificationsOld",
    props : {
        notification : Object,
        ind : Number
    },
    components: {
    },
    setup(props, {emit}) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const user =ref({});
        const not = ref([]);

        onMounted( () => {
            not.value = props.notification;
            cash("body")
                .removeClass("error-page")
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        })
        return {
            not
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
