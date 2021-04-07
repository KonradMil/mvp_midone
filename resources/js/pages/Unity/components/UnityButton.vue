<template>
    <Tippy
        v-if="tooltip != ''"
        id="meta-title-tab"
        tag="a"
        :content="tooltip"
        href="javascript:;"
        class="w-20 py-2 text-center flex justify-center items-center"
        aria-selected="false"
        @click=""
    >
        <div class="w-16 h-16 flex-none image-fit overflow-hidden cursor-pointer">
            <img class="hover:translate-x-1"
                :alt="alttext"
                :src="path"
            />
        </div>
    </Tippy>
    <div v-if="tooltip == ''" class="w-20 py-2 text-center flex justify-center items-center cursor-pointer hover:scale-50">
        <div class="w-16 h-16 flex-none image-fit overflow-hidden">
            <img class=""
                 :alt="alttext"
                 :src="path"
            />
        </div>
    </div>
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
