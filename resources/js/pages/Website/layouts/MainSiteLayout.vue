<template>
    <div class="w-screen">
        <TopMenu></TopMenu>
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
