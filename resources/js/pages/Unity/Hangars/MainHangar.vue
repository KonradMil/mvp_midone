<template>

    <div @contextmenu.prevent="openMenu">
        <Studio hideFooter="true" :src="unity_hangar_path" :width="window_width" :height="window_height" unityLoader="/UnityLoader.js" ref="gameWindow"/>
    </div>
<!--    <BottomPanel  v-if="loaded" :allowedEdit="allowedEdit" :mode="mode" v-model:animationSave="animationSave"></BottomPanel>-->
<!--    <RightButtons  v-if="loaded" :allowedEdit="allowedEdit" :icons="rightIcons" :type="type"></RightButtons>-->
<!--    <RightPanel  :allowedEdit="allowedEdit" :publishChallenges="publishChallenges" :canEditSolution="canEditSolution" @mouseover.native="lockInput" @mouseleave.native="unlockInput" :type="type" :challenge="challenge" :solution="solution"></RightPanel>-->
    <div v-if="!loaded" id="loader">
        <LoadingIcon icon="grid" class="w-8 h-8" />
    </div>
<!--    <VoiceChat :sessionId="sessionid" :owner="owner"></VoiceChat>-->
<!--    <WebRTC width="100%" roomId="roomId"></WebRTC>-->
<!--    <div id="help-modal" class="modal" tabindex="-1" aria-hidden="true">-->
<!--        <div class="modal-dialog modal-xl">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-body p-10 text-center">-->
<!--                    <h3 class="intro-y text-lg font-medium mt-5">Pomoc</h3>-->
<!--                    <div class="grid grid-cols-12 gap-6 mt-5">-->
<!--                        &lt;!&ndash; BEGIN: Profile Menu &ndash;&gt;-->
<!--                        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">-->
<!--                            <div class="intro-y box mt-5 lg:mt-0">-->
<!--                                <div class="p-5 border-t border-gray-200 dark:border-dark-5">-->
<!--                                    <a class="flex items-center"-->
<!--                                       href=""-->
<!--                                       @click.prevent="modelActiveTab = 'klawiszologia'"-->
<!--                                       :class="(modelActiveTab == 'klawiszologia')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">-->
<!--                                        <ActivityIcon class="w-4 h-4 mr-2"/>-->
<!--                                        Klawiszologia-->
<!--                                    </a>-->
<!--                                    <a class="flex items-center mt-5" href=""-->
<!--                                       @click.prevent="modelActiveTab = 'faq'"-->
<!--                                       :class="(modelActiveTab == 'faq')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">-->
<!--                                        <BoxIcon class="w-4 h-4 mr-2"/>-->
<!--                                        FAQ-->
<!--                                    </a>-->
<!--                                    <a class="flex items-center mt-5" href=""-->
<!--                                       @click.prevent="modelActiveTab = 'tutorial'"-->
<!--                                       :class="(modelActiveTab == 'tutorial')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">-->
<!--                                        <SettingsIcon class="w-4 h-4 mr-2"/>-->
<!--                                        Tutorial-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        &lt;!&ndash; END: Profile Menu &ndash;&gt;-->
<!--                        <div class="col-span-9 lg:col-span-9 xxl:col-span-9" v-if="modelActiveTab == 'klawiszologia'">-->
<!--                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">-->
<!--                                <h2 class="font-medium text-base mr-auto"> Klawiszologia</h2>-->
<!--                            </div>-->
<!--                            <div class="grid grid-cols-12 gap-6">-->
<!--                                &lt;!&ndash; BEGIN: Announcement &ndash;&gt;-->
<!--                                <div class="intro-y box col-span-12 xxl:col-span-12">-->
<!--                                    <img src="/s3/images/klawiszologia.jpeg" class="img-fluid cursor-pointer" @click="window.open('/s3/images/klawiszologia.jpeg', '_blank').focus();"/>-->
<!--                                </div>-->
<!--                                &lt;!&ndash; END: Announcement &ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-span-9 lg:col-span-9 xxl:col-span-9" v-if="modelActiveTab == 'faq'">-->
<!--                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">-->
<!--                                <h2 class="font-medium text-base mr-auto">FAQ</h2>-->
<!--                            </div>-->
<!--                            <div class="grid grid-cols-12 gap-6">-->
<!--                                &lt;!&ndash; BEGIN: Announcement &ndash;&gt;-->
<!--                                <div class="intro-y box col-span-12 xxl:col-span-12">-->

