import {onMounted, watch, ref, getCurrentInstance} from 'vue';
const UnityBridgeWorkshop = () => {
    const app = getCurrentInstance();
    const emitter = app.appContext.config.globalProperties.emitter;

    onMounted(() => {
        window.UnityWorkshopModelSave = function UnityWorkshopModelSave(str) {


            emitter.emit('UnityWorkshopSave', { data: JSON.parse(str) })
        };
        window.UnityWorkshopModelDelete = function UnityWorkshopModelDelete(str) {


            emitter.emit('UnityWorkshopDelete', { data: str })
        };
    });

    return {
        emitter
    }
}

export default UnityBridgeWorkshop;

