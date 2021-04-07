<template>
<Post v-for="(post, index) in posts" :user="user" :post="post" :key="'post_' + index"></Post>
</template>

<script>
import Post from "./Post";
export default {
    name: "Main",
    components: {Post},
    setup() {

    }
}
</script>

<style scoped>

</style>
