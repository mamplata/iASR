<script setup>
import { onMounted, ref, onUnmounted } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { io } from "socket.io-client";
const studentID = ref("");
const nfcStatus = ref("");
const nfcError = ref("");
const studentRecords = ref([]);
let socket = null;

onMounted(() => {
    socket = io("http://localhost:3000");

    socket.on("connect", () => {
        console.log("Connected to Socket.io server");
    });

    socket.on("nfcStatus", (message) => {
        nfcStatus.value = message;
    });

    socket.on("studentRegistered", (students) => {
        console.log(students);
        let latestStudent = students[students.length - 1];
        router.post(route('nfc-cards.store'), {
            uid: latestStudent.nfcUID,
            student_id: latestStudent.studentID,
        });
        studentRecords.value = students;
        nfcStatus.value = "Student Registered Successfully!";
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
    nfcStatus.value = "Waiting for NFC tap...";
};

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
                                <h1>Student Registration via NFC</h1>

                                <div class="input-section">
                                    <label>Enter Student ID:</label>
                                    <input v-model="studentID" placeholder="Student ID" />
                                    <button class="btn btn-primary" @click="registerStudent">Tap Your Card Now</button>
                                </div>

                                <p v-if="nfcStatus">{{ nfcStatus }}</p>
                                <p v-if="nfcError" class="error">{{ nfcError }}</p>

                                <h2>Registered Students</h2>
                                <ul>
                                    <li v-for="student in studentRecords" :key="student.nfcUID">
                                        <strong>{{ student.studentID }}</strong> - NFC UID: {{ student.nfcUID }}
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
