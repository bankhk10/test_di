<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";


const cards = ref([]);
const isLoading = ref(true);
const imageCard = "/img/persanolFrame.png";

//API
const fetchCards = async () => {
    try {
        const response = await axios.get('/api/cards');
        cards.value = response.data;
    } catch (error) {
        console.error("Error fetching card data:", error);
        // Optionally handle the error
    } finally {
        isLoading.value = false;
    }
};

// Fetch data on component mount
onMounted(() => {
    fetchCards();
});
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
    align-items: center;
    height: 100vh;
}

.card {
    position: relative;
    padding: 0;
    margin-right: 30px !important;
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
    flex-direction: column;
    align-items: center;
    color: rgb(0, 0, 0);
    z-index: 3;
    width: 100%; /* Ensure it spans the width of the card */
    text-align: center; /* Center align text */
}
</style>

<template>
    <div class="container">

            <div class="card p-0">
                <div class="card-image">
                    <img :src="imageCard" alt="Card Image" />
                    <img
                        :src="imageProfile"
                        alt="Profile Image"
                        class="profile-image"
                    />
                </div>
                <div class="card-content">
                    <div class=""><h3>Kwak Dong Yeon</h3></div>
                    <div class="">Programmer Manager</div>
                    <div class="">IT Department</div>
                </div>
                <div class="card-qr"></div>
            </div>
            <div class="card p-0">
                <div class="card-image">
                    <img :src="imageCard" alt="Card Image" />
                    <img
                        :src="imageProfile2"
                        alt="Profile Image"
                        class="profile-image"
                    />
                </div>
                <div class="card-content">
                    <div class=""><h3>Cho Byeong Kyu</h3></div>
                    <div class="">Marketing Manager</div>
                    <div class="">IT Department</div>
                </div>
                <div class="card-qr"></div>
            </div>
        </div>

</template>
