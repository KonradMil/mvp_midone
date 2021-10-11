<template>
    <Tippy
        v-if="tooltip != ''"
        id="meta-title-tab"
        tag="a"
        :content="tooltip"
        href="javascript:;"
        class="w-14 py-2 text-center flex justify-center items-center"
        aria-selected="false"
        @click=""
    >
        <div class="w-14 h-14 flex-none image-fit overflow-hidden zoom-in" @click.native="doAction(action)">
            <img class=""
                :alt="alttext"
                :src="path"
            />
        </div>
    </Tippy>
    <div v-if="tooltip == ''" class="w-14 py-2 text-center flex justify-center items-center">
        <div class="w-14 h-14 flex-none image-fit overflow-hidden zoom-in" @click.native="doAction(action)">
            <img class=""
                 :alt="alttext"
                 :src="path"
            />
        </div>
    </div>
</template>

<script>
import {getCurrentInstance} from "vue";

export default {
    name: "UnityButton",
    props: {
        path: String,
        alttext: String,
        tooltip: String,
        action: String,
        position: String
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const doAction = (name) => {

            emitter.emit(props.position, { val: name })
        };

        return {
            doAction
        }
    }
}
</script>

<style scoped>

</style>
