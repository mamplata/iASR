<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="flex min-h-screen bg-[#f6f7fb]">
        <!-- Sidebar -->
        <div :class="{'w-64': isSidebarOpen, 'w-16': !isSidebarOpen}" class="h-screen bg-[#ffffff] shadow-md transition-all duration-300">
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <span v-if="isSidebarOpen" class="text-lg font-semibold text-gray-800">iAttend</span>
                <button @click="toggleSidebar" class="p-2 text-gray-600 hover:bg-gray-100 rounded-md">
                    <svg v-if="isSidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <nav class="mt-4 flex flex-col space-y-2">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Dashboard
                </NavLink>
                <NavLink :href="route('dashboard')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Student Management
                </NavLink>
                <NavLink :href="route('dashboard')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Schedule
                </NavLink>
                <NavLink :href="route('dashboard')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    System Settings
                </NavLink>
                <NavLink :href="route('dashboard')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    RFID Management
                </NavLink>
                <NavLink :href="route('dashboard')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Logs
                </NavLink>
                <NavLink :href="route('dashboard')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Reports
                </NavLink>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Page Heading -->
            <header class="bg-[#198754] shadow text-white flex justify-between items-center px-6 py-4">
                <div class="text-white !important">
                    <slot id="test" name="header" />
                </div>
                <div class="flex items-center space-x-4">
                    <span>{{ $page.props.auth.user.name }}</span>
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="p-2 bg-white text-gray-700 rounded-md hover:bg-gray-200">▼</button>
                        </template>
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4">
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isSidebarOpen: true
        };
    },
    methods: {
        toggleSidebar() {
            this.isSidebarOpen = !this.isSidebarOpen;
        }
    }
};
</script>

<style scoped>
@media (max-width: 768px) {
    .w-64 {
        width: 0;
        overflow: hidden;
    }
}
</style>

