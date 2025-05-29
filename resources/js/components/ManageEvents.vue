<template>
  <!-- Container for managing events -->
  <div class="p-6 bg-white rounded shadow-md max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Manage Events</h1>
    <!-- Loading indicator -->
    <div v-if="loading" class="text-gray-500">Loading events...</div>
    <!-- Events table -->
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
    <!-- Message display -->
    <div v-if="message" class="mt-4 p-3 bg-green-100 text-green-700 rounded">{{ message }}</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      events: [], // List of events
      loading: true, // Loading state
      message: '' // Success or error message
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
        this.events = response.data;
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
    // Placeholder for editing event
    editEvent(event) {
      alert('Edit event: ' + event.name);
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

