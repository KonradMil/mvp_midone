<template>
    <div id="right-panell" class="modal modal-slide-over" tabindex="-1" aria-hidden="true" style="overflow: hidden;">
        <!--        data-backdrop="static"-->
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
                    <button class="btn btn-outline-secondary hidden sm:flex"  data-dismiss="modal">
                      Zamknij
                    </button>
                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body" @mouseenter="lock" @mouseleave="unlock">
                    <LabelDialog v-if="content == 'label'" :key="temp_label_id" v-model:label="label"/>
                    <CommentDialog v-if="content == 'comment'" :key="temp_comment_id" v-model:comment="comment"/>
                    <LayoutDialog v-if="content == 'layout'" :key="temp_layout_id" v-model:layout="layout"/>
                    <LineDialog v-if="content == 'line'" :key="'linia_' + temp_line_id" v-model:modelValue="line"/>
                    <AnimableDialog v-if="content == 'animable'" :key="'animable_id_' + temp_animable_id" v-model:animable="animable"/>
<!--                    <DescriptionDialog v-if="content == 'description'" v-model:object="object" :type="props.type"/>-->
                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div class="modal-footer text-right w-full bottom-0">
<!--                    <button v-if="props.allowedEdit && !(content == 'settings' && type == 'solution') && challenge.stage != 3 && (publishChallenges || publishSolution)" type="button" class="btn btn-primary w-20" @click="save">-->
<!--                        Zapisz-->
<!--                    </button>-->
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
import {computed, getCurrentInstance, onMounted, ref, watch} from "vue";
import cash from "cash-dom";
import LabelDialog from "./../../Unity/components/right-panel/LabelDialog";
import CommentDialog from "./../../Unity/components/right-panel/CommentDialog";
import LayoutDialog from "./../../Unity/components/right-panel/LayoutDialog";
import LineDialog from "./../../Unity/components/right-panel/LineDialog";
import AnimableDialog from "./../../Unity/components/right-panel/AnimableDialog";
// import DescriptionDialog from "./../../Unity/components/right-panel/DescriptionDialog";

export default {
    name: "RightPanel",
    components: {
     LayoutDialog, CommentDialog, LabelDialog, LineDialog, AnimableDialog},
    props: {

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
        const user = ref({});
        const user_teams = ref({});
        const temp_label_id = ref(0);
        const temp_comment_id = ref(0);
        const temp_line_id = ref(0);
        const temp_setting_id = ref(0);
        const temp_layout_id = ref(0);
        const temp_animable_id = ref(0);
        const parts = ref([]);

        const teamsSolution = ref({
            teamsAllowed: '',
        });

        emitter.on('UnityObjectPlaced', e => {
            parts.value = e.partsPlaced;
        });

        const save = () => {
            if(content.value === 'label') {
                comment.value.index = temp_label_id.value;
                emitter.emit('unityoutgoingaction', { action: 'updateLabel', data:label, json: true });
            } else if(content.value === 'layout') {
                emitter.emit('unityoutgoingaction', { action: 'updateLayout', data:layout, json: true });
            } else if (content.value === 'comment') {
                comment.value.index = temp_comment_id.value;
                emitter.emit('unityoutgoingaction', { action: 'updateComment', data:comment, json: true });
            } else if (content.value === 'animable') {
                emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
            }
            hidePanel();
        }


        const lock = () => {
            console.log('LOCK');
            emitter.emit('lockState', {action: 'lock'});
        }

        const unlock = () => {
            console.log('UNLOCK');
            emitter.emit('lockState', {action: 'unlock'});
        }

        const showPanel = () => {
            cash("#right-panell").modal("show");
        }

        const hidePanel = () => {
            cash("#right-panell").modal("hide");
        }

        emitter.on('UnityMenuLabelSelected', e => {
            if(e.menu_selected == 'RemoveLayout') {
                if(content.value == 'layout') {
                    emitter.emit('removeLayout', {id:temp_layout_id});
                } else if (content.value == 'label') {
                    emitter.emit('removeLabel', {id:temp_label_id});
                } else if (content.value == 'comment') {
                    emitter.emit('removeComment', {id:temp_comment_id});
                }
            }
        });

        emitter.on('UnityLineSettings', e => {
            content.value = 'line';
            temp_line_id.value = Math.floor(Math.random() * 99) + 1;
            line.value = e;
            currentTitle.value = 'Ustawienia lini animacji';
            emitter.emit('changeprop', { data:line, json: true });
                showPanel();
        });

        emitter.on('UnityAnimableSettings', e => {

            temp_animable_id.value = e.data.layer_id;
            content.value = 'animable';

            animable.value = e.data;
            currentTitle.value = 'Ustawienia elementu animacji';
            showPanel();
        });

        emitter.on('UnityLayoutSelected', e => {
            content.value = 'layout';
            temp_layout_id.value = e.layoutSelected.index;
            layout.value = e.layoutSelected;

            showPanel();
        });

        emitter.on('UnityLabelSelected', e => {
            temp_label_id.value = e.labelSelected.index;
            content.value = 'label';
            label.value = e.labelSelected;
            currentTitle.value = 'Ustawienia etykiety';
            showPanel();
        });

        emitter.on('UnityCommentSelected', e => {

            temp_comment_id.value = e.commentSelected.index;
            comment.value = e.commentSelected;
            content.value = 'comment';
            currentTitle.value = 'Ustawienia komentarza';
            showPanel();
        });



        onMounted(() => {
            user.value = window.Laravel.user;
            user_teams.value = window.Laravel.teams;
            // allowedEdit.value = props.allowedEdit;
            // showPanel();
            // saveChallengeDetailsRepo('');
            // window.addEventListener('keyup', (val) => {
            //     console.log('KEYUP', val);
            // })
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
            props,
            user,
            user_teams,
            teamsSolution,
            lock,
            unlock,
            temp_label_id,
            temp_comment_id,
            temp_setting_id,
            temp_layout_id,
            temp_animable_id,
            temp_line_id,
            parts
        }
    }
}
</script>

<style scoped>

</style>
