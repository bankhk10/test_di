<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import jsQR from 'jsqr';
import axios from 'axios';
import QRCode from 'qrcode';
import Cookies from 'js-cookie';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();
const dialog = ref(false);
const cameraActive = ref(false);
const stream = ref(null);
const qrCodeData = ref(null);
const videoRef = ref(null);
const notification = ref("");
const qrCodeImage = ref("");
const locationData = ref(null);
const deviceInfo = ref(null);
var user_id = route.params.id ?? null;

const openCamera = async () => {
    dialog.value = true;
    try {
        const userStream = await navigator.mediaDevices.getUserMedia({ video: true });
        stream.value = userStream;
        const video = videoRef.value;
        video.srcObject = userStream;
        video.play();

        video.addEventListener('loadedmetadata', scanQRCode);
        cameraActive.value = true;
    } catch (error) {
        console.error("ไม่สามารถเข้าถึงกล้องได้", error);
        notification.value = "ไม่สามารถเข้าถึงกล้องได้ โปรดตรวจสอบการอนุญาตของเบราว์เซอร์";
        dialog.value = false;
    }
};

const closeCamera = () => {
    if (stream.value) {
        const tracks = stream.value.getTracks();
        tracks.forEach(track => track.stop());
    }
    stream.value = null;
    const video = videoRef.value;
    if (video) video.srcObject = null;
    cameraActive.value = false;
    dialog.value = false;
};

const scanQRCode = () => {
    const video = videoRef.value;
    const canvas = document.createElement("canvas");
    const context = canvas.getContext("2d");

    const scan = () => {
        if (cameraActive.value && video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, canvas.width, canvas.height);

            if (code) {
                qrCodeData.value = code.data;
                if (isValidURL(qrCodeData.value)) {
                    window.open(qrCodeData.value, "_blank");
                    closeCamera();
                }
            } else {
                qrCodeData.value = null;
            }
        }
        if (cameraActive.value) {
            requestAnimationFrame(scan);
        }
    };

    scan();
};

const isValidURL = (string) => {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
};

const fetchLocation = () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                locationData.value = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                };
            },
            (error) => {
                console.error("Error fetching location:", error);
                notification.value = "ไม่สามารถดึงตำแหน่งได้";
            }
        );
    } else {
        notification.value = "เบราว์เซอร์ของคุณไม่รองรับ Geolocation";
    }
};

const fetchDeviceInfo = () => {
    deviceInfo.value = navigator.userAgent;
};

const generateQRCode = async () => {
    try {
        const response = await axios.get(`http://127.0.0.1:7979/generate-encrypted-card-url/${user_id}`);
        const encryptedUrl = response.data.url;

        qrCodeImage.value = await QRCode.toDataURL(encryptedUrl);
    } catch (error) {
        console.error('Error generating encrypted URL or QR Code:', error);
        
    }
};

const setCookies = async () => {
    try {
        Cookies.set('latitude', locationData.value?.latitude, { expires: 1 });
        Cookies.set('longitude', locationData.value?.longitude, { expires: 1 });
        Cookies.set('device_info', deviceInfo.value, { expires: 1 });
        Cookies.set('key_id', user_id, { expires: 1 });
    } catch (error) {
        console.error("Error sending data to server:", error);
    }
};

function logout() {
    document.cookie.split(';').forEach((cookie) => {
        const [name] = cookie.split('=');
        document.cookie = `${name}=; Path=/;`;
    });

    router.push('/login');
}

onMounted(async () => {
    fetchLocation();
    fetchDeviceInfo();
    await setCookies();
});

onUnmounted(() => {
    closeCamera();
});
</script>

<template>
    <v-btn color="primary" @click="logout">logout</v-btn>
    <v-sheet class="position-relative" min-height="450">
        <div class="position-absolute d-flex align-center justify-center w-100 h-50">
            <v-btn color="deep-purple-darken-2" size="x-large" @click="openCamera">
                Open Camera
            </v-btn>
        </div>
        <v-fade-transition hide-on-leave>
            <v-card v-if="dialog" class="mx-auto d-flex flex-column align-center justify-center" elevation="16"
                max-width="500" title="Camera">
                <v-divider></v-divider>
                <div class="d-flex flex-column align-center justify-center text-center py-12">
                    <video ref="videoRef" width="400" height="300" autoplay
                        class="border border-2 border-grey-darken-2 rounded"></video>
                    <v-alert v-if="notification" type="error" class="mt-4">
                        {{ notification }}
                    </v-alert>
                </div>
                <v-divider></v-divider>
                <v-btn icon="$close" variant="text" @click="closeCamera">Close</v-btn>
            </v-card>
        </v-fade-transition>
    </v-sheet>

    <div class="text-center">
        <v-btn color="primary" @click="generateQRCode">Generate QR Code</v-btn>
        <div v-if="qrCodeImage" class="mt-4">
            <img :src="qrCodeImage" alt="QR Code" />
        </div>
    </div>
</template>
