<template>
    <div>
        <div class="header">
            <Header></Header>
        </div>
        <div class="row">
            <div class="col-12">
                <Time></Time>
            </div>
        </div>
        <div class="row">
            <div class="col-4"><ScannerAnimation></ScannerAnimation></div>
            <div class="col-8 d-flex justify-content-center align-items-center">
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

</style>