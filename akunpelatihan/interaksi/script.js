const startButton = document.getElementById('startButton');
const hangupButton = document.getElementById('hangupButton');
const localVideo = document.getElementById('localVideo');
const remoteVideo = document.getElementById('remoteVideo');
let localStream;
let pc1;
let pc2;

startButton.addEventListener('click', startCall);
hangupButton.addEventListener('click', hangUpCall);

async function startCall() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        localVideo.srcObject = stream;
        localStream = stream;

        const configuration = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] };
        pc1 = new RTCPeerConnection(configuration);
        pc2 = new RTCPeerConnection(configuration);

        pc1.addEventListener('icecandidate', e => onIceCandidate(pc1, e));
        pc2.addEventListener('icecandidate', e => onIceCandidate(pc2, e));
        pc2.addEventListener('track', gotRemoteStream);

        localStream.getTracks().forEach(track => pc1.addTrack(track, localStream));

        const offer = await pc1.createOffer();
        await pc1.setLocalDescription(offer);
        await pc2.setRemoteDescription(offer);

        const answer = await pc2.createAnswer();
        await pc2.setLocalDescription(answer);
        await pc1.setRemoteDescription(answer);
    } catch (error) {
        console.error('Error starting call:', error);
    }
}

function onIceCandidate(pc, event) {
    if (event.candidate) {
        const otherPc = pc === pc1 ? pc2 : pc1;
        otherPc.addIceCandidate(event.candidate);
    }
}

function gotRemoteStream(event) {
    const stream = event.streams[0];
    if (remoteVideo.srcObject !== stream) {
        remoteVideo.srcObject = stream;
    }
}

function hangUpCall() {
    pc1.close();
    pc2.close();
    localVideo.srcObject = null;
    remoteVideo.srcObject = null;
}
