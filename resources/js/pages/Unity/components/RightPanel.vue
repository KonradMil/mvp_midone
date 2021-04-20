<template>
    <div
        id="right-panel"
        class="modal modal-slide-over"
        data-backdrop="static"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <a data-dismiss="modal" href="javascript:;">
                    <XIcon class="w-8 h-8 text-gray-500" />
                </a>
                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">
                        {{currentTitle}}
                    </h2>
<!--                    <button class="btn btn-outline-secondary hidden sm:flex">-->
<!--                        <FileIcon class="w-4 h-4 mr-2" />-->
<!--                        Download Docs-->
<!--                    </button>-->
                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    <LabelDialog v-if="content == 'label'"/>
                    <CommentDialog v-if="content == 'comment'"/>
                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div
                    class="modal-footer text-right w-full absolute bottom-0"
                >
                    <button
                        type="button"
                        data-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1"
                    >
                        Anuluj
                    </button>
                    <button type="button" class="btn btn-primary w-20">
                        Zapisz
                    </button>
                </div>
                <!-- END: Slide Over Footer -->
            </div>
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";
import cash from "cash-dom";
import LabelDialog from "./right-panel/LabelDialog";
import CommentDialog from "./right-panel/CommentDialog";

export default {
    name: "RightPanel",
    components: {CommentDialog, LabelDialog},
    setup() {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const layouts = ref([]);
        const labels = ref([]);
        const comments = ref([]);
        const currentTitle = ref('');
        const content = ref('');

        const showPanel = () => {
            cash("#right-panel").modal("show");
        }

        const hidePanel = () => {
            cash("#right-panel").modal("hide");
        }

        emitter.on('UnityLayoutSelected', e => {

        });

        emitter.on('UnityLabelSelected', e => {
            console.log(e);
            content.value = 'label';
            showPanel();
        });

        emitter.on('UnityCommentSelected', e => {
            console.log(e);
            content.value = 'comment';
            showPanel();
        });


        onMounted(() => {
            showPanel();
        });

        return {
            currentTitle,
            comments,
            layouts,
            labels,
            content
        }
    }
}
</script>

<style scoped>

</style>
