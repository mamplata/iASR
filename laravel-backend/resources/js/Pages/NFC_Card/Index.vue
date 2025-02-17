<script setup>
import { onMounted, ref, onUnmounted } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { io } from "socket.io-client";

const studentID = ref("");
const nfcStatus = ref("");
const nfcError = ref("");
const studentRecords = ref([]);
const isLoading = ref(false); // ⬅️ Loading state
let socket = null;

onMounted(() => {
    socket = io("http://localhost:3000");

    socket.on("connect", () => {
        console.log("Connected to Socket.io server");
    });

    socket.on("nfcStatus", (message) => {
        nfcStatus.value = message;
    });

    socket.on("studentRegistered", async (students) => {
        console.log(students);
        let latestStudent = students[students.length - 1];

        isLoading.value = true; // Start loading animation before sending data

        try {
            await router.post(route('nfc-cards.store'), {
                uid: latestStudent.nfcUID,
                student_id: latestStudent.studentID,
            });

            nfcStatus.value = "✅ Student Registered Successfully!";
            studentRecords.value = students;
        } catch (error) {
            console.error("❌ Registration failed:", error);
            nfcStatus.value = "❌ Registration Failed!";
        } finally {
            setInterval(() => {
                isLoading.value = false
            },
                1000
            )
        }
    });

    socket.on("nfcError", (error) => {
        console.error("NFC Error:", error);
        nfcError.value = error;
    });

    socket.on("disconnect", () => {
        console.log("Disconnected from server");
    });
});

const registerStudent = () => {
    if (!studentID.value) {
        alert("Please enter a Student ID first.");
        return;
    }

    console.log("Registering Student ID:", studentID.value);
    socket.emit("registerStudent", studentID.value);
    nfcStatus.value = "⏳ Waiting for NFC tap...";
};

onUnmounted(() => {
    if (socket) {
        socket.disconnect();
    }
});

const props = defineProps({
    nfcCards: Object,
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
                                <h1>Student Registration via NFC</h1>

                                <div class="input-section">
                                    <label>Enter Student ID:</label>
                                    <input v-model="studentID" placeholder="Student ID" />
                                    <button class="btn btn-primary" @click="registerStudent" :disabled="isLoading">
                                        Tap Your Card Now
                                    </button>
                                </div>

                                <!-- 🔄 Show loading animation -->
                                <div v-if="isLoading" class="loading-container">
                                    <div class="loading-spinner"></div>
                                    <p>Processing registration...</p>
                                </div>

                                <p v-if="nfcStatus">{{ nfcStatus }}</p>
                                <p v-if="nfcError" class="error">{{ nfcError }}</p>

                                <h2>Registered Students</h2>
                                <ul>
                                    <li v-for="nfc in nfcCards.data" :key="nfc.id">
                                        <strong>{{ nfc.student_id }}</strong> - NFC UID: {{ nfc.uid }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<style scoped>
.loading-container {
    text-align: center;
    margin-top: 10px;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 5px solid #ccc;
    border-top: 5px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    display: inline-block;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
</style>
