<script setup>
import { ref } from 'vue';
import AuthLogo from '@/Components/AuthLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, router } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

let disabled_logout = ref(false);

const logout = () => {
    // Disable the button immediately
    disabled_logout.value = true;
    router.post(route('logout'), {}, {
        onError: () => {
            disabled_logout.value = false;
        }
    });
};

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            <div class="w-64 bg-white border-r border-gray-100 hidden sm:block transition-shadow duration-300">
                <div class="flex flex-col h-full">
                    <!-- Logo -->
                    <div class="flex shrink-0 items-center p-6">
                        <Link :href="route('dashboard')">
                        <AuthLogo />
                        </Link>
                    </div>
                    <!-- Navigation Links -->
                    <div class="flex-1 space-y-4 px-2 py-2">
                        <!-- Dashboard -->
                        <NavLink :href="route('dashboard')"
                            class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
                            <h6 class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-gauge me-2"></i>
                                <span class="text-center">Dashboard</span>
                            </h6>
                        </NavLink>
                        <NavLink :href="route('admin-accounts')"
                            class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
                            <h6 class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-user me-2"></i>
                                <span class="text-center">Admin</span>
                            </h6>
                        </NavLink>
                        <NavLink :href="route('nfc-cards')"
                            class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
                            <h6 class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-id-card me-2"></i>
                                <span class="text-center">NFC Card</span>
                            </h6>
                        </NavLink>
                        <NavLink :href="route('device')"
                            class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
                            <h6 class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-desktop me-2"></i>
                                <span class="text-center">Devices</span>
                            </h6>
                        </NavLink>
                        <NavLink :href="route('announcements')"
                            class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
                            <h6 class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-bullhorn me-2"></i>
                                <span class="text-center">Announcements</span>
                            </h6>
                        </NavLink>
                        <NavLink :href="route('audit-logs')"
                            class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
                            <h6 class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-scroll me-2"></i>
                                <span class="text-center">Audit Logs</span>
                            </h6>
                        </NavLink>
                        <NavLink :href="route('entry-logs')"
                            class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
                            <h6 class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-right-to-bracket me-2"></i>
                                <span class="text-center">Entry Logs</span>
                            </h6>
                        </NavLink>
                        <NavLink :href="route('unauthorized-logs')"
                            class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
                            <h6 class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-ban me-2"></i>
                                <span class="text-center">Unauthorized Logs</span>
                            </h6>
                        </NavLink>
                    </div>
                </div>
            </div>
            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col">
                <!-- Header with Burger Menu for Mobile -->
                <header class="main-header bg-[#198754]">
                    <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center">
                            <!-- Burger Menu for Mobile -->
                            <div class="-me-2 flex items-center sm:hidden">
                                <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out bg-gray-100 text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path
                                            :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16" />
                                        <path
                                            :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <h4 class="text-white hidden lg:block font-bold">Welcome, {{
                                    $page.props.auth.user.name.charAt(0).toUpperCase() +
                                    $page.props.auth.user.name.slice(1) }}!</h4>
                            </div>
                            <!-- User Dropdown -->
                            <div class="hidden sm:ms-auto sm:flex sm:items-center">
                                <div class="relative ms-3">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <div
                                                    class="flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-gray-600 shadow-sm transition duration-200 ease-in-out focus:ring-2 focus:ring-gray-300 focus:outline-none">
                                                    <img src="@/img/menu.png" alt="menu"
                                                        class="transition duration-200 ease-in-out hover:filter hover:brightness-0 hover:sepia hover:hue-rotate-90 focus:filter focus:brightness-0 focus:sepia focus:hue-rotate-90">
                                                </div>
                                            </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink :href="route('profile.edit')">
                                                Profile
                                            </DropdownLink>
                                            <DropdownLink href="#" @click.prevent="logout" method="post" as="button"
                                                :class="{ disabled_logout: disabled_logout }"
                                                :disabled="disabled_logout">
                                                Log Out
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Navigation for MObile -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden bg-white h-100">
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')"
                            class="no-underline">
                            <i class="fas fa-gauge me-2"></i> Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('admin-accounts')" :active="route().current('admin-accounts')"
                            class="no-underline">
                            <i class="fas fa-user me-2"></i> Admin
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('nfc-cards')" :active="route().current('nfc-cards')"
                            class="no-underline">
                            <i class="fas fa-id-card me-2"></i> NFC Card
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('device')" :active="route().current('device')"
                            class="no-underline">
                            <i class="fas fa-desktop me-2"></i> Devices
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('announcements')" :active="route().current('announcements')"
                            class="no-underline">
                            <i class="fas fa-bullhorn me-2"></i> Announcements
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('audit-logs')" :active="route().current('audit-logs')"
                            class="no-underline">
                            <i class="fas fa-scroll me-2"></i> Audit Logs
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('entry-logs')" :active="route().current('entry-logs')"
                            class="no-underline">
                            1 <i class="fas fa-right-to-bracket me-2"></i> Entry Logs
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('unauthorized-logs')"
                            :active="route().current('unauthorized-logs')" class="no-underline">
                            <i class="fas fa-ban me-2"></i> Unauthorized Logs
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-gray-200 pb-1 pt-4">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')" class="no-underline">
                                <i class="fas fa-user-edit me-2"></i> Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink href="#" @click.prevent="logout" method="post" as="button"
                                class="no-underline" :class="{ disabled_logout: disabled_logout }">
                                <i class="fas fa-sign-out-alt me-2"></i> Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>

                <!-- Page Heading (for larger screens) -->
                <header class="bg-white shadow sm:block hidden">
                    <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto">
                    <!-- Page Heading (for smaller screens) -->
                    <header class="bg-white shadow sm:hidden">
                        <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
                            <slot name="header" />
                        </div>
                    </header>

                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showingNavigationDropdown: false,
        };
    },
};
</script>

<style>
/* Ensure the body takes up the full height */
html,
body {
    height: 100%;
    margin: 0;
}

/* Main container with flex layout */
.min-h-screen {
    display: flex;
    flex-direction: row;
    height: 100vh;
}

/* Sidebar fixed position */
.w-64 {
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
}

/* Main content area */
.flex-1 {
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    /* Makes the main content scrollable */
}

/* Header static position */
.main-header {
    position: sticky;
    top: 0;
    z-index: 1;
}

.disabled_logout {
    cursor: not-allowed !important;
}

.disabled_logout:hover {
    background-color: transparent;
}
</style>
