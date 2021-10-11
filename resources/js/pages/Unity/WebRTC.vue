<template>
    <button class="btn-primary btn" style="top: 1px;
    position: absolute;" @click="join">DOŁĄCZ</button>
    <div class="video-list">
        <div v-for="item in videoList"
             :video="item"
             :key="item.id"
             class="video-item">
            <video controls autoplay playsinline ref="videos" :height="cameraHeight" :muted="item.muted" :id="item.id"></video>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";

const io = require("socket.io-client");
const SimpleSignalClient = require('simple-signal-client');

export default {
    name: 'WebRTC',
    components: {
    },
    props: {
        roomId: {
            type: String,
            default: 'public-room-v2'
        },
        socketURL: {
            type: String,
            default: 'https://weston-vue-webrtc-lobby.azurewebsites.net'
            //default: 'https://localhost:3000'
            //default: 'https://192.168.1.201:3000'
        },
        cameraHeight: {
            type: [Number, String],
            default: 160
        },
        autoplay: {
            type: Boolean,
            default: true
        },
        screenshotFormat: {
            type: String,
            default: 'image/jpeg'
        },
        enableAudio: {
            type: Boolean,
            default: true
        },
        enableVideo: {
            type: Boolean,
            default: true
        },
        enableLogs: {
            type: Boolean,
            default: false
        },
        peerOptions: {
            type: Object,  // NOTE: use these options: https://github.com/feross/simple-peer
            default() {
                return {};
            }
        },
        // deviceId: {
        //     type: String,
        //     default: null
        // }
    },
    setup(props) {
        const signalClient = ref(null);
        const videoList = ref([]);
        const canvas = ref(null);
        const socket = ref(null);
        const videos = ref(null);
        const ctx = ref(null);
        const deviceId = ref('');

        const join = async () => {

            socket.value = io(props.socketURL, { rejectUnauthorized: false, transports: ['websocket'] });

            signalClient.value = new SimpleSignalClient(socket.value);

            // let constraints = ;

            // if (deviceId.value && props.enableVideo) {
            //     constraints.video = { deviceId: { exact: deviceId.value } };
            // }

            const localStream = await navigator.mediaDevices.getUserMedia({
                video: false,
                audio: true
            });

            joinedRoom(localStream, true);
            signalClient.value.once('discover', (discoveryData) => {

                async function connectToPeer(peerID) {
                    if (peerID == socket.value.id) return;
                    try {

                        const { peer } = await props.signalClient.connect(peerID, props.roomId, props.peerOptions);
                        videoList.value.forEach(v => {
                            if (v.isLocal) {
                                props.onPeer(peer, v.stream);
                            }
                        })
                    } catch (e) {

                    }
                }
                discoveryData.peers.forEach((peerID) => connectToPeer(peerID));
                // emit('opened-room', props.roomId);
            });
            signalClient.value.on('request', async (request) => {

                const { peer } = await request.accept({}, props.peerOptions)

                videoList.value.forEach(v => {
                    if (v.isLocal) {
                        onPeer(peer, v.stream);
                    }
                })
            })
            signalClient.value.discover(props.roomId);
        }

        const onPeer = (peer, localStream) => {

            peer.addStream(localStream);
            peer.on('stream', (remoteStream) => {
                joinedRoom(remoteStream, false);
                peer.on('close', () => {
                    var newList = [];
                    videoList.value.forEach(function (item) {
                        if (item.id !== remoteStream.id) {
                            newList.push(item);
                        }
                    });
                    videoList.value = newList;
                    // emit('left-room', remoteStream.id);
                });
                peer.on('error', (err) => {

                });
            });
        }

        const joinedRoom = (stream, isLocal) => {
            let found = videoList.value.find(video => {
                return video.id === stream.id
            })
            if (found === undefined) {
                let video = {
                    id: stream.id,
                    muted: isLocal,
                    stream: stream,
                    isLocal: isLocal
                };

                videoList.value.push(video);
            }

            setTimeout(function () {
                for (var i = 0, len = videos.value.length; i < len; i++) {
                    if (videos.value[i].id === stream.id) {
                        videos.value[i].srcObject = stream;
                        break;
                    }
                }
            }, 500);

            // emit('joined-room', stream.id);
        }

        const leave = () => {
            videoList.value.forEach(v => v.stream.getTracks().forEach(t => t.stop()));
            videoList.value = [];
            signalClient.value.peers().forEach(peer => peer.removeAllListeners())
            signalClient.value.destroy();
            signalClient.value = null;
            socket.value.destroy();
            socket.value = null;
        }

        const capture = () => {
            return getCanvas().toDataURL(props.screenshotFormat);
        }

        const getCanvas = () => {
            let video = videos.value[0];
            if (video !== null && !ctx.value) {
                let canvass = document.createElement('canvas');
                canvass.height = video.clientHeight;
                canvass.width = video.clientWidth;
                canvas.value = canvass;
                ctx.value = canvass.getContext('2d');
            }

            ctx.value.drawImage(video, 0, 0, canvas.value.width, canvas.value.height);
            return canvas.value;
        }

        const shareScreen = async () => {
            if (navigator.mediaDevices == undefined) {

                return;
            }

            try {
                let screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: false });
                joinedRoom(screenStream, true);
                // emit('share-started', screenStream.id);
                signalClient.value.peers().forEach(p => onPeer(p, screenStream));
            } catch (e) {

            }

        }

        onMounted(() => {
            navigator.mediaDevices.getUserMedia({ audio: true, video: false }).then((val) => { deviceId.value = val.id; });
        });

        return {
            signalClient,
            socket,
            videoList,
            canvas,
            deviceId,
            shareScreen,
            joinedRoom,
            getCanvas,
            capture,
            leave,
            onPeer,
            join
        }
    },
};
</script>
