<template>
    <div class="dropdown">
        <button
            class="dropdown-toggle"
            aria-expanded="false"
        >
            <div class="w-20 py-2 text-center flex justify-center items-center">
                <div class="w-16 h-16 flex-none image-fit overflow-hidden zoom-in" @click.native="doAction(action)">
                    <img class=""
                         :alt="alttext"
                         :src="path"
                    />
                </div>
            </div>
        </button>
        <div class="dropdown-menu w-40">
            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                <a
                    href=""
                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                >
                    <PrinterIcon class="w-4 h-4 mr-2" /> Print
                </a>
                <a
                    href=""
                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                >
                    <FileTextIcon class="w-4 h-4 mr-2" /> Export to Excel
                </a>
                <a
                    href=""
                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                >
                    <FileTextIcon class="w-4 h-4 mr-2" /> Export to PDF
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
        position: String
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const doAction = (name) => {
            console.log('CLIK CLICK');
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
