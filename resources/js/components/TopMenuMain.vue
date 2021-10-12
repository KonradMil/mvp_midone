<template>
    <nav class="top-nav">
        <ul>
            <!-- BEGIN: First Child -->
            <li v-for="(menu, menuKey) in formattedMenu" :key="menuKey">
                <a
                    href="#"
                    @click.prevent="menuChanged(menu)"
                    class="top-menu"
                    :class=" (menu.active == true)? 'top-menu--active' : 'notactive'">
<!--                    @click="linkTo(menu, router)"-->
                    <div class="top-menu__icon">
<!--                        <component :is="menu.icon" />-->
                    </div>
                    <div class="top-menu__title">
                        {{ menu.title }}
<!--                        <ChevronDownIcon v-if="menu.subMenu" class="top-menu__sub-icon" />-->
                    </div>
                </a>
            </li>
            <!-- END: First Child -->
        </ul>
    </nav>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">{{ $t('challengesMain.challenges') }} <span v-if="active != ''"> {{active}}</span></h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button class="btn btn-primary shadow-md mr-2" v-if="user.type == 'investor' && type==='normal'" @click="$router.push({name: 'addChallenge'})">{{ $t('challengesMain.addChallenge') }} </button>
            <div class="dropdown ml-auto sm:ml-0">
                <div class="dropdown-menu w-40">
                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                            <Share2Icon class="w-4 h-4 mr-2"/>
                            {{ $t('global.sharePost') }}
                        </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                            <DownloadIcon class="w-4 h-4 mr-2"/>
                            {{ $t('global.downloadPost') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, ref} from "vue";

export default {
    name: "TopMenuMain",
    emits:[
      'tabChanged'
    ],
    props: {
        user: {
            type: Object
        },
        type: {
            type: String
        }
    },
    setup(props, {emit}) {
        const active = ref('');
        const formattedMenu = ref([
            {
                icon: 'ActivityIcon',
                active: false,
                title: 'Publiczne',
                value: 0
            },
            {
                icon: 'ActivityIcon',
                active: false,
                title: 'Testowe',
                value: 1
            },
            {
                icon: 'ActivityIcon',
                active: false,
                title: 'Pokazowe',
                value: 2
            },
        ]);

        const menuChanged = (val) => {
            active.value = val.title;
            emit('tabChanged', val.value);
        }

        return {
            menuChanged,
            formattedMenu,
            active
        }
    }
}
</script>

<style scoped>

</style>