<!--                                </div>-->
<!--                                &lt;!&ndash; END: Announcement &ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-span-9 lg:col-span-9 xxl:col-span-9" v-if="modelActiveTab == 'tutorial'">-->
<!--                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">-->
<!--                                <h2 class="font-medium text-base mr-auto">Tutorial</h2>-->
<!--                            </div>-->
<!--                            <div class="grid grid-cols-12 gap-6">-->
<!--                                &lt;!&ndash; BEGIN: Announcement &ndash;&gt;-->
<!--                                <div class="intro-y box col-span-6 xxl:col-span-6">-->
<!--                                    <div class="px-15 py-15">-->
<!--                                        <button class="btn btn-primary" type="button" @click="startTutorial">Rozpocznij tutorial</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                &lt;!&ndash; END: Announcement &ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

</template>

<script>
import Studio from "./Studio";
import {computed, getCurrentInstance, onBeforeMount, onMounted, reactive, ref} from "vue";
import UnityBridge from "./bridge";
import cash from "cash-dom";
import WindowWatcher from "../../../events/WindowWatcher";


const ww = WindowWatcher();

export default {
    name: "MainHangar",
    props: {
        type: String,
        id: Number,
        readOnly: {
            default: false,
            type: Boolean
        },
        publishChallenges: Boolean,
        canEditSolution: Boolean,
        sessionid: String
    },
    components: {Studio},
    setup(props, {emit}) {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        //INTERNAL
        const id = ref(0);
        const type = ref('challenge');
        const mode = ref('');
        const bridge = ref();
        const gameWindow = ref(null);
        const gameLoad = ref({});
        const loaded = ref(false);
        const doubleClick = ref(false);
        const mousePositionY = ref(0);
        const mousePositionX = ref(0);
        const initialLoad = ref({});
        const challenge = ref({});
        const solution = ref({});
        const user = window.Laravel.user;
        const inTeam = ref(false);
        const modelActiveTab = ref('klawiszologia');

        //EXTERNAL
        const unity_hangar_path = window.unity_hangar_path;
        const window_width = ref('100%');
        const window_height = ref(0);
        const rightIcons = ref([]);
        const leftIcons = ref([]);
        const topIcons = ref([]);
        const unityActionOutgoingObject = ref({});
        const currentRadialMenu = ref([]);
        const radialMenuEdit = ref([]);
        const radialMenuAnimation = ref([]);
        const radialMenuLayout = ref([]);
        const animationSave = ref({layers: []});
        const saving = ref(false);
        const sessionid = ref('');
        const owner = ref(false);

        if(props.sessionid === undefined) {
            sessionid.value = Math.random().toString(36).slice(-5);
            owner.value = true;
        } else {
            sessionid.value = props.sessionid;
            owner.value = false;
        }

        window_height.value = window.innerHeight;

        emitter.on('showChallenge', e => {
            challenge.value = e.obj;
            type.value = 'challenge';
        });

        const startTutorial = () => {
            handleUnityActionOutgoing({action: 'launchTutorial', data: ''});
        }

        //RUNS WHEN UNITY IS READY
        emitter.on('onInitialized', e => initalize());

        //HANDLES ALL UNITY ACTIONS
        emitter.on('unityoutgoingaction', e => {
            handleUnityActionOutgoing(e);
        });

        //HANDLES ALL UNITY ACTIONS
        emitter.on('gridsizechange', e => {
            handleUnityActionOutgoing({action: "changeGridSize", data: e.val});
        });

        //HANDLES ALL LAYOUT ACTIONS
        emitter.on('layoutbuttonclick', e => {
            switch (e.val) {
                case "edit":
                    handleUnityActionOutgoing({action: "beginLayoutEdit", data: ''});
                    break;
                case "addlabel":
                    handleUnityActionOutgoing({action: "beginLayoutLabel", data: ''});
                    break;
                case "addlayout":
                    handleUnityActionOutgoing({action: "beginLayoutDraw", data: ''});
                    break;
                case "notatka":
                    handleUnityActionOutgoing({action: "beginLayoutComment", data: ''});
                    break;
            }
        });

        emitter.on('lockState', e => {
            if(e.action == 'lock') {
                lockInput();
            } else {
                unlockInput();
            }
        });

        const lockInput = () => {

            handleUnityActionOutgoing({action: "lockInput", data: ''});
        }

        const unlockInput = () => {

            handleUnityActionOutgoing({action: "unlockInput", data: ''});
        }

        const openMenu = (e) => {
            e.preventDefault();


            if (loaded.value) {
                if (doubleClick.value) {
                    if ((mousePositionX.value > (e.clientX - 10) && mousePositionX.value < (e.clientX + 10)) && (mousePositionY.value > (e.clientY - 10) && mousePositionY.value < (e.clientY + 19))) {
                        let data = JSON.stringify({menu: currentRadialMenu.value});


                        handleUnityActionOutgoing({action: 'showRadialMenu', data: data});
                    } else {
                        doubleClick.value = false;
                    }
                } else {

                    mousePositionX.value = e.clientX;
                    mousePositionY.value = e.clientY;
                    doubleClick.value = true;
                    handleUnityActionOutgoing({action: 'closeRadialMenu', data: ''});
                    setTimeout(function () {
                        doubleClick.value = false;
                    }, 1000);
                }
            }
        }

        const showLeftButtons = computed(() => {
                return false;
        })


        const handleUnityActionOutgoing = (e) => {
            try {
                unityActionOutgoingObject.value[e.action](e.data);
            } catch (ee) {

            }
        }

        const initalize = async () => {

            setTimeout(function () {
                loaded.value = true;
                unityActionOutgoingObject.value = unityActionOutgoing(gameWindow.value);
                handleUnityActionOutgoing({
                    action: 'setSessionId',
                    data: Number(Math.random().toString().substr(3, length) + Date.now()).toString(36)
                });
                // handleUnityActionOutgoing({action: 'setHangarAppearance', data: 1});
                handleUnityActionOutgoing({action: 'unlockUnityInput', data: ''});

                handleUnityActionOutgoing({action: 'prefix', data: window.app_path + '/s3'});
            }, 2000);
            setTimeout(() => {
                unlockInput();
            }, 5000);
        }

        onBeforeMount(() => {
            //ADDS LISTENERS
            bridge.value = UnityBridge();

        });

        emitter.on('updateanimationSave', e => {
            animationSave.value.layers = e.data.layers;
        });



        onMounted(() => {

            //REMOVES PADDING
            cash("body")
                .removeClass("main")
                .removeClass("error-page")
                .addClass("p-0");
            const li = require("../../../json/unity_left_buttons.json");
            leftIcons.value = li.icons;
            const ri = require("../../../json/unity_right_buttons.json");
            rightIcons.value = ri.icons;
            const ti = require("../../../json/unity_top_buttons.json");
            topIcons.value = ti.icons;
            radialMenuAnimation.value = require("../../../json/radial_animation.json");
            radialMenuEdit.value = require("../../../json/radial_edit.json");
            radialMenuLayout.value = require("../../../json/radial_layout.json");
            currentRadialMenu.value = radialMenuEdit.value;
            mode.value = 'edit';
            type.value = props.type;
            id.value = props.id;
        });

        return {
            user,
            challenge,
            solution,
            initialLoad,
            type,
            id,
            animationSave,
            unity_hangar_path,
            window_width,
            window_height,
            gameWindow,
            leftIcons,
            topIcons,
            rightIcons,
            mode,
            inTeam,
            openMenu,
            lockInput,
            unlockInput,
            modelActiveTab,
            startTutorial,
            loaded,
            sessionid,
            owner,
            showLeftButtons
        }
    }
}
</script>
