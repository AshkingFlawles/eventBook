<template>
  <!-- Container for managing venues -->
  <div class="p-6 bg-white rounded shadow-md max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Manage Venues</h1>
    <!-- Loading indicator -->
    <div v-if="loading" class="text-gray-500">Loading venues...</div>
    <!-- Venues table -->
    <table v-else class="min-w-full border border-gray-300 rounded">
      <thead>
        <tr class="bg-gray-100">
          <th class="border border-gray-300 px-4 py-2">Venue Name</th>
          <th class="border border-gray-300 px-4 py-2">Location</th>
          <th class="border border-gray-300 px-4 py-2">Capacity</th>
          <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="venue in venues" :key="venue.id" class="hover:bg-gray-50">
          <td class="border border-gray-300 px-4 py-2">{{ venue.name ? venue.name : '' }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ venue.location ? venue.location : '' }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ venue.capacity ? venue.capacity : '' }}</td>
          <td class="border border-gray-300 px-4 py-2">
            <button @click="editVenue(venue)" class="text-blue-600 hover:underline mr-2">Edit</button>
            <button @click="deleteVenue(venue.id)" class="text-red-600 hover:underline">Delete</button>
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
      venues: [], // List of venues
      loading: true, // Loading state
      message: '' // Success or error message
    };
  },
  async created() {
    await this.fetchVenues(); // Fetch venues on component creation
  },
  methods: {
    // Fetch venues from backend API
    async fetchVenues() {
      try {
        const response = await this.$axios.get('/api/venues');
        this.venues = response.data;
      } catch (error) {
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
    // Placeholder for editing venue
    editVenue(venue) {
      alert('Edit venue: ' + venue.name);
    },
    // Delete venue by ID
    async deleteVenue(id) {
      if (!confirm('Are you sure you want to delete this venue?')) return;
      try {
        await this.$axios.delete(`/api/venues/${id}`);
        this.message = 'Venue deleted successfully.';
        await this.fetchVenues(); // Refresh venues list
      } catch (error) {
        this.message = 'Error deleting venue.';
        console.error(error);
      }
    }
  }
};
</script>
