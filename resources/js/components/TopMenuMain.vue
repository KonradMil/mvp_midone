<template>
    <nav class="top-nav">
        <ul>
            <!-- BEGIN: First Child -->
            <li v-for="(menu, menuKey) in formattedMenu" :key="menuKey">
                <a
                    href="javascript:;"
                    class="top-menu"
                    :class="{
              'top-menu--active': menu.active
            }">
<!--                    @click="linkTo(menu, router)"-->
<!--                    <div class="top-menu__icon">-->
<!--                        <component :is="menu.icon" />-->
<!--                    </div>-->
                    <div class="top-menu__title">
                        {{ menu.title }}
<!--                        <ChevronDownIcon v-if="menu.subMenu" class="top-menu__sub-icon" />-->
                    </div>
                </a>
                <!-- BEGIN: Second Child -->
<!--                <ul v-if="menu.subMenu">-->
<!--                    <li v-for="(subMenu, subMenuKey) in menu.subMenu" :key="subMenuKey">-->
<!--                        <a-->
<!--                            href="javascript:;"-->
<!--                            class="top-menu"-->
<!--                        >-->
<!--                            <div class="top-menu__icon">-->
<!--                                <ActivityIcon />-->
<!--                            </div>-->
<!--                            <div class="top-menu__title">-->
<!--                                {{ subMenu.title }}-->
<!--                                <ChevronDownIcon-->
<!--                                    v-if="subMenu.subMenu"-->
<!--                                    class="top-menu__sub-icon"-->
<!--                                />-->
<!--                            </div>-->
<!--                        </a>-->
<!--                        &lt;!&ndash; BEGIN: Third Child &ndash;&gt;-->
<!--                        <ul v-if="subMenu.subMenu">-->
<!--                            <li-->
<!--                                v-for="(lastSubMenu, lastSubMenuKey) in subMenu.subMenu"-->
<!--                                :key="lastSubMenuKey"-->
<!--                            >-->
<!--                                <a-->
<!--                                    href="javascript:;"-->
<!--                                    class="top-menu"-->
<!--                                    @click="linkTo(lastSubMenu, router)"-->
<!--                                >-->
<!--                                    <div class="top-menu__icon">-->
<!--                                        <component :is="'zap-icon'" />-->
<!--                                    </div>-->
<!--                                    <div class="top-menu__title">-->
<!--                                        {{ lastSubMenu.title }}-->
<!--                                    </div>-->
<!--                                </a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                        &lt;!&ndash; END: Third Child &ndash;&gt;-->
<!--                    </li>-->
<!--                </ul>-->
                <!-- END: Second Child -->
            </li>
            <!-- END: First Child -->
        </ul>
    </nav>
</template>

<script>
export default {
    name: "TopMenuMain",
    setup() {
        const formattedMenu = [
            {
                icon: 'ActivityIcon',
                active: false,
                title: 'Publiczne'
            },
            {
                icon: 'ActivityIcon',
                active: false,
                title: 'Testowe'
            },
            {
                icon: 'ActivityIcon',
                active: false,
                title: 'Pokazowe'
            },
        ];

        return {
            formattedMenu
        }
    }
}
</script>

<style scoped>

</style>
