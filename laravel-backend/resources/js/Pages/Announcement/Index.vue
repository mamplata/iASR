<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    announcements: Object,
    filters: Object
});

const department = ref(props.filters.department || '');
const publisher = ref(props.filters.publisher || '');

// Filter Function
const filterLogs = () => {
    router.get('/announcements', { department: department.value, publisher: publisher.value }, { preserveState: true });
};

// Pagination Function
const changePage = (page) => {
    if (page >= 1 && page <= props.announcements.last_page) {
        router.get(route("announcements"), { page }, { preserveState: true });
    }
};

const addAnnouncement = () => {
    router.get(route('announcements.create'));
};

const editAnnouncement = (announcementId) => {
    router.get(route('announcements.edit', announcementId));
};

const deleteAnnouncement = (announcementId) => {
    router.delete(route('announcements.destroy', announcementId));
};

// For modal popup of announcement content
const selectedAnnouncement = ref(null);

const openContentModal = (announcement) => {
    selectedAnnouncement.value = announcement;
};
</script>

<template>
    <div>

        <Head title="Announcements" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Announcements
                </h2>
            </template>

            <div class="py-6">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <button @click="addAnnouncement" class="btn btn-success mb-2">Add Announcement</button>
                        <!-- Filter Section -->
                        <div class="flex space-x-4 mb-4">
                            <select v-model="department" class="border p-2 rounded">
                                <option value="">All Departments</option>
                                <option value="CBAA">CBAA</option>
                                <option value="CCS">CCS</option>
                                <option value="COE">COE</option>
                                <option value="COED">COED</option>
                            </select>

                            <input type="text" v-model="publisher" placeholder="Search by Publisher"
                                class="border p-2 rounded w-1/3" />

                            <button @click="filterLogs"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Search
                            </button>
                        </div>

                        <!-- Announcements Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border p-2">Department</th>
                                        <th class="border p-2">Publisher</th>
                                        <th class="border p-2">Publication Date</th>
                                        <th class="border p-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="announcements.data.length">
                                        <tr v-for="announcement in announcements.data" :key="announcement.id"
                                            class="text-center">
                                            <td class="border p-2">{{ announcement.department }}</td>
                                            <td class="border p-2">{{ announcement.publisher }}</td>
                                            <td class="border p-2">{{ announcement.publication_date }}</td>
                                            <td class="border p-2">
                                                <button type="button" class="btn btn-info"
                                                    @click="openContentModal(announcement)" data-bs-toggle="modal"
                                                    data-bs-target="#contentModal">
                                                    View Content
                                                </button>
                                                <button @click="editAnnouncement(announcement.id)"
                                                    class="btn btn-success">Edit</button>
                                                <button @click="deleteAnnouncement(announcement.id)"
                                                    class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr v-else>
                                        <td colspan="6" class="text-center">No announcement found</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav class="mt-3">
                            <ul class="pagination">
                                <!-- Prev Button -->
                                <li class="page-item" :class="{ disabled: !announcements.prev_page_url }">
                                    <button class="page-link" @click="changePage(announcements.current_page - 1)"
                                        :disabled="!announcements.prev_page_url">
                                        Prev
                                    </button>
                                </li>

                                <!-- Numbered Pages -->
                                <li v-for="page in announcements.last_page" :key="page" class="page-item"
                                    :class="{ active: announcements.current_page === page }">
                                    <button class="page-link" @click="changePage(page)">{{ page }}</button>
                                </li>

                                <!-- Next Button -->
                                <li class="page-item" :class="{ disabled: !announcements.next_page_url }">
                                    <button class="page-link" @click="changePage(announcements.current_page + 1)"
                                        :disabled="!announcements.next_page_url">
                                        Next
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Bootstrap Modal for Announcement Content -->
            <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="contentModalLabel">Announcement Content</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <template v-if="selectedAnnouncement">
                                <!-- Check the content type -->
                                <div v-if="selectedAnnouncement.content_type === 'image'">
                                    <img :src="'data:image/*;base64,' + selectedAnnouncement.content"
                                        alt="Announcement Image" class="img-fluid">
                                </div>
                                <div v-else-if="selectedAnnouncement.content_type === 'text'">
                                    <!-- Parse JSON text content -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-info text-white">
                                            <small class="text-uppercase">Headline</small>
                                            <h5 class="mb-0">{{ JSON.parse(selectedAnnouncement.content).headline }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><strong>Body:</strong> {{
                                                JSON.parse(selectedAnnouncement.content).body }}</p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
