<template>
    <div class="max-w-4xl mx-auto mt-8 p-4">
        <h1 class="text-3xl font-bold mb-6">Messages</h1>

        <!-- Display messages -->
        <div class="space-y-4">
            <div v-for="message in messages" :key="message.id"
                class="flex justify-between items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <span class="text-lg text-gray-800">{{ message.message }}</span>
                <button @click="deleteMessage(message.id)"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Delete
                </button>
            </div>
        </div>

        <!-- Add new message -->
        <form @submit.prevent="submitMessage" class="mt-6">
            <div class="flex space-x-4">
                <input v-model="newMessage" type="text" class="form-input px-4 py-2 border rounded-lg w-full"
                    placeholder="Enter a new message" required />
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Add Message
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        messages: Array,
    },
    data() {
        return {
            newMessage: '',
        };
    },
    methods: {
        async submitMessage() {
            if (this.newMessage) {
                await this.$inertia.post('/messages', { message: this.newMessage });
                this.newMessage = ''; // Reset the input field
            }
        },
        async deleteMessage(id) {
            if (confirm('Are you sure you want to delete this message?')) {
                await this.$inertia.delete(`/messages/${id}`);
            }
        },
    },
};
</script>

<style scoped>
/* Add some custom styling if needed */
</style>
