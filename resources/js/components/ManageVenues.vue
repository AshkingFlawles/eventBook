<template>
  <div class="p-6 bg-white rounded shadow-md max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Manage Venues</h1>
    
    <div v-if="loading" class="text-gray-500">Loading venues...</div>
    
    <table v-else class="min-w-full border border-gray-300 rounded">
      <thead>
        <tr class="bg-gray-100">
          <th class="border border-gray-300 px-4 py-2">Venue Name</th>
          <th class="border border-gray-300 px-4 py-2">Type</th>
          <th class="border border-gray-300 px-4 py-2">Price/Hour</th>
          <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="venue in venues" :key="venue.id" class="hover:bg-gray-50">
          <td class="border border-gray-300 px-4 py-2">{{ venue.name || '' }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ venue.type || '' }}</td>
          <td class="border border-gray-300 px-4 py-2">${{ venue.price_per_hour || '0' }}</td>
          <td class="border border-gray-300 px-4 py-2">
            <button @click="editVenue(venue)" class="text-blue-600 hover:underline mr-2">
              Edit
            </button>
            <button @click="deleteVenue(venue.id)" class="text-red-600 hover:underline">
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <div v-if="message" class="mt-4 p-3 bg-green-100 text-green-700 rounded">
      {{ message }}
    </div>

    <!-- Edit Venue Modal -->
    <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded shadow-lg p-6 w-full max-w-3xl relative max-h-screen overflow-y-auto">
        <button @click="closeEditModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl">
          &times;
        </button>
        <CreateVenue 
          :venue="venueToEdit" 
          @updated="onVenueUpdated" 
          @cancel="closeEditModal"
        />
      </div>
    </div>
  </div>
</template>

<script>
import CreateVenue from './CreateVenue.vue';

export default {
  components: {
    CreateVenue,
  },
  data() {
    return {
      venues: [],
      loading: true,
      message: '',
      showEditModal: false,
      venueToEdit: null,
    };
  },
  async created() {
    await this.fetchVenues();
  },
  methods: {
    async fetchVenues() {
      try {
        const response = await fetch('/api/venues', {
          headers: {
            'Accept': 'application/json',
          }
        });
        const data = await response.json();
        this.venues = data;
      } catch (error) {
        console.error('Error fetching venues:', error);
        this.message = 'Error loading venues';
      } finally {
        this.loading = false;
      }
    },

    editVenue(venue) {
      console.log('Editing venue:', venue); // Debug log
      // Create a deep copy to avoid reactivity issues
      this.venueToEdit = JSON.parse(JSON.stringify(venue));
      this.showEditModal = true;
      
      // Force reactivity update
      this.$nextTick(() => {
        console.log('Modal opened with venue:', this.venueToEdit);
      });
    },

    closeEditModal() {
      this.showEditModal = false;
      this.venueToEdit = null;
    },

    async onVenueUpdated() {
      this.message = 'Venue updated successfully.';
      this.closeEditModal();
      await this.fetchVenues();
      
      // Clear message after 3 seconds
      setTimeout(() => {
        this.message = '';
      }, 3000);
    },

    async deleteVenue(id) {
      if (!confirm('Are you sure you want to delete this venue?')) return;

      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch(`/api/venues/${id}`, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
          }
        });

        const data = await response.json();
        
        if (response.ok) {
          this.message = 'Venue deleted successfully.';
          await this.fetchVenues();
        } else {
          this.message = 'Error deleting venue: ' + (data.message || 'Unknown error');
        }
      } catch (error) {
        this.message = 'Error deleting venue.';
        console.error(error);
      }

      // Clear message after 3 seconds
      setTimeout(() => {
        this.message = '';
      }, 3000);
    }
  }
};
</script>
