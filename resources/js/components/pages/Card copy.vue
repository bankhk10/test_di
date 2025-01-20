<script setup>
import { ref, onMounted  } from 'vue';
import axios from 'axios';
import Loading from "./Loading.vue";

const cards = ref([]);
const isLoading = ref(true);
const imageCard = '/img/persanolFrame.png';

const fetchCards = async () => {
    try {
        // const response = await axios.get('/api/cards');
        const response = await axios.get(`/api/getCard/${route.params.id}`);
        cards.value = response.data;
        console.log(cards.value);

    } catch (error) {
        console.error('Error fetching card data:', error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchCards);
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
    bottom: 150px; /* Adjust as needed */
    display: flex;
    margin-bottom: 10px;
    flex-direction: column;
    align-items: center;
    color: rgb(0, 0, 0);
    z-index: 3;
    width: 100%; /* Ensure it spans the width of the card */
    text-align: center; /* Center align text */
}
.card-qr {
    position: absolute;
    bottom: 60px; /* Adjust as needed */
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    height: 15%; /* ปรับขนาดของความสูง */
    z-index: 4;
}
.text-content {
    margin-top: -10px;
}
</style>

<template>
    <div class="container">

        <div v-if="isLoading" class="loading">   <loading></loading> </div>
        <div v-else>
            <div v-for="card in cards" :key="card.id" class="card p-0">
                <div class="card-image">
                    <img :src="imageCard" alt="Card Image" />
                    <img
                        :src="card.img_profile"
                        alt="Profile Image"
                        class="profile-image"
                    />
                </div>
                <div class="card-content">

                        <h3>{{ card.name }}</h3>

                    <div class="text-content">{{ card.role }}</div>
                    <div class="">{{ card.department }}</div>
                </div>
                <div class="card-qr">
                    <img :src="`data:image/svg+xml;base64,${card.qr_code}`" alt="QR Code" />
                </div>
            </div>
        </div>
    </div>
</template>
