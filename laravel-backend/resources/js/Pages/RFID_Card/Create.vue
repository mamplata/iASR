<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch, reactive } from "vue";
import { Head, usePage, router } from "@inertiajs/vue3";

const formData = reactive({
    name: ''
});

const handleSubmit = () => {
    console.log('Stored Data:', formData) // Logs the object
}

const gotoHome = () => {
    router.get(route("rfid-card"));
};
</script>

<template>
    <div>
        <Head title="RFID Card" />

        <AuthenticatedLayout>
            <template #header>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a @click=gotoHome()>RFID</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
                    </ol>
                </nav>
            </template>

            <div class="container">
                <h1>Add RFID Cards</h1>
                <input type="text" v-model="formData.name" @keyup.enter="handleSubmit">
                <button class="btn btn-success" @click="handleSubmit">Add</button>
                <p> {{ formData.name }}</p>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
