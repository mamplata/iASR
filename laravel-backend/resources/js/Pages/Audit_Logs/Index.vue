<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import JsonDisplay from '@/Components/JsonDisplay.vue';  // Import the component

const props = defineProps({
    auditLogs: Object,
    filters: Object
});

const action = ref(props.filters.action || '');
const user = ref(props.filters.user || '');

// Filter Function
const filterLogs = () => {
    router.get('/audit-logs', { action: action.value, user: user.value }, { preserveState: true });
};

// Pagination Function
const changePage = (page) => {
    if (page >= 1 && page <= props.auditLogs.last_page) {
        router.get(route("audit-logs"), { page }, { preserveState: true });
    }
};
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Audit Logs" />
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Audit Logs
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <!-- Filter Section -->
                    <div class="flex space-x-4 mb-4">
                        <select v-model="action" class="border p-2 rounded">
                            <option value="">All Actions</option>
                            <option value="ADD">Add</option>
                            <option value="UPDATE">Update</option>
                            <option value="DELETE">Delete</option>
                            <option value="LOGIN">Login</option>
                        </select>

                        <input type="text" v-model="user" placeholder="Search by User"
                            class="border p-2 rounded w-1/3" />

                        <button @click="filterLogs" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Search
                        </button>
                    </div>

                    <!-- Audit Logs Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border p-2">Action</th>
                                    <th class="border p-2">Change</th>
                                    <th class="border p-2">Content</th>
                                    <th class="border p-2">User</th>
                                    <th class="border p-2">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="auditLogs.data.length">
                                    <tr v-for="log in auditLogs.data" :key="log.id" class="text-center">
                                        <td class="border p-2">{{ log.action }}</td>
                                        <td class="border p-2">
                                            <JsonDisplay :jsonData="log.change" />
                                        </td>
                                        <td class="border p-2">
                                            <JsonDisplay :jsonData="log.content" />
                                        </td>
                                        <td class="border p-2">{{ log.user }}</td>
                                        <td class="border p-2">{{ log.timestamp }}</td>
                                    </tr>
                                </template>
                                <tr v-else>
                                    <td colspan="5" class="text-center">No audit logs found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-3">
                        <ul class="pagination">
                            <!-- Prev Button -->
                            <li class="page-item" :class="{ disabled: !auditLogs.prev_page_url }">
                                <button class="page-link" @click="changePage(auditLogs.current_page - 1)"
                                    :disabled="!auditLogs.prev_page_url">
                                    Prev
                                </button>
                            </li>

                            <!-- Numbered Pages -->
                            <li v-for="page in auditLogs.last_page" :key="page" class="page-item"
                                :class="{ active: auditLogs.current_page === page }">
                                <button class="page-link" @click="changePage(page)">{{ page }}</button>
                            </li>

                            <!-- Next Button -->
                            <li class="page-item" :class="{ disabled: !auditLogs.next_page_url }">
                                <button class="page-link" @click="changePage(auditLogs.current_page + 1)"
                                    :disabled="!auditLogs.next_page_url">
                                    Next
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
