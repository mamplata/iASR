<script setup>
import GuestLogo from '@/Components/GuestLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
<div class="guest flex min-h-screen flex-col items-center justify-center px-4">
    <div class="w-full max-w-md overflow-hidden bg-white px-6 py-8 shadow-lg rounded-lg">
        <!-- Centered Logo -->
        <div class="flex justify-center mb-6">
            <Link href="/">
                <GuestLogo class="fill-current text-gray-500" />
            </Link>
        </div>
        <!-- Slot for Content -->
        <slot />
    </div>
</div>

</template>
