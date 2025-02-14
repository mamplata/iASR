<script setup>
import { ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Get the announcement data from Inertia's page props.
const { props } = usePage();
const announcement = props.announcement;

// Initialize the form with the existing announcement data.
const form = useForm({
    department: announcement.department,
    publisher: announcement.publisher,
    publication_date: announcement.publication_date,
    content_type: announcement.content_type,
    image: null, // New image file (if updating image)
    // For text content, headline and body are provided.
    headline: announcement.headline || '',
    body: announcement.body || '',
});

// Handle file selection for image uploads.
const handleImageUpload = (event) => {
    form.image = event.target.files[0];
};

// Submit the update via Inertia's form.put method.
const submit = () => {
    form.put(route('announcements.update', announcement.id));
};

// Navigate back to the announcements index.
const goBack = () => {
    form.get(route('announcements'));
};
</script>

<template>
    <div>

        <Head title="Edit Announcement" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Announcement</h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <form @submit.prevent="submit">
                                <!-- Department Dropdown -->
                                <div class="mb-4">
                                    <label for="department" class="block text-gray-700 text-sm font-bold mb-2">
                                        Department
                                    </label>
                                    <select id="department" v-model="form.department"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                        <option value="" disabled>Select Department</option>
                                        <option value="ccs">CCS</option>
                                        <option value="coe">COE</option>
                                        <option value="coed">COED</option>
                                        <option value="cbaa">CBAA</option>
                                    </select>
                                </div>

                                <!-- Publisher Input -->
                                <div class="mb-4">
                                    <label for="publisher" class="block text-gray-700 text-sm font-bold mb-2">
                                        Publisher
                                    </label>
                                    <input id="publisher" type="text" v-model="form.publisher"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required />
                                </div>

                                <!-- Publication Date -->
                                <div class="mb-4">
                                    <label for="publication_date" class="block text-gray-700 text-sm font-bold mb-2">
                                        Publication Date
                                    </label>
                                    <input id="publication_date" type="date" v-model="form.publication_date"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required />
                                </div>

                                <!-- Content Type Selector -->
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        Content Type
                                    </label>
                                    <select v-model="form.content_type"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="text">Text</option>
                                        <option value="image">Image</option>
                                    </select>
                                </div>

                                <!-- Conditional Inputs -->
                                <!-- If content type is image, show file upload -->
                                <div v-if="form.content_type === 'image'" class="mb-4">
                                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">
                                        Upload Image (leave blank to keep current image)
                                    </label>
                                    <input id="image" type="file" @change="handleImageUpload"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        accept="image/*" />
                                </div>

                                <!-- If content type is text, show Headline and Body inputs -->
                                <div v-if="form.content_type === 'text'">
                                    <div class="mb-4">
                                        <label for="headline" class="block text-gray-700 text-sm font-bold mb-2">
                                            Headline
                                        </label>
                                        <input id="headline" type="text" v-model="form.headline"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            required />
                                    </div>
                                    <div class="mb-4">
                                        <label for="body" class="block text-gray-700 text-sm font-bold mb-2">
                                            Body
                                        </label>
                                        <textarea rows="5" id="body" v-model="form.body"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            required></textarea>
                                    </div>
                                </div>

                                <!-- Buttons: Submit and Back -->
                                <div class="flex justify-between items-center">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Update Announcement
                                    </button>
                                    <button type="button" @click="goBack"
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Back
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
