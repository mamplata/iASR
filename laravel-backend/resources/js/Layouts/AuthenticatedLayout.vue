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
  <div>
    <div class="min-h-screen bg-gray-100 flex">
      <!-- Sidebar -->
      <div
        class="w-64 bg-white border-r border-gray-100 hidden sm:block shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="flex flex-col h-full">
          <!-- Logo -->
          <div class="flex shrink-0 items-center p-6">
            <Link :href="route('dashboard')" class="no-underline">
            <ApplicationLogo class="block w-auto fill-current text-gray-800" />
            </Link>
          </div>
          <!-- Navigation Links -->
          <div class="flex-1 space-y-4 px-2 py-4">
            <!-- Dashboard -->
            <NavLink href="#"
              class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
              <h6 class="d-flex justify-content-center align-items-center">
                <i class="fas fa-gauge me-2"></i>
                <span class="text-center">DASHBOARD</span>
              </h6>
            </NavLink>

            <!-- RFID Card Administration -->
            <NavLink href="#"
              class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
              <h6 class="d-flex justify-content-center align-items-center">
                <i class="fas fa-id-card me-2"></i>
                <span class="text-center">RFID CARD</span>
              </h6>
            </NavLink>

            <!-- Device Administration -->
            <NavLink href="#"
              class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
              <h6 class="d-flex justify-content-center align-items-center">
                <i class="fas fa-cogs me-2"></i>
                <span class="text-center">DEVICE</span>
              </h6>
            </NavLink>

            <!-- Announcements -->
            <NavLink href="#"
              class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
              <h6 class="d-flex justify-content-center align-items-center">
                <i class="fas fa-bullhorn me-2"></i>
                <span>ANNOUNCEMENTS</span>
              </h6>
            </NavLink>
            <NavLink href="#"
              class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
              <h6 class="d-flex justify-content-center align-items-center">
                <i class="fas fa-clipboard-list me-2"></i>
                <span class="text-center">AUDIT LOGS</span>
              </h6>
            </NavLink>
            <!-- Entry Logs -->
            <NavLink href="#"
              class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
              <h6 class="d-flex justify-content-center align-items-center">
                <i class="fas fa-book me-2"></i>
                <span class="text-center">ENTRY LOGS</span>
              </h6>
            </NavLink>

            <!-- Unauthorized Access Logs -->
            <NavLink href="#"
              class="block w-full rounded-md text-gray-700 hover:bg-gray-100 hover:shadow-md transition duration-200">
              <h6 class="d-flex justify-content-center align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <span>UNAUTHORIZED LOGS</span>
              </h6>
            </NavLink>
          </div>
        </div>
      </div>
      <!-- Main Content Area -->
      <div class="flex-1 flex flex-col">
        <!-- Header with Burger Menu for Mobile -->
        <header class="bg-[#198754] shadow">
          <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
              <!-- Burger Menu for Mobile -->
              <div class="-me-2 flex items-center sm:hidden">
                <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                  class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
                  <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>

              <!-- User Dropdown -->
              <div class="hidden sm:ms-auto sm:flex sm:items-center">
                <div class="relative ms-3">
                  <Dropdown align="right" width="48">
                    <template #trigger>
                      <span class="inline-flex rounded-md">
                        <button type="button"
                          class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                          {{ $page.props.auth.user.name }}
                          <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd" />
                          </svg>
                        </button>
                      </span>
                    </template>

                    <template #content>
                      <DropdownLink :href="route('profile.edit')">
                        Profile
                      </DropdownLink>
                      <DropdownLink :href="route('logout')" method="post" as="button">
                        Log Out
                      </DropdownLink>
                    </template>
                  </Dropdown>
                </div>
              </div>
            </div>
          </div>
        </header>

        <!-- Responsive Navigation Menu for Mobile -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
          <div class="space-y-1 pb-3 pt-2">
            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
              Dashboard
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
              <ResponsiveNavLink :href="route('profile.edit')">
                Profile
              </ResponsiveNavLink>
              <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                Log Out
              </ResponsiveNavLink>
            </div>
          </div>
        </div>

        <!-- Page Heading -->
        <header class="bg-white shadow" v-if="$slots.header">
          <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <slot name="header" />
          </div>
        </header>

        <!-- Page Content -->
        <main>
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
