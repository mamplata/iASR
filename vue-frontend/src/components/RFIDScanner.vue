<template>
    <div>
        <div class="image-wrapper">
            <img :src="iASRPNC" alt="">
        </div>
        <div class="image-container">
            <img :src="logoRFID" alt="">
        </div>
        <h1>TAP YOUR CARD</h1>
    </div>
</template>

<script>
import iASRPNC from "@/assets/img/iASRPNC.png";
import logoRFID from "@/assets/img/logoRFID.png";

export default {
    components: {
    },
    data() {
        return {
            iASRPNC,
            logoRFID
        }
    },
}
</script>

<style scoped>

</style>