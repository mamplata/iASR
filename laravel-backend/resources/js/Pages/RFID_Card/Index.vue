<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch } from "vue";
import { Head, usePage, router } from "@inertiajs/vue3";

const props = defineProps(["cards", "filters", "departments"]);
const search = ref(props.filters.search || "");
const department = ref(props.filters.department || "");

watch([search, department], () => {
    router.get(route("rfid-card"), { search: search.value, department: department.value }, { preserveState: true });
});

const deleteCard = (id) => {
    if (confirm("Are you sure?")) {
        router.delete(route("rfid-card.destroy", id));
    }
};

const gotoCreate = () => {
    router.get(route("rfid-card.create"));
};
</script>

<template>

    <div>

        <Head title="RFID Card" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    RFID Card
                </h2>
            </template>
            <div class="container">
                <div>
                    <button class="btn btn-dark" @click="gotoCreate">Add Name</button>
                </div>
                <div>
                    <input v-model="search" placeholder="Search by Student Name" class="border p-2 rounded" />
                    <select v-model="department" class="border p-2 rounded">
                        <option value="">All Departments</option>
                        <option v-for="dept in departments" :key="dept" :value="dept">{{ dept }}</option>
                    </select>
                </div>

                <table class="border-collapse border w-full mt-4">
                    <thead>
                        <tr>
                            <th class="border p-2">UID</th>
                            <th class="border p-2">Device ID</th>
                            <th class="border p-2">Student Name</th>
                            <th class="border p-2">Department</th>
                            <th class="border p-2">Program</th>
                            <th class="border p-2">Year Level</th>
                            <th class="border p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="card in cards.data" :key="card.cardId">
                            <td class="border p-2">{{ card.uid }}</td>
                            <td class="border p-2">{{ card.deviceId }}</td>
                            <td class="border p-2">{{ card.studName }}</td>
                            <td class="border p-2">{{ card.department }}</td>
                            <td class="border p-2">{{ card.program }}</td>
                            <td class="border p-2">{{ card.yearLevel }}</td>
                            <td class="border p-2">
                                <button @click="deleteCard(card.cardId)"
                                    class="bg-red-500 text-white px-2 py-1">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4">
                    <button v-if="cards.prev_page_url" @click="router.get(cards.prev_page_url)">Prev</button>
                    <button v-if="cards.next_page_url" @click="router.get(cards.next_page_url)">Next</button>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
