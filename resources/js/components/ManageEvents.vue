<template>
  <div class="p-6 bg-white rounded shadow-md max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Manage Events</h1>
    <div v-if="loading" class="text-gray-500">Loading events...</div>
    <table v-else class="min-w-full border border-gray-300 rounded">
      <thead>
        <tr class="bg-gray-100">
          <th class="border border-gray-300 px-4 py-2">Event Name</th>
          <th class="border border-gray-300 px-4 py-2">Date</th>
          <th class="border border-gray-300 px-4 py-2">Venue</th>
          <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="event in events" :key="event.id" class="hover:bg-gray-50">
          <td class="border border-gray-300 px-4 py-2">{{ event.title ? event.title : '' }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ event.start_time ? new Date(event.start_time).toLocaleString() : '' }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ event.venue ? event.venue.name : '' }}</td>
          <td class="border border-gray-300 px-4 py-2">
            <button @click="editEvent(event)" class="text-blue-600 hover:underline mr-2">Edit</button>
            <button @click="deleteEvent(event.id)" class="text-red-600 hover:underline">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="message" class="mt-4 p-3 bg-green-100 text-green-700 rounded">{{ message }}</div>

    <!-- Edit Event Modal -->
    <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded shadow-lg p-6 w-full max-w-3xl relative">
        <button @click="closeEditModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
        <CreateEvent :eventToEdit="eventToEdit" @eventSaved="onEventUpdated" />
      </div>
    </div>
  </div>
</template>

<script>
import CreateEvent from './CreateEvent.vue';

export default {
  components: {
    CreateEvent,
  },
  data() {
    return {
      events: [], // List of events
      loading: true, // Loading state
      message: '', // Success or error message
      showEditModal: false,
      eventToEdit: null,
    };
  },
  async created() {
    await this.fetchEvents(); // Fetch events on component creation
  },
  methods: {
    // Fetch events from backend API
    async fetchEvents() {
      try {
        const response = await this.$axios.get('/api/events');
        this.events = response.data.data;
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
    // Open edit modal with selected event
    editEvent(event) {
      this.eventToEdit = { ...event };
      this.showEditModal = true;
    },
    // Close edit modal
    closeEditModal() {
      this.showEditModal = false;
      this.eventToEdit = null;
    },
    // Handle event updated from modal
    async onEventUpdated() {
      this.message = 'Event updated successfully.';
      this.closeEditModal();
      await this.fetchEvents();
    },
    // Delete event by ID
    async deleteEvent(id) {
      if (!confirm('Are you sure you want to delete this event?')) return;
      try {
        await this.$axios.delete(`/api/events/${id}`);
        this.message = 'Event deleted successfully.';
        await this.fetchEvents(); // Refresh events list
      } catch (error) {
        this.message = 'Error deleting event.';
        console.error(error);
      }
    }
  }
};
</script>
