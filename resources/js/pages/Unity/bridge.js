import {onMounted, watch, ref, getCurrentInstance} from 'vue';
const UnityBridge = () => {
    const app = getCurrentInstance();
    const emitter = app.appContext.config.globalProperties.emitter;

    onMounted(() => {
        window.UnityAnimationChainUpdate = function UnityAnimationChainUpdate(str) {
            console.log('ODEBRANE LAYERY');
            console.log(str);
            emitter.emit('UnityAnimationChainUpdate', { layers: JSON.parse(str) })
        };

        window.UnityAnimationErrors = function UnityAnimationErrors(str) {
            console.log('PART PLACED ANIMATIONSD ERRORS');
            console.log(str);
            emitter.emit('UnityAnimationErrors', { animation_errors: JSON.parse(str) })
        };

        window.UnityCommentSelected = function UnityCommentSelected(str) {
            console.log('COMMENT SELCTED');
            console.log(str);
            emitter.emit('UnityCommentSelected', { commentSelected: JSON.parse(str) })
        };

        window.UnityRoundMenuHighlight = function UnityRoundMenuHighlight(str) {
            emitter.emit('UnityRoundMenuHighlight', { round_menu_highlighted: JSON.parse(str) })
        };
        window.UnityRoundMenuPicked = function UnityRoundMenuPicked(str) {
            emitter.emit('UnityRoundMenuPicked', { round_menu_picked: JSON.parse(str) })
        };
        window.LayoutSelected = function LayoutSelected(str) {
            console.log('LAYOUT SELCTED');
            console.log(str);
            emitter.emit('LayoutSelected', { layout_selected: JSON.parse(str) })
        };
        window.UnityMenuLabelSelected = function MenuLabelSelected(str) {
            console.log('LABEL SELCTED');
            console.log(str);
            emitter.emit('UnityMenuLabelSelected', { menu_selected: str })
        };
        window.UnityLabelSelected = function LabelSelected(str) {
            console.log(str);
            // window.v.unity.labelSelected = JSON.parse(str);
            // window.v.unity.layoutSelected = {};
            emitter.emit('UnityLabelSelected', { labelSelected: JSON.parse(str) })
        };

        window.UnityLayoutSelected = function UnityLayoutSelected(str) {
            console.log(str);
            console.log('Layout selected');
            // let l = JSON.parse(str);
            // if(l.light_on_enter != undefined) {
            //     window.v.unity.lightemup = l.light_on_enter;
            // }
            // window.v.unity.layoutSelected = l;
            // window.v.unity.labelSelected = {};

            emitter.emit('UnityLayoutSelected', { layoutSelected: JSON.parse(str) })
        };
        window.UnityObjectPlaced = function UnityObjectPlaced(str) {
            console.log('PART PLACED');
            // window.v.unity.partsPlaced = JSON.parse(str).models;
            // window.v.unity.getCategoriesForPartsPlaced();

            emitter.emit('UnityObjectPlaced', { partsPlaced: JSON.parse(str).models })
        };
        window.UnityObjectDestroyed = function UnityObjectDestroyed(str) {
            console.log('PART DESTROYED');
            console.log(str);
            emitter.emit('UnityObjectDestroyed', { partDestroyed: JSON.parse(str) })
        };
        window.EnterBuildMode = function EnterBuildMode() {
            console.log('EnterBuildMode');
        };
        window.EnterSelectMode = function EnterSelectMode() {
            console.log('EnterSelectMode');
        };
        window.UnityRegisterCameraPosition = function EnterSelectMode(str) {
            console.log('Camera position');
            console.log(str);
        };
        window.UnityLogMessage = function UnityLogMessage(e) {
            console.log('THIS SHIET ' + e);
        };
        window.UnityGoToUrl = function UnityGoToUrl(e) {
            console.log('URL');
            console.log(e);
            var win = window.open(JSON.parse(e).websiteUrl, '_blank');
            win.focus();
            // window.location.replace(e);
        };
        window.UnityPartPresentation = function UnityPartPresentation(str) {
            console.log('Part presentation');
            console.log(JSON.parse(str));
            // window.v.unity.partsPresentation = JSON.parse(str);
            // console.log('TUTEJ');
            // console.log(JSON.parse(str).model_id);
            // window.v.unity.sendBack(JSON.parse(str).model_id);

            emitter.emit('UnityPartPresentation', { partsPresentation: JSON.parse(str) })
        };
        window.UnityRegisterCameraPosition = function UnityRegisterCameraPosition(str) {
            console.log('UnityRegisterCameraPosition');
            console.log(JSON.parse(str));
            // window.v.unity.cameraPosition = JSON.parse(str);

            emitter.emit('UnityRegisterCameraPosition', { cameraPosition: JSON.parse(str) })
        };
        window.UnitySave = function UnitySave(str) {
            console.log('Save');
            console.log(JSON.parse(str));

            emitter.emit('UnitySave', { saveGame: str})
            // window.v.unity.saveGame(str);
        };
        window.Load = function Load() {
            console.log('Loaded');
        };
    });

    return {
        emitter
    }
}

export default UnityBridge;

