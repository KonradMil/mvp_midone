<template>
    <div id="right-panel" class="modal modal-slide-over" tabindex="-1" aria-hidden="true" style="overflow: hidden;">
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
                    <DescriptionDialog v-if="content == 'description'" v-model:object="object" :type="props.type"/>
<!--                    <MultiplayerDialog v-if="content == 'multiplayer'"></MultiplayerDialog>-->
<!--                    <TeamsDialog v-model:teams_unity="teams_unity" :type="props.type" v-if="(content == 'teams' && allowedEdit && (user_teams.length > 0))"></TeamsDialog>-->
<!--                    <p v-if="(content == 'teams' && allowedEdit && (user_teams.length > 0))">-->
<!--                        Nie możesz edytować zespołów.-->
<!--                    </p>-->
                    <FinancialAnalysisDialog v-if="content == 'financial-analysis'" :solution="solution"></FinancialAnalysisDialog>
                    <FinancialDialog v-if="content == 'financial'" v-model:financial_before="financial_before" v-model:financial_after="financial_after" :type="type"></FinancialDialog>
                    <OperationalAnalysisDialog v-if="content == 'operationalanalysis'" :solution="solution" ></OperationalAnalysisDialog>
                    <OperationDialog v-if="content == 'operational'" ></OperationDialog>
                    <SettingsDialog v-if="content == 'settings'" v-model:technical="technical" :type="type"></SettingsDialog>
                    <EstimatesDialog v-if="content == 'estimates'" :solution="solution" :parts="parts"></EstimatesDialog>
                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div v-if="solution.status === 0" class="modal-footer text-right w-full bottom-0">
                    <button v-if="challenge.stage != 3" type="button" data-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">
                        Anuluj
                    </button>
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
import LabelDialog from "./right-panel/LabelDialog";
import CommentDialog from "./right-panel/CommentDialog";
import LayoutDialog from "./right-panel/LayoutDialog";
import LineDialog from "./right-panel/LineDialog";
import AnimableDialog from "./right-panel/AnimableDialog";
import DescriptionDialog from "./right-panel/DescriptionDialog";
import MultiplayerDialog from "./right-panel/TeamsDialog";
import TeamsDialog from "./right-panel/TeamsDialog";
import FinancialAnalysisDialog from "./right-panel/FinancialAnalysisDialog";
import FinancialDialog from "./right-panel/FinancialDialog";
import OperationalAnalysisDialog from "./right-panel/OperationalAnalysisDialog";
import OperationDialog from "./right-panel/OperationDialog";
import SettingsDialog from "./right-panel/SettingsDialog";
import SaveChallengeDescription from "../../../compositions/SaveChallengeDescription";
import SaveSolutionDescription from "../../../compositions/SaveSolutionDescription";
import SaveChallengeDetails from "../../../compositions/SaveChallengeDetails";
import SaveChallengeFinancials from "../../../compositions/SaveChallengeFinancials";
import SaveSolutionFinancials from "../../../compositions/SaveSolutionFinancials";
import SaveChallengeTeams from "../../../compositions/SaveChallengeTeams";
import SaveSolutionTeams from "../../../compositions/SaveSolutionTeams";
import EstimatesDialog from "./right-panel/EstimatesDialog";

