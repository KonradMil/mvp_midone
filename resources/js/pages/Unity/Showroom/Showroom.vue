<template>
    <TopButtons v-if="loaded" :allowedEdit="false" :icons="topIcons" :canEditSolution="true"></TopButtons>
    <div>
        <StudioLite hideFooter="true" :src="unity_path" :width="window_width" :height="window_height" unityLoader="/UnityLoader.js" ref="gameWindow"/>
    </div>
    <div v-if="!loaded" id="loader">
        <LoadingIcon icon="grid" class="w-8 h-8"/>
    </div>
    <Modal :show="show" @closed="">
<!--      MODAL CONTENT-->
        <FanucAnalysisModal></FanucAnalysisModal>
        <FanucDownload></FanucDownload>
        <FanucBusinessCase></FanucBusinessCase>
<!--      MODAL CONTENT END-->
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">

                <button class="btn btn-primary shadow-md mr-2" @click="show = false;">Zamknij</button>
            </div>
        </div>
    </Modal>
</template>

<script>
import StudioLite from "./StudioLite";
import {onBeforeMount, onMounted, reactive, ref} from "vue";
import UnityBridge from "./bridge";
import cash from "cash-dom";
import WindowWatcher from "../../../events/WindowWatcher";
import unityActionOutgoing from "../composables/ActionsOutgoing";
import TopButtons from "./../components/TopButtons";
import {useToast} from "vue-toastification";
import useEmitter from "../../../composables/useEmitter";
import Modal from "../../../components/Modal";
import FanucAnalysisModal from "./CustomComponents/FanucAnalysisModal";
import FanucDownload from "./CustomComponents/FanucDownload";
import FanucBusinessCase from "./CustomComponents/FanucBusinessCase";

const ww = WindowWatcher();

