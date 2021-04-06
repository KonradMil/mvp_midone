<template>
    <Tippy
        id="meta-title-tab"
        tag="a"
        :content="tooltip"
        href="javascript:;"
        class="w-full sm:w-40 py-4 text-center flex justify-center items-center"
        aria-selected="false"
        @click=""
    >
        <div class="w-10 h-10 flex-none image-fit overflow-hidden">
            <img
                :alt="alt_text"
                :src="path"
            />
        </div>
    </Tippy>
</template>

<script>
export default {
    name: "UnityButton",
    setup() {

    }
}
</script>

<style scoped>

</style>
