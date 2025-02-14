<script setup>
import { onMounted, ref, onUnmounted } from "vue";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { io } from "socket.io-client";

// Define reactive state
const responseMessage = ref("");
let socket = null;

// Connect to Socket.io on mount
onMounted(() => {
    socket = io("http://localhost:3000");

    socket.on("connect", () => {
        console.log("Connected to Socket.io server");
    });

    socket.on("responseEvent1", (data) => {
        console.log("Event 1 Response:", data);
        responseMessage.value = data.message;
    });

    socket.on("responseEvent2", (data) => {
        console.log("Event 2 Response:", data);
        responseMessage.value = data.message;
    });

    socket.on("disconnect", () => {
        console.log("Disconnected from server");
    });
});

// Define methods
const emitEvent1 = () => {
    socket.emit("event1", { message: "Button 1 clicked" });
};

const emitEvent2 = () => {
    socket.emit("event2", { message: "Button 2 clicked" });
};

// Cleanup on unmount
onUnmounted(() => {
    if (socket) {
        socket.disconnect();
    }
});
</script>

<template>
    <div>

        <Head title="NFC Card" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    NFC Card
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="container">
                                <h1>Socket.io with Laravel Vue</h1>

                                <button class="btn btn-primary" @click="emitEvent1">Send Event 1</button>
                                <button class="btn btn-secondary" @click="emitEvent2">Send Event 2</button>

                                <p>Server Response: {{ responseMessage }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
