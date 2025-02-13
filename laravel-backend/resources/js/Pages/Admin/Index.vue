<template>
    <div>

        <Head title="Admin Accounts" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl fw-semibold text-dark">Admin Accounts</h2>
            </template>

            <div class="container">
                <div class="mb-3">
                    <div class="input-group">
                        <input v-model="search" placeholder="Search by Name or Email" class="form-control" />
                        <!-- Search button added to trigger filter -->
                        <button @click="filterSearch" class="btn btn-primary">Search</button>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="users.data.length > 0">
                            <tr v-for="user in users.data" :key="user.id">
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>
                                    <button @click="confirmToggleStatus(user)"
                                        :class="user.status === 1 ? 'btn btn-danger' : 'btn btn-success'">
                                        {{ user.status === 1 ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr v-else>
                            <td colspan="3" class="text-center">No user found</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav class="mt-3">
                    <ul class="pagination">
                        <!-- Prev Button -->
                        <li class="page-item" :class="{ disabled: !users.prev_page_url }">
                            <button class="page-link" @click="changePage(users.current_page - 1)"
                                :disabled="!users.prev_page_url">
                                Prev
                            </button>
                        </li>

                        <!-- Numbered Pages -->
                        <li v-for="page in users.last_page" :key="page" class="page-item"
                            :class="{ active: users.current_page === page }">
                            <button class="page-link" @click="changePage(page)">{{ page }}</button>
                        </li>

                        <!-- Next Button -->
                        <li class="page-item" :class="{ disabled: !users.next_page_url }">
                            <button class="page-link" @click="changePage(users.current_page + 1)"
                                :disabled="!users.next_page_url">
                                Next
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </AuthenticatedLayout>

        <!-- Bootstrap Confirmation Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to
                        <strong>{{ selectedUser?.status === 1 ? 'deactivate' : 'activate' }}</strong>
                        this account?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" @click="toggleStatus">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import { Modal } from "bootstrap";

const props = defineProps(["users", "filters"]);
const search = ref(props.filters.search || "");
const selectedUser = ref(null);

// Remove the automatic watch to avoid triggering on each input change
// Instead, create a function to trigger the search when the button is clicked
const filterSearch = () => {
    router.get(route("admin-accounts"), { search: search.value }, { preserveState: true });
};

// Pagination Function
const changePage = (page) => {
    if (page >= 1 && page <= props.users.last_page) {
        router.get(route("admin-accounts"), { page }, { preserveState: true });
    }
};

const confirmToggleStatus = (user) => {
    selectedUser.value = user;
    const modal = new Modal(document.getElementById("confirmModal"));
    modal.show();
};

const toggleStatus = () => {
    if (!selectedUser.value) return;

    const newStatus = selectedUser.value.status === 1 ? 0 : 1;
    router.put(route("admin-accounts.toggle", selectedUser.value.id), { status: newStatus });

    const modal = Modal.getInstance(document.getElementById("confirmModal"));
    modal.hide();
};
</script>
