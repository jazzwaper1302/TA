const videoGrid = document.getElementById('video-grid');
const toggleCameraButton = document.getElementById('toggle-camera');
const toggleMicButton = document.getElementById('toggle-mic');
const shareScreenButton = document.getElementById('share-screen');
const addPeopleButton = document.getElementById('add-people');
const changeMasterButton = document.getElementById('change-master');

let localStream;
const peers = {};

// Fungsi untuk menambahkan video ke tata letak
function addVideoStream(videoElement) {
    videoGrid.appendChild(videoElement);
}

// Fungsi untuk menghapus video dari tata letak
function removeVideoStream(videoElement) {
    videoGrid.removeChild(videoElement);
}

// Meminta izin untuk menggunakan webcam dan mikrofon
async function startMediaStream() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        localStream = stream;
        const videoElement = document.createElement('video');
        videoElement.muted = true;
        videoElement.srcObject = stream;
        videoElement.play();
        addVideoStream(videoElement);
    } catch (error) {
        console.error('Error accessing media devices: ', error);
    }
}

// Fungsi untuk membuat koneksi dengan pengguna lain
function connectToNewUser(userId, stream) {
    const call = myPeer.call(userId, stream);
    const videoElement = document.createElement('video');
    call.on('stream', userStream => {
        addVideoStream(videoElement);
        videoElement.srcObject = userStream;
        videoElement.play();
    });
    call.on('close', () => {
        removeVideoStream(videoElement);
    });
    peers[userId] = call;
}

toggleCameraButton.addEventListener('click', () => {
    const tracks = localStream.getVideoTracks();
    tracks.forEach(track => {
        track.enabled = !track.enabled;
    });
});

toggleMicButton.addEventListener('click', () => {
    const tracks = localStream.getAudioTracks();
    tracks.forEach(track => {
        track.enabled = !track.enabled;
    });
});

shareScreenButton.addEventListener('click', () => {
    // Berbagi layar
});

addPeopleButton.addEventListener('click', () => {
    // Menambahkan orang ke panggilan
});

changeMasterButton.addEventListener('click', () => {
    // Mengubah master ruangan
});

// Mulai streaming media ketika dokumen telah dimuat
document.addEventListener('DOMContentLoaded', startMediaStream);

// Inisialisasi WebRTC Peer
const myPeer = new Peer(undefined, {
    host: '/',
    port: '3001' // Atur port Anda sesuai dengan konfigurasi server Peer Anda
});

myPeer.on('open', userId => {
    // Bergabung dengan panggilan saat koneksi Peer terbuka
    socket.emit('join-room', ROOM_ID, userId);
});

// Mendengarkan panggilan masuk dari pengguna lain
myPeer.on('call', call => {
    call.answer(localStream);
    const videoElement = document.createElement('video');
    call.on('stream', userStream => {
        addVideoStream(videoElement);
        videoElement.srcObject = userStream;
        videoElement.play();
    });
    call.on('close', () => {
        removeVideoStream(videoElement);
    });
    peers[call.peer] = call;
});
