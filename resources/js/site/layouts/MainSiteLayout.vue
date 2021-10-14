<template>
    <div class="w-screen">
        <TopMenu></TopMenu>
        <div class="content ml-0 pl-0" style="background-color: white;
    border-radius: 0;">
            <router-view/>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>
import TopMenu from "../components/TopMenu";
import Footer from "../components/Footer";
export default {
    name: "MainSiteLayout",
    components: {Footer, TopMenu}
}
</script>

<style scoped>

</style>
