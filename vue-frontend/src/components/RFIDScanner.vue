<template>
    <div>
        <Header></Header>
        <!-- Centered Time Component with 100% width -->
        <div class="row justify-content-center">
            <div class="col-12">
                <Time></Time>
            </div>
        </div>

        <!-- Centered ScannerAnimation and RecentLog Components -->
        <div class="row justify-content-center">
            <div class="col-md-4 animation">
                <ScannerAnimation></ScannerAnimation>
            </div>
            <div class="col-md-8 d-flex justify-content-center align-items-center">
                <RecentLog></RecentLog>
            </div>
        </div>
    </div>
</template>

<script>
import Header from './Header.vue';
import Time from './Time.vue';
import ScannerAnimation from './ScannerAnimation.vue';
import RecentLog from './RecentLog.vue';

export default {
    components: {
        Header,
        Time,
        ScannerAnimation,
        RecentLog
    },
    data() {
        return {

        }
    },
}
</script>

<style scoped>

.animation {
    display: flex;
    justify-content: center;
    align-items: center;
}

.row {
    margin: 0 auto;
    padding: 0;
}

.container {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;  /* Prevent horizontal scrolling */
}

/* Adjusting column layout */
.col-md-4, .col-md-8 {
    padding: 0 !important;  /* Remove any padding that may cause overflow */
}
</style>