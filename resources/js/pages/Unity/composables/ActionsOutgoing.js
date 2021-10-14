import {watch, unref, onUnmounted, getCurrentInstance} from 'vue';

function outgoing(game, action, data, json) {
    // const app = getCurrentInstance();
    // const emitter = app.appContext.config.globalProperties.emitter;
    let finalData = '';
    if(json) {
        if(data.value != undefined) {
            finalData = JSON.stringify(data.value);
        } else {
            finalData = JSON.stringify(data);
        }

    } else {

        finalData = data;
    }

    console.log(['NetworkBridge', action, finalData]);
    game.message('NetworkBridge', action, finalData);
    // try {
    //     emitter.emit('unity_outgoing_multi', ['NetworkBridge', action, finalData]);
    // }catch (e) {
    //
    // }
}
export default function unityActionOutgoing(gameWindow) {
    const game = gameWindow;


    function placeObject(data) {

        outgoing(game, 'OrderPart', {
            model_name: data.name,
            model_id: data.id,
            prefab_url: window.location.protocol+'//' + location.host + '/s3/models/' + data.model_file
        }, true)
    }

    function workshopObjectLoad(object) {
        outgoing(game, 'LoadWorkshopItems', object)
    }

    function deleteObject() {

    }

    function setSessionId(id) {
        // outgoing(game, 'SetSesionID', id)
    }

    function setHangarAppearance (id) {
        outgoing(game, 'SetHangarApperance', id)
    }

    function unlockUnityInput () {
        outgoing(game, 'UnlockUnityInput', '')
    }

    function ChangeCamera (val) {
        outgoing(game, 'ChangeCamera', val)
    }

    function launchTutorial () {
        outgoing(game, 'LaunchTutorial', '');
    }

    function save() {
        outgoing(game, 'SaveStructure', '');
    }

    function loadWorkshopObject(val) {


        outgoing(game, 'LoadWorkshopItems', val, true);
    }

    function changeGridSize(val) {
        if(val === 0) {
            outgoing(game, 'HideGrid', val)
        } else {
            outgoing(game, 'DisplayGrid', val)
        }
    }

    function beginLayoutEdit() {
        outgoing(game, 'BeginLayoutEdit', 0);
    }

    function layoutMode() {
        outgoing(game, 'LayoutMode', '');
    }

    function editMode() {
        outgoing(game, 'EditMode', '');
    }

    function animationMode() {
        outgoing(game, 'LineAnimationMode', '');
    }

    function beginLayoutLabel() {
        outgoing(game, 'BeginLayoutLabel', 0);
    }

    function beginLayoutDraw() {
        outgoing(game, 'BeginLayoutDraw', 0);
    }

    function beginLayoutComment() {
        outgoing(game, 'BeginLayoutComment', 0);
    }

    function lockInput() {
        outgoing(game, 'LockUnityInput', '');
    }

    function unlockInput() {
        outgoing(game, 'UnlockUnityInput', '');
    }

    function closeRadialMenu () {
        outgoing(game, 'CloseRadialMenu', '');
    }

    function showRadialMenu(val) {
        outgoing(game, 'ShowRadialMenu', val);
    }

    function updateComment(val) {
        outgoing(game, 'UpdateComment', val, true);
    }

    function updateLabel(val) {
        outgoing(game, 'UpdateLabel', val, true);
    }

    function updateLayout(val) {
        outgoing(game, 'UpdateLayout', val, true);
    }

    function runAnimation (val) {
        outgoing(game, 'StartAnimation', val, true);
    }

    function pauseAnimation () {
        outgoing(game, 'PauseAnimation', '');
    }

    function stopAnimation () {
        outgoing(game, 'StopAnimation', '');
    }

    function setPlaybackSpeed (val) {
        outgoing(game, 'SetPlaybackSpeed', val);
    }

    function addLine(val) {
        game.message('NetworkBridge', 'SetNewAnimationLayer', val);
        // outgoing(game, '', val)
    }

    function prefix(val) {
        game.message('NetworkBridge', 'SetDefaultUrlPrefix', val);
    }

    function removeLine(val) {
        outgoing(game, 'DeleteLine', val);
    }

    function updateCurrentAnimation (val) {
        outgoing(game, 'UpdateCurrentAnimation', val, true);
    }

    function loadStructure (val) {

        if(val && Object.keys(val).length === 0 && val.constructor === Object) {

        } else {
            outgoing(game, 'LoadStructure', val, true);
        }

    }

    function getParts () {
        outgoing(game, 'GetPartsInfo', '');
    }

    // function setNewAnimationLayer (val) {
    //     outgoing(game, 'SetNewAnimationLayer', val);
    // }

    return {
        getParts,
        loadStructure,
        updateComment,
        updateLabel,
        updateLayout,
        placeObject,
        deleteObject,
        setSessionId,
        setHangarAppearance,
        unlockUnityInput,
        ChangeCamera,
        changeGridSize,
        save,
        beginLayoutEdit,
        beginLayoutLabel,
        beginLayoutDraw,
        beginLayoutComment,
        animationMode,
        editMode,
        layoutMode,
        lockInput,
        unlockInput,
        showRadialMenu,
        closeRadialMenu,
        runAnimation,
        stopAnimation,
        setPlaybackSpeed,
        pauseAnimation,
        addLine,
        removeLine,
        updateCurrentAnimation,
        prefix,
        loadWorkshopObject,
        launchTutorial
    };
}
