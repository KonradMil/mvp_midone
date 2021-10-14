<template>
<!--    <button class="btn-primary btn" style="top: 1px;-->
<!--    position: absolute;" @click="send">DOŁĄCZ</button>-->
    <div class="video-list">

    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import Peer from "peerjs";


export default {
    name: 'PeerTest',
    components: {
    },
    setup(props) {
        const peer = ref({});
        const conn = ref({});
        const lastPeerId = ref('');
        const ownId = ref('');
        const owner = ref(false);
        const urlParams = new URLSearchParams(window.location.search);
        onMounted(() => {
            let sessionid = urlParams.get('sessionid');
            peer.value = new Peer(null, {
                debug: 1,
                host: 'localhost',
                port: 9000,
                path: '/myapp'
            });

            if(sessionid != null) {
                owner.value = false;
                lastPeerId.value = sessionid;
                console.log('JOININ');
                join();
            } else {
                owner.value = true;
            }

            peer.value.on('open', function (id) {
                if (peer.value.id === null) {
                    console.log('Received null id from peer open');
                    peer.value.id = lastPeerId.value;
                } else {
                    ownId.value = peer.value.id;
                }

                console.log('ID: ' + peer.value.id);
            });


            peer.value.on('connection', function (c) {
                console.log('CONNECTED22');
                // Allow only a single connection
                if (conn.value && conn.value.open) {
                    c.on('open', function() {
                        c.send("Already connected to another client");
                        setTimeout(function() { c.close(); }, 500);
                    });
                    return;
                }

                conn.value = c;
                conn.value.on('data', function (data) {
                   console.log('MSG', data);
                });
                console.log("Connected to: " + conn.value.peer);
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

        const send = () => {
            console.log('PENIZ');
            conn.value.send('PENIZ');
        }

        const join = () => {
            conn.value = peer.value.connect(lastPeerId.value, {
                reliable: true
            });

            console.log(conn);
            console.log('CONNECTED');
        }

        return {
            owner,
            ownId,
            lastPeerId,
            conn,
            peer,
            send
        }
    },
};
</script>
