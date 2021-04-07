<template>
    <Tippy
        id="meta-title-tab"
        tag="a"
        :content="tooltip"
        href="javascript:;"
        class=" py-4 text-center flex justify-center items-center"
        aria-selected="false"
        @click=""
    >
        <div class=" flex-none image-fit overflow-hidden">
            <img class="w-20 p-5 h-20 hover:translate-x-1"
                :alt="alttext"
                :src="path"
            />
        </div>
    </Tippy>
</template>

<script>
export default {
    name: "UnityButton",
    props: {
        path: String,
        alttext: String,
        tooltip: String
    },
    setup() {

    }
}
</script>

<style scoped>

</style>
