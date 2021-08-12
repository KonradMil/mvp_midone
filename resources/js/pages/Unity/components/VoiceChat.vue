<template>
    <div id="audios-container"></div>
</template>

<script>
import {getCurrentInstance, onMounted} from "vue";
import RTCMultiConnection from 'rtcmulticonnection';

export default {
    name: "VoiceChat",
    props: {
        sessionid: String,
        owner: Boolean
    },
    setup(props) {

        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;

        const connection = new RTCMultiConnection();

        const onStream = (event) => {
            var width = parseInt(connection.audiosContainer.clientWidth / 2) - 20;
            var mediaElement = getHTMLMediaElement(event.mediaElement, {
                title: event.userid,
                buttons: ['full-screen'],
                width: width,
                showOnMouseEnter: false
            });

            connection.audiosContainer.appendChild(mediaElement);

            setTimeout(function () {
                mediaElement.media.play();
            }, 5000);

            mediaElement.id = event.streamid;
        }

        const onStreamEnded = (event) => {
            var mediaElement = document.getElementById(event.streamid);
            if (mediaElement) {
                mediaElement.parentNode.removeChild(mediaElement);
            }
        }

        onMounted(() => {
            connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';
            connection.socketMessageEvent = 'audio-conference-demo';
            connection.session = {
                audio: true,
                video: false
            };

            connection.mediaConstraints = {
                audio: true,
                video: false
            };

            connection.sdpConstraints.mandatory = {
                OfferToReceiveAudio: true,
                OfferToReceiveVideo: false
            };

            connection.iceServers = [{
                'urls': [
                    'stun:stun.l.google.com:19302',
                    'stun:stun1.l.google.com:19302',
                    'stun:stun2.l.google.com:19302',
                    'stun:stun.l.google.com:19302?transport=udp',
                ]
            }];

            connection.audiosContainer = document.getElementById('audios-container');
            connection.onstream = onStream(event);
            connection.onstreamended = onStreamEnded(event);
            connection.openOrJoin(props.sessionsid);
        });

        return {}
    }
}
</script>

<style scoped>

</style>
