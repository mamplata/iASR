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
        ? 'inline-flex bg-white items-center px-4 py-2 text-sm font-semibold leading-5 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-lg shadow-sm hover:shadow-md transition duration-200 ease-in-out no-underline'  
        : 'inline-flex items-center px-4 py-2 text-sm font-semibold leading-5 text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-lg hover:shadow-md transition duration-200 ease-in-out no-underline'
);
</script>

<template>
    <Link :href="href" :class="classes">
    <slot />
    </Link>
</template>
