<template>
  <div class="container mx-auto p-4">
    <!-- Header with dynamic text based on whether we're editing or creating -->
    <h1 class="text-2xl font-bold mb-4">{{ isEditing ? 'Edit Venue' : 'Create New Venue' }}</h1>

    <!-- Form for submitting venue details -->
    <form @submit.prevent="submitVenue" class="space-y-4">
      
      <!-- Venue Name input -->
      <div>
        <label for="name" class="block font-medium mb-1">Venue Name</label>
        <input
          id="name"
          v-model="formData.name" 
          type="text" 
          required
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
      </div>

      <!-- Description input -->
      <div>
        <label for="description" class="block font-medium mb-1">Description</label>
        <textarea
          id="description"
          v-model="formData.description"
          rows="4"
          class="w-full border border-gray-300 rounded px-3 py-2 resize-none"
          placeholder="Enter venue description"
        ></textarea>
      </div>

      <!-- Venue Type dropdown -->
      <div>
        <label for="type" class="block font-medium mb-1">Venue Type</label>
        <select
          id="type"
          v-model="formData.type"
          required
          class="w-full border border-gray-300 rounded px-3 py-2"
        >
          <option value="" disabled>Select a type</option>
          <option value="conference_room">Conference Room</option>
          <option value="wedding_marquee">Wedding Marquee</option>
          <option value="open_space">Open Space</option>
          <option value="theater">Theater</option>
          <option value="gallery">Gallery</option>
        </select>
      </div>

      <!-- Price per hour input -->
      <div>
        <label for="price_per_hour" class="block font-medium mb-1">Price Per Hour (USD)</label>
        <input
          id="price_per_hour"
          v-model.number="formData.price_per_hour"
          type="number"
          min="0"
          step="0.01"
          required
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
      </div>

      <!-- Wheelchair and Parking checkboxes -->
      <div class="flex items-center space-x-4">
        <label class="inline-flex items-center">
          <input
            type="checkbox"
            v-model="formData.wheelchair_accessible"
            class="form-checkbox"
          />
          <span class="ml-2">Wheelchair Accessible</span>
        </label>

        <label class="inline-flex items-center">
          <input
            type="checkbox"
            v-model="formData.parking_available"
            class="form-checkbox"
          />
          <span class="ml-2">Parking Available</span>
        </label>
      </div>

      <!-- Submit and Cancel buttons -->
      <div class="flex space-x-2">
        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          {{ isEditing ? 'Update Venue' : 'Create Venue' }}
        </button>

        <!-- Cancel button shown only when editing -->
        <button
          v-if="isEditing"
          type="button"
          @click="cancelEdit"
          class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
        >
          Cancel
        </button>
      </div>
    </form>

    <!-- Message area for success/error notifications -->
    <div v-if="message" class="mt-4 p-3 rounded" :class="messageClass">
      {{ message }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'CreateVenue', // Component name
  props: {
    // Accepting venue as a prop to handle editing
    venue: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      // Form data initialized as empty or false values
      formData: {
        name: '',
        description: '',
        type: '',
        price_per_hour: null,
        wheelchair_accessible: false,
        parking_available: false,
      },
      // Message to show on success or error
      message: '',
      messageClass: '' // Dynamic class for message styling
    };
  },
  computed: {
    // Determine if we're in editing mode based on the venue prop
    isEditing() {
      return this.venue && this.venue.id;
    }
  },
  watch: {
    // Watch for changes to the venue prop to update formData
    venue: {
      handler(newVenue) {
        console.log('Venue prop changed:', newVenue);
        if (newVenue && newVenue.id) {
          // Populate formData if editing an existing venue
          this.formData = {
            id: newVenue.id,
            name: newVenue.name || '',
            description: newVenue.description || '',
            type: newVenue.type || '',
            price_per_hour: parseFloat(newVenue.price_per_hour) || null,
            wheelchair_accessible: Boolean(newVenue.wheelchair_accessible),
            parking_available: Boolean(newVenue.parking_available),
          };
          console.log('Form data populated:', this.formData);
        } else {
          // Reset form data if no venue is provided
          this.resetForm();
        }
      },
      immediate: true,
      deep: true
    }
  },
  mounted() {
    // Handle mounted lifecycle hook for initial venue population
    if (this.venue && this.venue.id) {
      console.log('Mounted with venue:', this.venue);
      this.formData = {
        id: this.venue.id,
        name: this.venue.name || '',
        description: this.venue.description || '',
        type: this.venue.type || '',
        price_per_hour: parseFloat(this.venue.price_per_hour) || null,
        wheelchair_accessible: Boolean(this.venue.wheelchair_accessible),
        parking_available: Boolean(this.venue.parking_available),
      };
    }
  },
  methods: {
    // Handle form submission (create or update venue)
    async submitVenue() {
      try {
        // CSRF token to prevent security issues
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        let response;
        // Check if we're editing or creating
        if (this.isEditing) {
          response = await fetch(`/api/venues/${this.formData.id}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(this.formData),
          });
        } else {
          response = await fetch('/api/venues', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(this.formData),
          });
        }

        // Parse response and show appropriate message
        const data = await response.json();
        
        if (response.ok) {
          this.message = this.isEditing ? 'Venue updated successfully!' : 'Venue created successfully!';
          this.messageClass = 'bg-green-100 text-green-700';
          
          if (this.isEditing) {
            // Emit updated venue data if editing
            this.$emit('updated', data.data);
          } else {
            // Reset form if created
            this.resetForm();
          }
        } else {
          // Error handling
          this.message = 'Failed to ' + (this.isEditing ? 'update' : 'create') + ' venue: ' + (data.message || 'Unknown error');
          this.messageClass = 'bg-red-100 text-red-700';
        }
      } catch (error) {
        // Catch any unexpected errors
        this.message = 'Error: ' + error.message;
        this.messageClass = 'bg-red-100 text-red-700';
      }
    },
    
    // Reset the form to initial empty state
    resetForm() {
      this.formData = {
        name: '',
        description: '',
        type: '',
        price_per_hour: null,
        wheelchair_accessible: false,
        parking_available: false,
      };
      this.message = ''; // Clear message
    },
    
    // Handle cancel button click to emit a cancel event
    cancelEdit() {
      this.$emit('cancel');
    }
  }
};
</script>

<style scoped>
/* Add any scoped styles here if needed */
</style>
