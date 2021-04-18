import {watch, unref, onUnmounted} from 'vue';
function outgoing(game, action, data, json) {
    let finalData = '';
    if(json) {
         finalData = JSON.stringify(data);
    } else {
        finalData = data;
    }

    game.message('NetworkBridge', action, finalData);

    this.gameWindow.message('NetworkBridge', 'OrderPart', JSON.stringify({
        // model_name: 'M-410iC',
        model_name: obj.model_file,
        model_id: obj.id,
        prefab_url: `${this.$http.$url}s3/models/${obj.model_file}`,
        attributes: [
            {
            },
        ],
    }));
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
            prefab_url: location.host + 's3/models/' + data.model_file
        }, true)
    }

    function deleteObject() {

    }

    return {
        placeObject,
        deleteObject
    };
}