export default {
    name: "RightPanel",
    components: {
        EstimatesDialog,
        SettingsDialog,
        OperationDialog,
        OperationalAnalysisDialog,
        FinancialAnalysisDialog,
        FinancialDialog,
        TeamsDialog,
        MultiplayerDialog,
        DescriptionDialog, LayoutDialog, CommentDialog, LabelDialog, LineDialog, AnimableDialog},
    props: {
        challenge: Object,
        solution: Object,
        type: String,
        allowedEdit: Boolean,
        publishChallenges: Boolean,
        canEditSolution: Boolean,
        isPublishSolution: String
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
            } else if (content.value === 'teams') {
                // emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
                if(props.type==='challenge'){

                    saveChallengeTeamsRepo();
               } else {
                    saveSolutionTeamsRepo();
                }
            } else if (content.value === 'description') {

                if(type.value == 'challenge') {
                    saveChallengeDescriptionRepo({name: props.challenge.name, description: props.challenge.description, id: props.challenge.id});
                } else {
                    saveSolutionDescriptionRepo({name: props.solution.name, description: props.solution.description, id: props.solution.id});
                }
            } else if (content.value === 'multiplayer') {
                emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
            } else if (content.value === 'operational') {
                emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
            } else if (content.value === 'financial') {
                // emitter.emit('rightpanelaction', { action: 'updateAnimable', data:animable.value });
                if(props.type=='solution')
                {
                    saveSolutionFinancialsRepo();
                } else {
                    saveSolutionFinancialsRepo();
                    saveChallengeFinancialsRepo();
                }

            } else if (content.value === 'settings') {
                // emitter.emit('rightpanelaction', {
                //     // action: 'updateAnimable', data:animable.value{
                // });
                saveChallengeDetailsRepo();
            }  else if (content.value === 'estimates') {
                emitter.emit('estimatesave', {

                });
             } else if (content.value === 'line') {


                emitter.emit('rightpanelaction', { action: 'updateLine', data:{layers: line.value}, json: true });
            } else if (content.value === 'financial-analysis') {
                emitter.emit('financialAnalysesSave', {});
            } else if (content.value === 'operationalanalysis') {
                emitter.emit('operationalAnalysesSave', {});
            }
            hidePanel();
        }

        const object = computed(() => {
            if(props.type == 'challenge') {
                return props.challenge;
            } else if(props.type == 'solution') {
                return props.solution;
            } else {

            }
        }, () => {

        });

        const lock = () => {
            console.log('LOCK');
            emitter.emit('lockState', {action: 'lock'});
        }

        const unlock = () => {
            console.log('UNLOCK');
            emitter.emit('lockState', {action: 'unlock'});
        }

        const technical = computed(() => {
            if(props.type=='challenge')
            {
                return props.challenge.technical_details
            }
            else
            {
                return props.solution.challenge.technical_details
            }

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

        const teams_unity = computed(() => {
            if(props.type=='challenge')
            {
                type.value = props.type;
                return props.challenge.teams
            }
            else {
                type.value = props.type;
                return props.solution
            }
        }, () =>{

        });

        const showPanel = () => {
            cash("#right-panel").modal("show");
        }

        const hidePanel = () => {
            cash("#right-panel").modal("hide");
        }

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

        emitter.on('EstimatesDialog', e => {
            content.value = 'estimates';
            currentTitle.value = 'Kosztorys';
            showPanel();
        });

        emitter.on('OperationalAnalysisDialog', e => {
            content.value = 'operationalanalysis';
            currentTitle.value = 'Analiza operacyjna';
            showPanel();
        });
        emitter.on('SettingsDialog', e => {
            content.value = 'settings';
            currentTitle.value = 'Dane techiczne';
            showPanel();
        });
        emitter.on('FinancialAnalysisDialog', e => {
            content.value = 'financial-analysis';
            currentTitle.value = 'Analiza finansowa';
            showPanel();
        });
        emitter.on('FinancialDialog', e => {
            content.value = 'financial';
            currentTitle.value = 'Założenia operacyjne';
            showPanel();
        });
        emitter.on('OperationDialog', e => {

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

        const saveChallengeRepo = async (data) => {

        }

        const saveSolutionDescriptionRepo = async (data) => {
            SaveSolutionDescription(data)
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
        const saveChallengeTeamsRepo = async () => {
            SaveChallengeTeams(teams_unity.value, props.challenge.id);
        }
        const saveSolutionTeamsRepo = async () => {
            SaveSolutionTeams(teamsSolution.value.teamsAllowed, props.solution.id);
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
            teams_unity,
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
