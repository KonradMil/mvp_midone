<template>
    <nav class="top-nav">
        <ul>
            <!-- BEGIN: First Child -->
            <li v-for="(menu, menuKey) in formattedMenu" :key="menuKey">
                <a
                    href="#"
                    @click.prevent="menuChanged(menu.value)"
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
import {getCurrentInstance, ref} from "vue";

export default {
    name: "TopMenuMain",
    emits:[
      'tabChanged'
    ],
    setup(props, {emit}) {

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
            console.log('val',val);
            emit('tabChanged', val);
        }

        return {
            menuChanged,
            formattedMenu
        }
    }
}
</script>

<style scoped>

</style>
