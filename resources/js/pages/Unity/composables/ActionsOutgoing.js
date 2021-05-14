import {watch, unref, onUnmounted} from 'vue';
function outgoing(game, action, data, json) {
    console.log('ADASD');

    let finalData = '';
    if(json) {
        if(data.value != undefined) {
            console.log(data.value);
            finalData = JSON.stringify(data.value);
        } else {
            console.log(data);
            finalData = JSON.stringify(data);
        }

    } else {
        console.log(data);
        finalData = data;
    }
    console.log(['NetworkBridge', action, finalData]);
    game.message('NetworkBridge', action, finalData);

    // this.gameWindow.message('NetworkBridge', 'OrderPart', JSON.stringify({
    //     // model_name: 'M-410iC',
    //     model_name: obj.model_file,
    //     model_id: obj.id,
    //     prefab_url: `${this.$http.$url}s3/models/${obj.model_file}`,
    //     attributes: [
    //         {
    //         },
    //     ],
    // }));
}
export default function unityActionOutgoing(gameWindow) {
    const game = gameWindow;

    function placeObject(data) {
        console.log('PLACING');
        console.log(game);
        console.log(data);
        outgoing(game, 'OrderPart', {
            model_name: data.name,
            model_id: data.id,
            prefab_url: 'https://' + location.host + '/s3/models/' + data.model_file
        }, true)
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

    function save() {
        outgoing(game, 'SaveStructure', '');
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
        console.log(val);
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
        outgoing(game, 'SetNewAnimationLayer', val)
    }

    function removeLine(val) {
        outgoing(game, 'DeleteLine', val);
    }

    function updateCurrentAnimation (val) {
        outgoing(game, 'UpdateCurrentAnimation', val, true);
    }

    function loadStructure (val) {
        outgoing(game, 'LoadStructure', val, true);
    }

    return {
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
        updateCurrentAnimation
    };
}
