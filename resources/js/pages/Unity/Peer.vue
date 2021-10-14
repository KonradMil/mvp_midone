<template>
    <button class="btn-primary btn" style="top: 1px;
    position: absolute;" @click="join" >DOŁĄCZ</button>
    <div class="video-list">

    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import Peer from "peerjs";


export default {
    name: 'Peer',
    components: {
    },
    props: {
        sessionId: {
            type: String,
            default: 'public-room-v2'
        },
        owner: {
            type: Boolean,
            default: false
        }
    },
    setup(props) {
        const peer = ref({});
        const conn = ref({});
        const lastPeerId = ref('');

        onMounted(() => {
            if(props.owner) {
                peer.value = new Peer(props.sessionId, {
                    debug: 2
                });
            } else {
                let str = (Math.random().toString().substr(3, length) + Date.now()).toString(36);
                peer.value = new Peer(str, {
                    debug: 2
                });
            }


            peer.value.on('open', function (id) {
                if (peer.value.id === null) {
                    console.log('Received null id from peer open');
                    peer.value.id = lastPeerId.value;
                } else {
                    lastPeerId.value = peer.value.id;
                }

                console.log('ID: ' + peer.value.id);
                // recvId.innerHTML = "ID: " + peer.id;
                // status.innerHTML = "Awaiting connection...";
            });
            peer.value.on('connection', function (c) {
                // Allow only a single connection
                if (conn.value && conn.value.open) {
                    c.on('open', function() {
                        c.send("Already connected to another client");
                        setTimeout(function() { c.close(); }, 500);
                    });
                    return;
                }

                conn.value = c;
                console.log("Connected to: " + conn.value.peer);
                // status.innerHTML = "Connected";
                // ready();
            });
            peer.value.on('disconnected', function () {
                // status.innerHTML = "Connection lost. Please reconnect";
                console.log('Connection lost. Please reconnect');

                // Workaround for peer.reconnect deleting previous id
                peer.value.id = lastPeerId.value;
                peer.value._lastServerId = lastPeerId.value;
                peer.value.reconnect();
            });
            peer.value.on('close', function() {
                conn.value = null;
                // status.innerHTML = "Connection destroyed. Please refresh";
                console.log('Connection destroyed');
            });
            peer.value.on('error', function (err) {
                console.log(err);
                alert('' + err);
            });
        });

        const join = () => {
            conn.value = peer.value.connect(props.sessionId, {
                reliable: true
            });
            console.log('CONNECTED');
        }

        return {
            join
        }
    },
};
</script>
