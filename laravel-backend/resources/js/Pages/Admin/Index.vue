<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, watch } from "vue";
import { Head, router } from "@inertiajs/vue3";

const props = defineProps(["users", "filters"]);
const search = ref(props.filters.search || "");

watch([search], () => {
    router.get(route("admin-accounts"), { search: search.value }, { preserveState: true });
});

const toggleStatus = (user) => {
    const action = user.status === 1 ? 'deactivate' : 'activate';
    if (confirm(`Are you sure you want to ${action} this account?`)) {
        const newStatus = user.status === 1 ? 0 : 1;
        router.put(route("admin-accounts.toggle", user.id), { status: newStatus });
    }
};
</script>

<template>
    <div>

        <Head title="Admin Accounts" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Admin Accounts
                </h2>
            </template>
            <div class="container">
                <div>
                    <input v-model="search" placeholder="Search by Name or Email" class="border p-2 rounded" />
                </div>

                <table class="border-collapse border w-full mt-4">
                    <thead>
                        <tr>
                            <th class="border p-2">Name</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="border p-2">{{ user.name }}</td>
                            <td class="border p-2">{{ user.email }}</td>
                            <td class="border p-2">
                                <button @click="toggleStatus(user)"
                                    :class="{ 'bg-green-500': user.status === 0, 'bg-red-500': user.status === 1 }"
                                    class="text-white px-2 py-1">
                                    {{ user.status === 1 ? 'Deactivate' : 'Activate' }}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4">
                    <button v-if="users.prev_page_url" @click="router.get(users.prev_page_url)">
                        Prev
                    </button>
                    <button v-if="users.next_page_url" @click="router.get(users.next_page_url)">
                        Next
                    </button>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
