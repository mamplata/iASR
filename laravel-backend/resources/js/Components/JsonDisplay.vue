<template>
    <div class="json-display">
        <template v-if="isObject(jsonData)">
            <div v-for="(value, key) in jsonData" :key="key" class="mb-1">
                <span class="font-bold">{{ capitalizeFirstLetter(key) }}:</span>
                <span v-if="!isObject(value)" class="ml-1">{{ value }}</span>
                <JsonDisplay v-else :jsonData="value" class="ml-4" />
            </div>
        </template>
        <template v-else>
            <span>{{ jsonData }}</span>
        </template>
    </div>
</template>

<script setup>
const props = defineProps({
    jsonData: {
        type: [Object, Array, String, Number],
        required: true
    }
});

const capitalizeFirstLetter = (str) => {
    if (!str) return str;
    return `${str.charAt(0).toUpperCase()}${str.slice(1)}`;
}

const isObject = (val) => {
    return val !== null && typeof val === 'object';
};
</script>

<style scoped>
.font-bold {
    font-weight: bold;
}

.ml-1 {
    margin-left: 0.25rem;
}

.ml-4 {
    margin-left: 1rem;
}

.mb-1 {
    margin-bottom: 0.25rem;
}
</style>
