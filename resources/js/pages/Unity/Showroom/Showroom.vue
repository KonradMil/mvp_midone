<template>
    <TopButtons v-if="loaded" :allowedEdit="false" :icons="topIcons" :canEditSolution="true"></TopButtons>
    <div>
        <StudioLite hideFooter="true" :src="unity_path" :width="window_width" :height="window_height" unityLoader="/UnityLoader.js" ref="gameWindow"/>
    </div>
    <div v-if="!loaded" id="loader">
        <LoadingIcon icon="grid" class="w-8 h-8"/>
    </div>
    <Modal :show="show" @closed="">
<!--        <h3 class="intro-y text-lg font-medium mt-5">{{ $t('teams.addMember') }}</h3>-->
        <div class="intro-y box p-5 mt-12 sm:mt-5">

        </div>
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
        StudioLite, TopButtons, Modal
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

        //ALL EVENTS
        emitter.on('*', (type, e) => {
            console.log('*', [type, e]);
            switch (type) {
                case 'unityoutgoingaction':
                    handleUnityActionOutgoing(e);
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
                    setTimeout(() => {
                        try {
                            JSON.parse(response.data.showroom.custom_functions).forEach((val) => {
                                console.log('VAL', val);
                                handleUnityActionOutgoing({
                                    action: val.action,
                                    data: val.data
                                });
                            })
                        }catch (e) {
                            console.log('IMP RESP', response.data.showroom.custom_functions)
                            console.log(e);
                        }
                    }, 55000);

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

                handleUnityActionOutgoing({action: 'prefix', data: window.app_path + 's3'});
                getRoboData();
            }, 2000);
            setTimeout(() => {
                unlockInput();
            }, 5000);
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
