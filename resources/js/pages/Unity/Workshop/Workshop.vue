<template>
    <div>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Marketplace obiektów</h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 md:col-span-2 flex lg:block flex-col-reverse">
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
            <!--            <WorkshopPanel :class="(activeTab == 'workshop')? '' : 'hidden'" ref="gameWindow"></WorkshopPanel>-->
<!--            <StudioWorkshop hideFooter="true" :src="''" :width="window_width" :height="window_height" :loader="loader" unityLoader="/UnityLoader.js" :class="(activeTab == 'workshop')? '' : 'hidden'" ref="gameWindow"></StudioWorkshop>-->
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
import {useToast} from "vue-toastification";
import {getCurrentInstance, onBeforeMount, ref} from "vue";
import unityActionOutgoing from "../composables/ActionsOutgoing";
import StudioWorkshop from "./StudioWorkshop";


export default {
    name: "Workshop",
    components: {OwnObjects, Marketplace, WorkshopPanel, StudioWorkshop},
    props: {
      loader: false
    },
    setup() {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const activeTab = ref('obiekty');
        const bridge = ref();
        const loadedObjectId = ref(null);
        const unityActionOutgoingObject = ref({});
        const gameWindow = ref(null);
        const toast = useToast();
        const window_width = ref('100%');
        const window_height = ref(0);

        emitter.on('loadObjectWorkshop', (e) => {
            handleUnityActionOutgoing({action: 'loadWorkshopObject', data: JSON.parse(e.object.save)});
        });

        emitter.on('UnityWorkshopSave', e => {
            axios.post('/api/workshop/models/save', {object: e, id: loadedObjectId})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zapisano');
                    } else {
                        toast.error('Wystąpił błąd');
                    }
                })
        });

        emitter.on('singleworkshopobject', e => {
            if (e.action == 'delete') {
                axios.post('/api/workshop/models/delete', {id: e.id})
                    .then(response => {
                        if (response.data.success) {
                            emitter.emit('singleobjectdeleted', {id: e.id});
                            toast.success('Usunięto');
                        } else {
                            toast.error('Wystąpił błąd');
                        }
                    })
            } else if (e.action == 'edit') {
                emitter.emit('LoadWorkshopItems', e.object);
            } else if (e.action == 'publish') {
                axios.post('/api/workshop/models/publish', {id: e.object.id})
                    .then(response => {
                        if (response.data.success) {
                            emitter.emit('singleobjectpublished', {id: e.object});
                            toast.success('Opublikowano');
                        } else {
                            toast.error('Wystąpił błąd');
                        }
                    })
            } else if (e.action == 'copy') {
                axios.post('/api/workshop/models/copy', {id: e.id})
                    .then(response => {
                        if (response.data.success) {
                            emitter.emit('singleobjectcopied', {id: e.id});
                            toast.success('Zaimportowano');
                        } else {
                            toast.error('Wystąpił błąd');
                        }
                    })
            }
        });

        const handleUnityActionOutgoing = (e) => {
            try {
                unityActionOutgoingObject.value[e.action](e.data);
            } catch (ee) {

            }
        }

        const initalize = async () => {
            setTimeout(function () {
                unityActionOutgoingObject.value = unityActionOutgoing(gameWindow.value);
            }, 6000);
            // setInterval(() => {
            //     console.log('HEREAAA', {action: 'LockUnityInput', data: ''});
            //     handleUnityActionOutgoing({action: 'LockUnityInput', data: ''});
            // }, 2000);
            // setTimeout(() => {
            //     handleUnityActionOutgoing({action: 'prefix', data: 'https://staging.appworks-dev.pl/s3'});
            //     // unlockInput();
            // }, 5000);
        }

        //RUNS WHEN UNITY IS READY
        // emitter.on('onInitialized', e => initalize());

        onBeforeMount(() => {
            initalize();
            //ADDS LISTENERS
            bridge.value = UnityBridgeWorkshop();

        });

        return {
            activeTab,
            initalize,
            handleUnityActionOutgoing,
            gameWindow,
            window_height,
            window_width
        }
    }
}
</script>

<style scoped>

</style>
