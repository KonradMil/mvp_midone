<template>
    <div>
        <MobileMenu/>
        <div class="flex">
            <!-- BEGIN: Side Menu -->
            <nav class="side-nav">
                <!--         BEGIN: Logo-->
                <div class="flex-row w-full items-center">
                    <router-link :to="{ name: 'dashboard' }" tag="a" v-if="user.type != 'robochallenge'" class="intro-x flex items-center  pt-4 px-12">
                        <img alt="DBR77 Platforma Robotów " class="w-full" src="/images/dbr_logo_white_notagline_platform.svg"/>
                    </router-link>
                    <div v-else class="intro-x flex items-center  pt-4 px-12">
                        <img alt="DBR77 Platforma Robotów " class="w-full" src="/images/dbr_logo_white_notagline_platform.svg"/>
                    </div>
                </div>
                <!--         END: Logo-->
                <div class="side-nav__devider my-6"></div>
                <ul>
                    <!-- BEGIN: First Child -->
                    <template v-for="(menu, menuKey) in formattedMenu" v-if="user.type != 'robochallenge'">
                        <li v-if="menu == 'devider'" :key="menu + menuKey" class="side-nav__devider my-6">
                        </li>
                        <li v-else :key="menu + menuKey" v-if="menu.admin == undefined || (user.role == 'admin')">
                            <SideMenuTooltip tag="a" v-if="user.role != 'investor' && menu.pageName != 'solutions' && !(menu.title == 'Rozwiązania' && user.type == 'investor')" :content="menu.title" href="javascript:;" class="side-menu" :class="{'side-menu--active': menu.active,'side-menu--open': menu.activeDropdown}" @click="linkTo(menu, router)">
                                <div class="side-menu__icon">
                                    <component :is="menu.icon"/>
                                </div>
                                <div class="side-menu__title">
                                    {{ $t('menu.' + menu.title) }}
                                    <div v-if="menu.subMenu" class="side-menu__sub-icon" :class="{ 'transform rotate-180': menu.activeDropdown }">
                                        <ChevronDownIcon/>
                                    </div>
                                </div>
                            </SideMenuTooltip>
                            <!-- BEGIN: Second Child -->
                            <transition @enter="enter" @leave="leave">
                                <ul v-if="menu.subMenu && menu.activeDropdown">
                                    <li v-for="(subMenu, subMenuKey) in menu.subMenu" :key="subMenuKey">
                                        <SideMenuTooltip v-if="!(subMenu.pageName == 'challengesArchive' && user.type == 'integrator') && !((subMenu.pageName == 'solutionsArchive' && subMenu.pageName == 'solutionsAll') && user.type == 'investor')" tag="a" :content="subMenu.title" href="javascript:;" class="side-menu" :class="{ 'side-menu--active': subMenu.active }" @click="linkTo(subMenu, router)">
                                            <div class="side-menu__icon">
                                                <ActivityIcon/>
                                            </div>
                                            <div class="side-menu__title">
                                                {{ $t('subMenu.' + subMenu.title) }}
                                                <div v-if="subMenu.subMenu" class="side-menu__sub-icon" :class="{ 'transform rotate-180': subMenu.activeDropdown}">
                                                    <ChevronDownIcon/>
                                                </div>
                                            </div>
                                        </SideMenuTooltip>
                                        <!-- BEGIN: Third Child -->
                                        <transition @enter="enter" @leave="leave">
                                            <ul v-if="subMenu.subMenu && subMenu.activeDropdown">
                                                <li v-for="(lastSubMenu, lastSubMenuKey) in subMenu.subMenu" :key="lastSubMenuKey">
                                                    <SideMenuTooltip tag="a" :content="lastSubMenu.title" href="javascript:;" class="side-menu" :class="{ 'side-menu--active': lastSubMenu.active }" @click="linkTo(lastSubMenu, router)">
                                                        <div class="side-menu__icon">
                                                            <ZapIcon/>
                                                        </div>
                                                        <div class="side-menu__title">
                                                            {{ lastSubMenu.title }}
                                                        </div>
                                                    </SideMenuTooltip>
                                                </li>
                                            </ul>
                                        </transition>
                                        <!-- END: Third Child -->
                                    </li>
                                </ul>
                            </transition>
                            <!-- END: Second Child -->
                        </li>
                    </template>
                    <template v-else>
                        <li :key="'robo'">
                            <SideMenuTooltip tag="a" :content="'Konkurs Robochallenge'" href="javascript:;" class="side-menu" @click="$router.push({name: 'studio-playground-saves'})">
                                <div class="side-menu__icon">
                                    <component :is="'HomeIcon'"/>
                                </div>
                                <div class="side-menu__title">
                                    Konkurs Robochallenge
                                </div>
                            </SideMenuTooltip>
                        </li>
                        <li :key="'community'">
                            <SideMenuTooltip tag="a" :content="'Społeczność'" href="javascript:;" class="side-menu" @click="goTo('https://community.dbr77.com')">
                                <div class="side-menu__icon">
                                    <component :is="'HomeIcon'"/>
                                </div>
                                <div class="side-menu__title">
                                   Społeczność
                                </div>
                            </SideMenuTooltip>
                        </li>
                    </template>
                    <!-- END: First Child -->
                </ul>
            </nav>
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div class="content">
                <TopBar/>
                <router-view/>
            </div>
            <!-- END: Content -->
        </div>
    </div>
</template>

<script>
import {defineComponent, computed, onMounted, ref, watch} from "vue";
import {useRoute, useRouter} from "vue-router";
import {useStore} from "../../store";
import {helper as $h} from "../../utils/helper";
import TopBar from "../../components/top-bar/Main.vue";
import MobileMenu from "../../components/mobile-menu/Main.vue";
import DarkModeSwitcher from "../../components/dark-mode-switcher/Main.vue";
import SideMenuTooltip from "../../components/side-menu-tooltip/Main.vue";
import {linkTo, nestedMenu, enter, leave} from "./index";

export default defineComponent({
    components: {
        TopBar,
        MobileMenu,
        SideMenuTooltip
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            return next({path: '/login'});
        }
        next();
    },
    setup() {
        const route = useRoute();
        const router = useRouter();
        const store = useStore();
        const user = ref({});
        const menu = ref([]);
        const formattedMenu = ref([]);
        const sideMenu = computed(() =>
            nestedMenu(menu.value.menu, route)
        );

        const goTo = (url) => {
            window.open(url, '_blank').focus();
        }

        watch(
            computed(() => route.path),
            () => {
                formattedMenu.value = $h.toRaw(sideMenu.value);
            }
        );

        onMounted(() => {
            if (window.Laravel.user) {
                user.value = window.Laravel.user;

                if(user.value.type == 'admin') {
                    menu.value = require('../../json/admin_menu.json');
                } else if (user.value.type == 'saas') {
                    menu.value = require('../../json/services_menu.json');
                } else {
                    menu.value = require('../../json/main_menu.json');
                }
            }

            cash("body")
                .removeClass("error-page")
                .removeClass("login")
                .removeClass("fanuc-bg")
                .removeClass("saas-bg")
                .addClass("main");

            formattedMenu.value = $h.toRaw(sideMenu.value);
        });

        return {
            formattedMenu,
            router,
            linkTo,
            enter,
            leave,
            user,
            goTo
        };
    }
});
</script>
