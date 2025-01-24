<template>
    <div>
      <button @click="toggleCamera">{{ cameraActive ? 'หยุดกล้อง' : 'เปิดกล้อง' }}</button>
      <button v-if="cameraActive" @click="switchCamera">สลับกล้อง</button>
      <video ref="video" width="640" height="480" autoplay></video>
      <div v-if="qrCodeData">
        <p>QR Code ที่พบ: {{ qrCodeData }}</p>
      </div>
    </div>
  </template>

  <script>
  import jsQR from "jsqr";

  export default {
    data() {
      return {
        cameraActive: false,
        stream: null,
        qrCodeData: null,
        facingMode: "environment", // ค่าเริ่มต้นใช้กล้องหลัง
      };
    },
    methods: {
      async toggleCamera() {
        if (this.cameraActive) {
          this.stopCamera();
        } else {
          await this.startCamera();
        }
        this.cameraActive = !this.cameraActive;
      },
      async startCamera() {
        try {
          const constraints = {
            video: { facingMode: this.facingMode }  // กำหนดกล้องหน้า/หลัง
          };
          this.stream = await navigator.mediaDevices.getUserMedia(constraints);
          const video = this.$refs.video;
          video.srcObject = this.stream;

          video.addEventListener("loadedmetadata", () => {
            this.scanQRCode();
          });
        } catch (error) {
          console.error("ไม่สามารถเข้าถึงกล้องได้", error);
        }
      },
      stopCamera() {
        if (this.stream) {
          this.stream.getTracks().forEach(track => track.stop());
        }
        this.$refs.video.srcObject = null;
      },
      switchCamera() {
        this.facingMode = this.facingMode === "user" ? "environment" : "user";
        this.stopCamera();
        this.startCamera();
      },
      scanQRCode() {
        const video = this.$refs.video;
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");

        const scan = () => {
          if (this.cameraActive && video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, canvas.width, canvas.height);

            if (code) {
              this.qrCodeData = code.data;
              if (this.isValidURL(this.qrCodeData)) {
                window.open(this.qrCodeData, "_blank");
                this.stopCamera();
              }
            } else {
              this.qrCodeData = null;
            }
          }
          requestAnimationFrame(scan);
        };

        scan();
      },
      isValidURL(string) {
        try {
          new URL(string);
          return true;
        } catch (_) {
          return false;
        }
      },
    },
  };
  </script>

  <style scoped>
  button {
    margin-right: 10px;
    margin-bottom: 10px;
  }
  video {
    border: 1px solid #ccc;
  }
  </style>
