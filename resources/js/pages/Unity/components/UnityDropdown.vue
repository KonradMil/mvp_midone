<template>
    <div class="dropdown">

            <button class="dropdown-toggle" aria-expanded="false">
                <Tippy
                    v-if="tooltip != ''"
                    id="meta-title-tab"
                    tag="a"
                    :content="tooltip"
                    href="javascript:;"
                    class="w-14 py-2 text-center"
                    aria-selected="false"
                    @click=""
                >
                <div class="w-20 py-2 text-center flex justify-center items-center">
                    <div class="w-14 h-14 flex-none image-fit overflow-hidden zoom-in">
                        <img class=""
                             :alt="alttext"
                             :src="path"
                        />
                    </div>
                </div>
        </Tippy>
            </button>

        <div class="dropdown-menu w-75">
            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                <a  @click.prevent="doAction(option.action)"
                    v-for="(option, index) in options"
                    href=""
                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                >
                    {{option.name}}
                </a>
            </div>
        </div>
    </div>

</template>

<script>
import {getCurrentInstance} from "vue";

export default {
    name: "UnityDropdown",
    props: {
        path: String,
        alttext: String,
        tooltip: String,
        action: String,
        position: String,
        options: Array
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
