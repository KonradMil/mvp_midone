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
                    <LineDialog v-if="content == 'line'" v-model:line="line"/>
                    <AnimableDialog v-if="content == 'animable'" v-model:animable="animable"/>
                    <DescriptionDialog v-if="content == 'description'" :object="object"/>
                    <MultiplayerDialog v-if="content == 'multiplayer'"></MultiplayerDialog>
                    <TeamsDialog v-if="content == 'teams'"></TeamsDialog>
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
import {computed, getCurrentInstance, onMounted, ref} from "vue";
import cash from "cash-dom";
import LabelDialog from "./right-panel/LabelDialog";
import CommentDialog from "./right-panel/CommentDialog";
import LayoutDialog from "./right-panel/LayoutDialog";
import LineDialog from "./right-panel/LineDialog";
import AnimableDialog from "./right-panel/AnimableDialog";
import DescriptionDialog from "./right-panel/DescriptionDialog";
import MultiplayerDialog from "./right-panel/TeamsDialog";
import TeamsDialog from "./right-panel/TeamsDialog";

export default {
    name: "RightPanel",
    components: {
        TeamsDialog,
        MultiplayerDialog,
        DescriptionDialog, LayoutDialog, CommentDialog, LabelDialog, LineDialog, AnimableDialog},
    props: {
        challenge: Object,
        type: String
    },
    setup(props) {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const layout = ref({});
        const label = ref({});
        const line = ref({});
        const comment = ref({});
        const animable = ref({});
        const currentTitle = ref('');
        const content = ref('');
        const challenge = ref({});
        const type = ref('');

        const save = () => {
            if(content.value === 'label') {
                emitter.emit('unityoutgoingaction', { action: 'updateLabel', data:label, json: true });
            } else if(content.value === 'layout') {
                emitter.emit('unityoutgoingaction', { action: 'updateLayout', data:layout, json: true });
            } else if (content.value === 'comment') {
                emitter.emit('unityoutgoingaction', { action: 'updateComment', data:comment, json: true });
            } else if (content.value === 'animable') {
                emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
            } else if (content.value === 'line') {
                console.log('HERE IMPORTA');
                console.log({layers: line.value});
                emitter.emit('rightpanelaction', { action: 'updateLine', data:{layers: line.value}, json: true });
            }
        }

        const object = computed(() => {
            if(type.value == 'challenge') {
                return props.challenge;
            } else if(type.value == 'solution') {

            }
        });

        const showPanel = () => {
            cash("#right-panel").modal("show");
        }

        const hidePanel = () => {
            cash("#right-panel").modal("hide");
        }

        emitter.on('UnityLineSettings', e => {
            content.value = 'line';
            console.log(e);
            line.value = e;
            currentTitle.value = 'Ustawienia lini animacji';
            emitter.emit('changeprop', { data:line, json: true });
            showPanel();
        });

        emitter.on('UnityAnimableSettings', e => {
            content.value = 'animable';
            console.log(e);
            animable.value = e.data;
            currentTitle.value = 'Ustawienia elementu animacji';
            showPanel();
        });

        emitter.on('UnityLayoutSelected', e => {
            content.value = 'layout';
            layout.value = e.layoutSelected;

            showPanel();
        });

        emitter.on('UnityLabelSelected', e => {
            console.log(e);
            content.value = 'label';
            label.value = e.labelSelected;
            currentTitle.value = 'Ustawienia etykiety';
            showPanel();
        });

        emitter.on('UnityCommentSelected', e => {
            console.log(e);
            comment.value = e.commentSelected;
            content.value = 'comment';
            currentTitle.value = 'Ustawienia komentarza';
            showPanel();
        });

        emitter.on('TeamsDialog', e => {
            content.value = 'teams';
            currentTitle.value = 'Zespoły';
            showPanel();
        });

        emitter.on('MultiplayerDialog', e => {
            content.value = 'multiplayer';
            currentTitle.value = 'Współpraca w czasie rzeczywistym';
            showPanel();
        });

        emitter.on('DescriptionDialog', e => {
            content.value = 'description';
            currentTitle.value = 'Ustawienia podstawowe';
            showPanel();
        });

        emitter.on('OperationalAnalysisDialog', e => {

        });
        emitter.on('OperationDialog', e => {

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
            save,
            line,
            animable,
            challenge,
            type,
            object
        }
    }
}
</script>

<style scoped>

</style>
