<template>
<section id="hero-image" class="h-screen">
    <div class="grid-cols-12 grid gap-6">
        <div class="col-span-6 relative">
            <div class="absolute left-0 top-0 h-screen w-full">
                <img src="/s3/twopointo/images/blobs/homepage_blob_1.svg" class="w-full absolute" style="z-index: 2;"/>
                <img src="/s3/twopointo/images/blobs/homepage_blob_1_1.svg" class="w-full absolute" style="z-index: 0; top: 10px"/>
            </div>

        </div>
        <div class="col-span-6">
            <h1 class="site-main-header mt-24">DBR77</h1>
            <p class="site-small-text">
                Dołącz do społeczności, której celem jest popularyzacja robotyzacji w przemyśle.
            </p>
            <input type="text" class="input-shadow mt-2 w-72" placeholder="Email"/>
        </div>
    </div>
</section>
</template>

<script>
export default {
name: "HomePage"
}
</script>

<style scoped>

</style>
