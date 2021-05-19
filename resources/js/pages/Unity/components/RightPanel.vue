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
                    <LineDialog v-if="content == 'line'" v-model:modelValue="line"/>
                    <AnimableDialog v-if="content == 'animable'" v-model:animable="animable"/>
                    <DescriptionDialog v-if="content == 'description'" v-model:object="object"/>
<!--                    <MultiplayerDialog v-if="content == 'multiplayer'"></MultiplayerDialog>-->
                    <TeamsDialog v-if="content == 'teams'"></TeamsDialog>
                    <FinancialAnalysisDialog v-if="content == 'financial'" v-model:financial_before="financial_before" v-model:financial_after="financial_after" :type="type"></FinancialAnalysisDialog>
                    <OperationalAnalysisDialog v-if="content == 'operationalanalysis'"></OperationalAnalysisDialog>
                    <OperationDialog v-if="content == 'operational'" ></OperationDialog>
                    <SettingsDialog v-if="content == 'settings'" v-model:technical="technical" ></SettingsDialog>
                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div
                    class="modal-footer text-right w-full bottom-0"
                >
                    <button
                        type="button"
                        data-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1"
                    >
                        Anuluj
                    </button>
                    <button v-if="allowedEdit" type="button" class="btn btn-primary w-20" @click="save">
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
import LabelDialog from "./right-panel/LabelDialog";
import CommentDialog from "./right-panel/CommentDialog";
import LayoutDialog from "./right-panel/LayoutDialog";
import LineDialog from "./right-panel/LineDialog";
import AnimableDialog from "./right-panel/AnimableDialog";
import DescriptionDialog from "./right-panel/DescriptionDialog";
import MultiplayerDialog from "./right-panel/TeamsDialog";
import TeamsDialog from "./right-panel/TeamsDialog";
import FinancialAnalysisDialog from "./right-panel/FinancialAnalysisDialog";
import OperationalAnalysisDialog from "./right-panel/OperationalAnalysisDialog";
import OperationDialog from "./right-panel/OperationDialog";
import SettingsDialog from "./right-panel/SettingsDialog";
import SaveChallengeDescription from "../../../compositions/SaveChallengeDescription";
import SaveChallengeDetails from "../../../compositions/SaveChallengeDetails";
import SaveChallengeFinancials from "../../../compositions/SaveChallengeFinancials";
import SaveSolutionFinancials from "../../../compositions/SaveSolutionFinancials";

export default {
    name: "RightPanel",
    components: {
        SettingsDialog,
        OperationDialog,
        OperationalAnalysisDialog,
        FinancialAnalysisDialog,
        TeamsDialog,
        MultiplayerDialog,
        DescriptionDialog, LayoutDialog, CommentDialog, LabelDialog, LineDialog, AnimableDialog},
    props: {
        challenge: Object,
        solution: Object,
        type: String,
        allowedEdit: Object
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
            } else if (content.value === 'teams') {
                emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
            } else if (content.value === 'description') {
                console.log('HEREE');
                saveChallengeDescriptionRepo({name: props.challenge.name, description: props.challenge.description, id: props.challenge.id});
            } else if (content.value === 'multiplayer') {
                emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
            } else if (content.value === 'operational') {
                emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
            } else if (content.value === 'financial') {
                // emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
                saveChallengeFinancialsRepo();
                saveSolutionFinancialsRepo();
            } else if (content.value === 'settings') {
                // emitter.emit('rightpanelaction', {
                //     // action: 'updateAnimable', data:animable.value{
                // });
                saveChallengeDetailsRepo();
            } else if (content.value === 'line') {
                console.log('HERE IMPORTA');
                console.log({layers: line.value});
                emitter.emit('rightpanelaction', { action: 'updateLine', data:{layers: line.value}, json: true });
            }
            hidePanel();
        }

        const object = computed(() => {
            if(props.type == 'challenge') {
                return props.challenge;
            } else if(props.type == 'solution') {
                return props.solution;
            } else {
                console.log(type.value)
            }
        }, () => {

        });

        const technical = computed(() => {
            return props.challenge.technical_details
        }, () => {

        });

        const financial_before = computed(() => {
            if(props.type=='challenge')
            {
                type.value = props.type;
                return props.challenge.financial_before
            }
            else {
                return props.solution.challenge.financial_before
            }
        }, () => {

        });
        const financial_after = computed(() => {
            if(props.type=='solution')
            {
                type.value = props.type;
                return props.solution.financial_after
            }
        }, () => {

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
        emitter.on('SettingsDialog', e => {
            content.value = 'settings';
            currentTitle.value = 'Dane techiczne';
            showPanel();
        });
        emitter.on('FinancialAnalysisDialog', e => {
            content.value = 'financial';
            currentTitle.value = 'Założenia operacyjne';
            showPanel();
        });
        emitter.on('OperationDialog', e => {

        });

        onMounted(() => {
            allowedEdit.value = props.allowedEdit;
            // showPanel();
            // saveChallengeDetailsRepo('');
        });

        const saveChallengeRepo = async (data) => {

        }
        const saveChallengeDescriptionRepo = async (data) => {
            SaveChallengeDescription(data)
    }
        const saveChallengeDetailsRepo = async () => {
            SaveChallengeDetails(technical.value, technical.value.id);
        }
        const saveChallengeFinancialsRepo = async () => {
            SaveChallengeFinancials(financial_before.value, financial_before.value.id);
        }
        const saveSolutionFinancialsRepo = async () => {
            if(financial_after.value.id != undefined) {
                SaveSolutionFinancials(financial_after.value, financial_after.value.id);
            }
        }

        const addTeam = () => {

        };

        const removeTeam = () => {

        };

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
            object,
            technical,
            financial_before,
            financial_after,
        }
    }
}
</script>

<style scoped>

</style>
