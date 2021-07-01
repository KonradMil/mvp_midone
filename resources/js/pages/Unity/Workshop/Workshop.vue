<template>
    <div>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Marketplace obiektów</h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box mt-5 lg:mt-0">
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a class="flex items-center" href="" @click.prevent="activeTab = 'obiekty'" :class="(activeTab == 'obiekty')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                            Twoje obiekty
                        </a>
                        <a class="flex items-center mt-5" href="" @click.prevent="activeTab = 'marketplace'" :class="(activeTab == 'marketplace')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <BoxIcon class="w-4 h-4 mr-2"/>
                            Marketplace
                        </a>
                        <a class="flex items-center mt-5" href="" @click.prevent="activeTab = 'workshop'" :class="(activeTab == 'workshop')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <LockIcon class="w-4 h-4 mr-2"/>
                            Workshop
                        </a>
                    </div>
                </div>
            </div>
            <!-- END: Profile Menu -->
            <WorkshopPanel :class="(activeTab == 'workshop')? '' : 'hidden'" ref="gameWindow"></WorkshopPanel>
            <Marketplace v-if="activeTab == 'marketplace'"></Marketplace>
            <OwnObjects v-if="activeTab == 'obiekty'"></OwnObjects>
        </div>
    </div>
</template>

<script>
import WorkshopPanel from "./panels/WorkshopPanel";
import Marketplace from "./panels/Marketplace";
import OwnObjects from "./panels/OwnObjects";
import UnityBridgeWorkshop from "./bridge_workshop";

import {getCurrentInstance, onBeforeMount, ref} from "vue";
import UnityBridge from "../bridge";
import dayjs from "dayjs";
import unityActionOutgoing from "../composables/ActionsOutgoing";
export default {
name: "Workshop",
    components: {OwnObjects, Marketplace, WorkshopPanel},
    setup() {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const activeTab = ref('obiekty');
        const bridge = ref();
        const loadedObjectId = ref(null);
        const unityActionOutgoingObject = ref({});
        const gameWindow = ref(null);

        emitter.on('loadObjectWorkshop', (e) => {
            console.log(e);
            console.log(JSON.parse(e.object.save_json));
            handleUnityActionOutgoing({action: 'loadWorkshopObject', data: JSON.parse(e.object.save_json)});
        });

        emitter.on('UnityWorkshopSave', e => {
            axios.post('/api/workshop/models/save', {object: e, id: loadedObjectId})
                .then(response => {
                    if (response.data.success) {

                    } else {
                        // toast.error(response.data.message);
                    }
                })
        });

        emitter.on('singleworkshopobject', e => {
            if(e.action == 'delete') {
                axios.post('/api/workshop/models/delete', {id: e.id})
                    .then(response => {
                        if (response.data.success) {
                            emitter.emit('singleobjectdeleted', {id: e.id});
                        } else {
                            // toast.error(response.data.message);
                        }
                    })
            } else if (e.action == 'edit'){
                emitter.emit('LoadWorkshopItems', e.object);
            } else if (e.action == 'publish'){
                axios.post('/api/workshop/models/publish', {id: e.id})
                    .then(response => {
                        if (response.data.success) {
                            emitter.emit('singleobjectpublished', {id: e.id});
                        } else {

                        }
                    })
            }else if (e.action == 'copy'){
                axios.post('/api/workshop/models/copy', {id: e.id})
                    .then(response => {
                        if (response.data.success) {
                            emitter.emit('singleobjectcopied', {id: e.id});
                        } else {

                        }
                    })
            }
        });

        const handleUnityActionOutgoing = (e) => {
            try {
                unityActionOutgoingObject.value[e.action](e.data);
            } catch (ee) {
                console.log([ee, e]);
            }
        }

        const unlockInput = () => {
            // console.log('UNLOCK');
            handleUnityActionOutgoing({action: "unlockInput", data: ''});
        }

        const initalize = async () => {
            console.log("initializeMe");
            setTimeout(function () {
                unityActionOutgoingObject.value = unityActionOutgoing(gameWindow.value.refs.gameWindow);
                // handleUnityActionOutgoing({action: 'unlockUnityInput', data: ''});

            }, 2000);
            setTimeout(() => {
                handleUnityActionOutgoing({action: 'prefix', data: 'https://platform.dbr77.com/s3'});
                unlockInput();
            }, 5000);
        }

        //RUNS WHEN UNITY IS READY
        emitter.on('onInitialized', e => initalize());

        onBeforeMount(() => {
            //ADDS LISTENERS
            bridge.value = UnityBridgeWorkshop();

        });

        return {
            activeTab,
            initalize,
            unlockInput,
            handleUnityActionOutgoing,
            gameWindow
        }
    }
}
</script>

<style scoped>

</style>
