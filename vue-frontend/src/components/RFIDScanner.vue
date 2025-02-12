<template>
    <div class="container-fluid">
        <div class="left-section">
            <div class="logo">
                <img :src="iASRPNC" alt="iASR Logo">
            </div>
            <div class="tap-card">
                <img :src="logoRFID" alt="RFID Icon">
                <h1 class="text">Tap your card</h1>
            </div>
        </div>
        <div class="right-section" :style="{ backgroundImage: `url(${bgAnnounce})` }">
            <h2 class="announcements-title">Announcements</h2>
            <div class="announcements-box">
                
            </div>
        </div>
    </div>
</template>

<script>
import iASRPNC from "@/assets/img/iASRPNC.png";
import logoRFID from "@/assets/img/logoRFID.png";
import bgAnnounce from "@/assets/img/bgAnnounce.png"; // Correct import

export default {
    data() {
        return {
            iASRPNC,
            logoRFID,
            bgAnnounce
        };
    }
};
</script>

<style scoped>
.container-fluid {
    display: flex;
    width: 100%;
    min-height: 100vh;
    background: white;
    padding: 0;
}

.left-section {
    width: 40%  ;
    display: flex;
    flex-direction: column;
    background: #FFFFFF;
    padding: 20px;
}

.logo img {
    max-width: 250px;
    margin-bottom: 20px;
}

.tap-card {
    margin-top: 50px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.tap-card img {
    max-width: 300px;
}

.text {
    font-size: 48px;
    font-weight: bold;
    color: #008000;
    margin-top: 80px;
}

.right-section {
    width: 60%;
    background-size: cover;
    background-position: center;
    padding: 20px;
    position: relative;
}

.announcements-title {
    color: white;
    font-size: 50px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 50px;
}

.announcements-box {
    width: 95%;
    height: 80%;
    background: white;
    border-radius: 10px;
    margin: 0 auto;
    padding: 15px;
}
</style>