export default {
    name: "Showroom",
    props: {
        organization: String,
        readOnly: {
            default: true,
            type: Boolean
        },
        sessionid: String
    },
    components: {
        FanucBusinessCase,
        FanucDownload,
        StudioLite, TopButtons, Modal, FanucAnalysisModal
    },
    setup(props, {emit}) {
        //GLOBAL
        const emitter = useEmitter();
        //INTERNAL
        const id = ref(0);
        const type = ref('challenge');
        const mode = ref('');
        const bridge = ref();
        const freeSave = ref({});
        const gameWindow = ref(null);
        const loaded = ref(false);
        const initialLoad = ref({});
        const user = window.Laravel.user;
        const gameLoad = ref({});

        //EXTERNAL
        const unity_path = window.unity_path;
        const window_width = ref('100%');
        const window_height = ref(0);
        const topIcons = ref([]);
        const unityActionOutgoingObject = ref({});
        const animationSave = ref({layers: []});
        const sessionid = ref('');
        const owner = ref(false);
        const saving = ref(false);
        const toast = useToast();
        const show = ref(false);
        const carousel_menu = ref({
            "elements": [{
                "id": 0,
                "element_name": "Roboty i maszyny",
                "element_descreption": "Krótki opis",
                "method": "models",
                "source": window.location.origin + "/s3/fanuc/robot2.png",
                "use_image": true
            }, {
                "id": 1,
                "element_name": "Strefa business case",
                "element_descreption": "Krótki opis",
                "method": "business",
                "source": window.location.origin + "/s3/fanuc/strefa_busines_case2.png",
                "use_image": true
            }, {
                "id": 2,
                "element_name": "Strefa analiz",
                "element_descreption": "Krótki opis",
                "method": "analysis",
                "source": window.location.origin + "/s3/fanuc/strefa_analizy2.png",
                "use_image": true
            }, {
                "id": 3,
                "element_name": "Strefa wiedzy",
                "element_descreption": "Krótki opis",
                "method": "knowledge",
                "source": window.location.origin + "/s3/fanuc/strefa_wiedzy2.png",
                "use_image": true
            }, {
                "id": 4,
                "element_name": "Strefa zastosowania",
                "element_descreption": "Krótki opis",
                "method": "zastosowania",
                "source": window.location.origin + "/s3/fanuc/strefa zastosowaš2.png",
                "use_image": true
            },
                {
                    "id": 0,
                    "element_name": "Do pobrania",
                    "element_descreption": "Krótki opis",
                    "method": "download",
                    "source": window.location.origin + "/s3/fanuc/download2.png",
                    "use_image": true
                }],
            "setting": {
                "appear_duration": 1.0,
                "animation_speed": 5.0,
                "radius": 2.5,
                "selected_element_size": 0.20000000298023225,
                "default_element_size": 0.07000000029802323,
                "selected_element_alpha": 1.0,
                "default_element_alpha": 0.5,
                "title_aligment": 257,
                "title_font": 39.0,
                "title_alpha": 1.0,
                "title_position": {
                    "x": 0.05000000074505806,
                    "y": 0.05000000074505806
                },
                "title_start_pos": {
                    "x": 0.07000000029802323,
                    "y": 0.07000000029802323
                },
                "subtitle_aligment": 258,
                "subtitle_font": 15.0,
                "subtitle_alpha": 0.800000011920929,
                "subtitle_position": {
                    "x": 0.0,
                    "y": 0.1599999964237213
                },
                "subtitle_start_pos": {
                    "x": 0.0,
                    "y": 0.16500000655651093
                },
                "bar_alpha": 0.30000001192092898,
                "bar_size": {
                    "x": 0.8999999761581421,
                    "y": 0.004999999888241291,
                    "z": 0.0
                },
                "bar_position": {
                    "x": 0.5,
                    "y": 0.14000000059604646
                },
                "item_animation_position": {
                    "x": 0.0,
                    "y": 0.0,
                    "z": 0.0
                },
                "menu_camera_offset": {
                    "x": 5.0,
                    "y": -0.20000000298023225
                },
                "button_text": "Wybierz",
                "button_position": {
                    "x": 0.5,
                    "y": 0.05000000074505806
                },
                "button_size": {
                    "x": 200.0,
                    "y": 40.0
                },
                "button_font_size": 21.0
            }
        });

        //ALL EVENTS
        emitter.on('*', (type, e) => {
            console.log('*', [type, e]);
            switch (type) {
                case 'unityoutgoingaction':
                    handleUnityActionOutgoing(e);
                    break;
                case 'UnityRoundMenuPicked':
                    console.log('EEE', e);
                    switch (e.round_menu_picked.method) {
                        case 'models':
                            handleUnityActionOutgoing({action: 'FocusOnPoint', data: {position: {x:24, y:8.5, z:15}, rotation: {x: 20, y: -33, z: 0}}});
                            break;
                        case 'business':
                            show.value = true;
                            break;
                        case 'analysis':
                            handleUnityActionOutgoing({action: 'FocusOnPoint', data: {position: {x: -3.4, y:8.55, z:-29}, rotation: {x: 24, y: 0, z: 0}}});
                            break;
                        case 'knowledge':
                            show.value = true;
                            break;
                        case 'zastosowania':
                            show.value = true;
                            break;
                        case 'download':
                            show.value = true;
                            break;
                    }
                    break;
                case 'SceneLoaded':
                    loadHangar();
                    break;
                case 'UnityPartPresentation':

                    handlePartPresentation(e.partsPresentation.model_name);
                    break;
                case 'lockState':
                    if (e.action == 'lock') {
                        lockInput();
                    } else {
                        unlockInput();
                    }
                    break;
                case 'topbuttonclick':
                    console.log('aaa', e.val);
                    switch (e.val) {
                        case 'fullscreen':
                            gameWindow.value.setFullscreen();
                            break;
                        case 'logout':
                            window.location.href = window.app_path + '/playground/saves';
                            break;
                        case 'orto':
                            handleUnityActionOutgoing({action: 'ChangeCamera', data: 2});
                            break;
                        case 'fpv':
                            handleUnityActionOutgoing({action: 'ChangeCamera', data: 3});
                            break;
                        case 'topdown':
                            handleUnityActionOutgoing({action: 'ChangeCamera', data: 1});
                            break;
                        case 'standard':
                            handleUnityActionOutgoing({action: 'ChangeCamera', data: 0});
                            break;
                        case 'help':
                            cash("#help-modal").modal("show");
                            break;
                    }
                    break;
                case 'onInitialized':
                    initalize()
                    break;
            }
        });

        const lockInput = () => {
            handleUnityActionOutgoing({action: "lockInput", data: ''});
        }

        const unlockInput = () => {
            handleUnityActionOutgoing({action: "unlockInput", data: ''});
        }

        const loadHangar = () => {
            JSON.parse(freeSave.value.custom_functions).forEach((val) => {
                console.log('VAL', val);
                handleUnityActionOutgoing({
                    action: val.action,
                    data: val.data
                });
            })

            setTimeout(() => {
                handleUnityActionOutgoing({action: 'ShowRoundMenu', data: carousel_menu.value});
            }, 2000);
        }

        const getRoboData = () => {
            axios.get('/api/showroom/' + props.organization + '/data')
                .then(response => {
                    console.log('RESP', response);
                    freeSave.value = response.data.showroom;
                    initialLoad.value = response.data.showroom.challenge.save_json;
                    animationSave.value = response.data.showroom.challenge.save_json.animation_layers;

                    window.unityLoad = response.data.showroom.challenge.save_json;

                    handleUnityActionOutgoing({
                        action: 'loadStructure',
                        data: response.data.showroom.challenge.save_json
                    });
                })
        }

        const handleUnityActionOutgoing = (e) => {
            try {
                unityActionOutgoingObject.value[e.action](e.data);
            } catch (ee) {

            }
        }

        const initalize = async () => {
            if (props.sessionid === undefined) {
                sessionid.value = Math.random().toString(36).slice(-5);
                owner.value = true;
            } else {
                sessionid.value = props.sessionid;
                owner.value = false;
            }
            window_height.value = window.innerHeight;

            setTimeout(function () {
                loaded.value = true;
                unityActionOutgoingObject.value = unityActionOutgoing(gameWindow.value);
                handleUnityActionOutgoing({
                    action: 'setSessionId',
                    data: Number(Math.random().toString().substr(3, length) + Date.now()).toString(36)
                });

                handleUnityActionOutgoing({action: 'unlockUnityInput', data: ''});

                handleUnityActionOutgoing({action: 'prefix', data: window.app_path + '/s3/'});
                getRoboData();
            }, 2000);
            setTimeout(() => {
                unlockInput();
            }, 5000);
        }

        const handlePartPresentation = (val) => {
            console.log('PART0', val);
            axios.get('/api/showroom/part?part=' + val)
                .then(response => {
                    console.log('RESP2', response);
                    console.log('RESP21', response.data);

                    let options = [];

                    if (response.data.model !== undefined && response.data.model !== null) {

                        if (response.data.model.axis !== undefined || response.data.model.axis !== "") {
                            options.push({
                                name: 'Osie',
                                value: response.data.model.axis  || 'mm',
                                type: '',
                                image_url: window.location.origin + '/s3/fanuc/axis.jpeg'
                            });
                        }
                        if (response.data.model.range !== undefined) {
                            options.push({
                                name: 'Zasięg',
                                value: response.data.model.max_range_mm + 'mm' || 'mm',
                                type: '',
                                image_url: window.location.origin + '/s3/fanuc/metr.jpeg'
                            });
                        }
                        if (response.data.model.repetity !== undefined) {
                            options.push({
                                name: 'Powtarzalność',
                                value: response.data.model.repetity + 'mm' || 'mm',
                                type: '',
                                image_url: window.location.origin + '/s3/fanuc/powtarzalnosc.jpeg'
                            });
                        }
                        if (response.data.model.load !== undefined) {
                            options.push({
                                name: 'Udźwig',
                                value: response.data.model.max_load_kg + 'kg' || 'kg',
                                type: '',
                                image_url: window.location.origin + '/s3/fanuc/kg.jpeg'
                            });
                        }
                    }

                    console.log('OPTIONS', {action: 'ReceiveVisualInfo', data: {
                            documentation_url: response.data.model.tech_sheet || '',
                            model_name: response.data.model.name,
                            model_id: response.data.model.id,
                            focus_distance: parseInt(response.data.model.cooperation),
                            options,
                        }});

                    handleUnityActionOutgoing({action: 'ReceiveVisualInfo', data: {
                            documentation_url: response.data.model.tech_sheet,
                            model_name: response.data.model.name,
                            model_id: response.data.model.id,
                            focus_distance: parseInt(response.data.model.cooperation),
                            options,
                        }});
                })
        }

        onBeforeMount(() => {
            //ADDS LISTENERS
            bridge.value = UnityBridge();
        });

        onMounted(() => {
            //REMOVES PADDING
            cash("body")
                .removeClass("main")
                .removeClass("error-page")
                .addClass("p-0");

            const ti = require("../../../json/unity_top_buttons.json");
            topIcons.value = ti.icons;
            mode.value = 'edit';
        });

        return {
            user,
            initialLoad,
            type,
            id,
            animationSave,
            unity_path,
            window_width,
            window_height,
            gameWindow,
            topIcons,
            mode,
            lockInput,
            unlockInput,
            loaded,
            sessionid,
            owner,
            unityActionOutgoingObject,
            saving,
            freeSave,
            show
        }
    }
}
</script>
