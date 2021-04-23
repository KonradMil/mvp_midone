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
                    <LabelDialog v-if="content == 'label'" v-model:label="label"/>
                    <CommentDialog v-if="content == 'comment'" v-model:comment="comment"/>
                    <LayoutDialog v-if="content == 'layout'" v-model:layout="layout"/>
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
                    <button type="button" class="btn btn-primary w-20" @click="save">
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
import LayoutDialog from "./right-panel/LayoutDialog";

export default {
    name: "RightPanel",
    components: {LayoutDialog, CommentDialog, LabelDialog},
    setup() {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const layout = ref({});
        const label = ref({});
        const comment = ref({});
        const currentTitle = ref('');
        const content = ref('');

        const save = () => {
            if(content.value === 'label') {
                emitter.emit('unityoutgoingaction', { action: 'updateLabel', data:label, json: true });
            } else if(content.value === 'layout') {
                emitter.emit('unityoutgoingaction', { action: 'updateLayout', data:layout, json: true });
            } else if (content.value === 'comment') {
                emitter.emit('unityoutgoingaction', { action: 'updateComment', data:comment, json: true });
            }
        }

        const showPanel = () => {
            cash("#right-panel").modal("show");
        }

        const hidePanel = () => {
            cash("#right-panel").modal("hide");
        }

        emitter.on('UnityLayoutSelected', e => {
            content.value = 'layout';
            layout.value = e.layoutSelected;
            showPanel();
        });

        emitter.on('UnityLabelSelected', e => {
            console.log(e);
            content.value = 'label';
            label.value = e.labelSelected;
            showPanel();
        });

        emitter.on('UnityCommentSelected', e => {
            console.log(e);
            comment.value = e.commentSelected;
            content.value = 'comment';
            showPanel();
        });


        onMounted(() => {
            // showPanel();
        });

        return {
            currentTitle,
            comment,
            layout,
            label,
            content,
            save
        }
    }
}
</script>

<style scoped>

</style>
