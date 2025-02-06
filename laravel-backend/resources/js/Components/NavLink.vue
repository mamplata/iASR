<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex bg-[#F5F5F5] items-center px-4 py-2 border-b-2 border-[#FFD700] text-sm font-semibold leading-5 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#FFD700] rounded-lg shadow-sm hover:shadow-md transition duration-200 ease-in-out'
        : 'inline-flex items-center px-4 py-2 border-b-2 border-transparent text-sm font-semibold leading-5 text-gray-500 hover:text-[#FFD700] hover:border-[#FFD700] focus:outline-none focus:ring-2 focus:ring-[#FFD700] rounded-lg hover:shadow-md transition duration-200 ease-in-out',

);
</script>

<template>
    <Link :href="href" :class="classes">
    <slot />
    </Link>
</template>
