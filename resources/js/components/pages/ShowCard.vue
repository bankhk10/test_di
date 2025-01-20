<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Loading from "./Loading.vue";
import { useRoute } from "vue-router";

const route = useRoute();
const card = ref(null); // เปลี่ยนเป็น single card
const isLoading = ref(true);
const imageCard = "/img/persanolFrame.png";

const fetchCard = async () => {
    try {
        const response = await axios.get(`/api/card/${route.params.id}`);
        card.value = response.data;
        console.log(card.value);
    } catch (error) {
        console.error("Error fetching card data:", error);
    } finally {
        isLoading.value = false;
    }
};

// const downloadVCard = () => {
//     window.location.href = `/api/card/addContract/${route.params.id}`;
// };

onMounted(fetchCard);
</script>

<style scoped>
body {
    min-height: 100vh;
    background: linear-gradient(to bottom, #000428, #004683);
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    display: flex;
    justify-content: center;

    height: 100vh;
    flex-wrap: wrap;
}

.card {
    position: relative;
    padding: 0;
    /* margin-right: 30px !important; */
    margin-top: 50px;
    border-radius: 20px;
    overflow: hidden;
    max-width: 400px;
    max-height: 600px;
    border: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.card .card-image {
    width: 100%;
    max-height: 600px;
    position: relative;
    z-index: 2;
}

.card .card-image img {
    width: 100%;
    max-height: 600px;
    object-fit: cover;
}
.profile-image {
    position: absolute;
    top: 105px; /* ปรับตำแหน่งให้ตรงกับวงกลม */
    left: 50%;
    transform: translateX(-50%);
    padding-left: 66px;
    padding-right: 66px;
    height: 41%; /* ปรับขนาดของความสูง */
    width: 75%; /* ลดขนาดความกว้างเพื่อบีบรูปภาพจากด้านข้าง */
    border-radius: 100%;
    object-fit: cover;
    object-position: top;
    z-index: 1;
}
.card-content {
    position: absolute;
    bottom: 142px; /* Adjust as needed */
    display: flex;
    margin-bottom: 20px;
    flex-direction: column;
    align-items: center;
    color: rgb(0, 0, 0);
    z-index: 3;
    width: 100%; /* Ensure it spans the width of the card */
    text-align: center; /* Center align text */
}
.content-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 10px; /* ระยะห่างระหว่างคอลัมน์ */
    width: 100%;
    padding-right: 20px;
    padding-left: 20px;
}

.text-item {
    display: flex;
    align-items: center;
    padding: 2px;
    /* background-color: rgba(199, 199, 199, 0.5); */
    border-radius: 5px;
    color: rgb(0, 0, 0);
}

.text-item i {
    margin-right: 10px;
    font-size: 16px; /* ขนาดของไอคอน */
}
.card-qr {
    position: absolute;
    bottom: -103px; /* Adjust as needed */
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    height: 100px; /* ปรับขนาดของความสูง */
    z-index: 4;
}

.add-contact-btn {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #004683; /* สีพื้นหลัง */
    color: #ffffff; /* สีตัวอักษร */
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.3s;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.add-contact-btn:hover {
    background-color: #006bb3; /* สีเมื่อ hover */
    transform: translateY(-3px); /* ยกปุ่มขึ้นเล็กน้อยเมื่อ hover */
}

.add-contact-btn:active {
    transform: translateY(0); /* ย้อนกลับปุ่มลงเมื่อคลิก */
}
.text-phone,
.text-line {
    display: flex;
    align-items: center;
    padding: 10px;
    background-color: rgba(172, 172, 172, 0.5); /* สีพื้นหลังใสโปร่งใส 50% */
    border-radius: 5px;
    color: rgb(0, 0, 0);
}

.text-phone i,
.text-line i {
    margin-right: 10px;
    font-size: 16px; /* ขนาดของไอคอน */
}
.text-item a {
    text-decoration: none; /* ลบการตกแต่งลิงก์ (เช่น เส้นใต้) */
    color: inherit; /* ใช้สีตัวอักษรตามปกติ */
}

.text-item a:hover {
    color: #007bff; /* คุณสามารถปรับสีลิงก์เมื่อ Hover ได้ตามต้องการ */
}
.content-grid img{
    width: 120px;
    margin-left: 110px;
}
.name{
    font-size: 20px;
    font-weight: 600;
}


</style>

<template>
    <div class="container">
        <div v-if="isLoading" class="loading">
            <loading></loading>
        </div>
        <div v-else>
            <div class="card p-0">
                <div class="card-image">
                    <img :src="imageCard" alt="Card Image" />
                    <img
                        :src="card.fileExists ? card.remoteFile : '/img/Logo-Vbeyond.png'"
                        alt="Profile Image"
                        class="profile-image"
                    />
                </div>

                <div class="card-content">
                    <h2 class="name">{{ card.data.name_eng }}</h2>
                    <h3 class="">{{ card.data.position }}</h3>
                    <div class="">{{ card.data.department }}</div>
                    
                    <div class="card-qr">
                        <img :src="`data:image/svg+xml;base64,${card.qr_code}`" alt="QR Code" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
