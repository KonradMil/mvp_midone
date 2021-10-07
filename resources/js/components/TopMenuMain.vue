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
