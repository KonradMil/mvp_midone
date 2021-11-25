import {onMounted, watch, ref, getCurrentInstance} from 'vue';
const UnityBridge = () => {
    const app = getCurrentInstance();
    const emitter = app.appContext.config.globalProperties.emitter;

    onMounted(() => {
        window.UnityPerformanceIssue = function UnityPerformanceIssue(str) {

        }

        window.UnityAnimationChainUpdate = function UnityAnimationChainUpdate(str) {
            emitter.emit('UnityAnimationChainUpdate', { layers: JSON.parse(str) })
        };

        window.UnityAnimationErrors = function UnityAnimationErrors(str) {
            emitter.emit('UnityAnimationErrors', { animation_errors: JSON.parse(str) })
        };

        window.UnityCommentSelected = function UnityCommentSelected(str) {
            emitter.emit('UnityCommentSelected', { commentSelected: JSON.parse(str) })
        };

        window.UnityRoundMenuHighlight = function UnityRoundMenuHighlight(str) {
            emitter.emit('UnityRoundMenuHighlight', { round_menu_highlighted: JSON.parse(str) })
        };

        window.UnityRoundMenuPicked = function UnityRoundMenuPicked(str) {
            emitter.emit('UnityRoundMenuPicked', { round_menu_picked: JSON.parse(str) })
        };

        window.LayoutSelected = function LayoutSelected(str) {
            emitter.emit('LayoutSelected', { layout_selected: JSON.parse(str) })
        };

        window.UnityMenuLabelSelected = function MenuLabelSelected(str) {
            emitter.emit('UnityMenuLabelSelected', { menu_selected: str })
        };

        window.UnityLabelSelected = function LabelSelected(str) {
            emitter.emit('UnityLabelSelected', { labelSelected: JSON.parse(str) })
        };

        window.UnityLayoutSelected = function UnityLayoutSelected(str) {
            emitter.emit('UnityLayoutSelected', { layoutSelected: JSON.parse(str) });
        };

        window.UnityObjectPlaced = function UnityObjectPlaced(str) {
            emitter.emit('UnityObjectPlaced', { partsPlaced: JSON.parse(str).models });
        };

        window.UnityObjectDestroyed = function UnityObjectDestroyed(str) {
            emitter.emit('UnityObjectDestroyed', { partDestroyed: JSON.parse(str) });
        };

        window.EnterBuildMode = function EnterBuildMode() {

        };

        window.SceneLoaded = function SceneLoaded() {
            emitter.emit('SceneLoaded', '');
        };

        window.EnterSelectMode = function EnterSelectMode() {

        };

        window.UnityLogMessage = function UnityLogMessage(e) {

        };

        window.UnityGoToUrl = function UnityGoToUrl(e) {
            var win = window.open(JSON.parse(e).websiteUrl, '_blank');
            win.focus();
        };

        window.UnityPartPresentation = function UnityPartPresentation(str) {
            emitter.emit('UnityPartPresentation', { partsPresentation: JSON.parse(str) })
        };

        window.UnityRegisterCameraPosition = function UnityRegisterCameraPosition(str) {
            emitter.emit('UnityRegisterCameraPosition', { cameraPosition: JSON.parse(str) })
        };

        window.UnitySave = function UnitySave(str) {
            emitter.emit('UnitySave', { saveGame: str})
        };

        window.Load = function Load() {

        };
    });

    return {
        emitter
    }
}

export default UnityBridge;

