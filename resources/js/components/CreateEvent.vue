<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Create New Event</h1>
    
    <!-- Show validation errors -->
    <div v-if="errors.length > 0" class="mb-4 p-3 bg-red-100 text-red-700 rounded">
      <ul>
        <li v-for="error in errors" :key="error">{{ error }}</li>
      </ul>
    </div>

    <form @submit.prevent="submitEvent" class="space-y-4">
      <div>
        <label for="title" class="block font-medium mb-1">Event Title *</label>
        <input
          id="title"
          v-model="event.title"
          type="text"
          required
          class="w-full border border-gray-300 rounded px-3 py-2"
          :class="{ 'border-red-500': !event.title.trim() }"
        />
        <span v-if="!event.title.trim()" class="text-red-500 text-sm">Title is required</span>
      </div>

      <div>
        <label for="description" class="block font-medium mb-1">Description *</label>
        <textarea
          id="description"
          v-model="event.description"
          rows="4"
          required
          class="w-full border border-gray-300 rounded px-3 py-2 resize-none"
          placeholder="Enter event description"
          :class="{ 'border-red-500': !event.description.trim() }"
        ></textarea>
        <span v-if="!event.description.trim()" class="text-red-500 text-sm">Description is required</span>
      </div>

      <div>
        <label for="venue_id" class="block font-medium mb-1">Select Venue *</label>
        <select
          id="venue_id"
          v-model="event.venue_id"
          required
          class="w-full border border-gray-300 rounded px-3 py-2"
          :class="{ 'border-red-500': !event.venue_id }"
        >
          <option value="" disabled>Select a venue</option>
          <option v-for="venue in venues" :key="venue.id" :value="venue.id">
            {{ venue.name }} - ${{ venue.price_per_hour }}/hour
          </option>
        </select>
        <span v-if="!event.venue_id" class="text-red-500 text-sm">Please select a venue</span>

        <div v-if="selectedVenue" class="mt-2 p-2 border border-gray-300 rounded bg-gray-50">
          <h3 class="font-semibold mb-1">Venue Features:</h3>
          <ul class="list-disc list-inside text-sm text-gray-700">
            <li v-if="selectedVenue.wheelchair_accessible">Wheelchair Accessible</li>
            <li v-if="selectedVenue.parking_available">Parking Available</li>
            <li v-if="!selectedVenue.wheelchair_accessible && !selectedVenue.parking_available">No special features listed.</li>
          </ul>
        </div>

        <div class="mt-4">
          <label class="inline-flex items-center">
            <input type="checkbox" v-model="event.is_ticketed" class="form-checkbox" />
            <span class="ml-2">Is Ticketed Event</span>
          </label>
        </div>

        <div v-if="event.is_ticketed" class="mt-4">
          <label for="ticket_price" class="block font-medium mb-1">Ticket Price *</label>
          <input
            id="ticket_price"
            v-model.number="event.ticket_price"
            type="number"
            min="0"
            step="0.01"
            required
            class="w-full border border-gray-300 rounded px-3 py-2"
          />
        </div>
      </div>

      <div>
        <label for="start_time" class="block font-medium mb-1">Start Time *</label>
        <input
          id="start_time"
          v-model="event.start_time"
          type="datetime-local"
          required
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
      </div>

      <div>
        <label for="end_time" class="block font-medium mb-1">End Time *</label>
        <input
          id="end_time"
          v-model="event.end_time"
          type="datetime-local"
          required
          class="w-full border border-gray-300 rounded px-3 py-2"
        />
      </div>

      <button
        type="submit"
        :disabled="!isFormValid"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
      >
        Create Event
      </button>
    </form>

    <div v-if="message" class="mt-4 p-3 rounded" :class="messageClass">
      {{ message }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'CreateEvent',
  props: {
    eventToEdit: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      event: {
        id: null,
        title: '',
        description: '',
        venue_id: '',
        start_time: '',
        end_time: '',
        is_ticketed: false,
      },
      venues: [],
      errors: [],
      message: '',
      messageClass: ''
    };
  },
  computed: {
    isFormValid() {
      return this.event.title.trim() && 
             this.event.description.trim() && 
             this.event.venue_id && 
             this.event.start_time && 
             this.event.end_time;
    },
    isEditing() {
      return this.event.id !== null;
    },
    selectedVenue() {
      return this.venues.find(v => v.id === this.event.venue_id) || null;
    }
  },
  watch: {
    eventToEdit: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.event = {
            id: newVal.id || null,
            title: newVal.title || '',
            description: newVal.description || '',
            venue_id: newVal.venue_id || '',
            start_time: newVal.start_time ? newVal.start_time.substring(0,16) : '',
            end_time: newVal.end_time ? newVal.end_time.substring(0,16) : '',
            is_ticketed: newVal.is_ticketed || false,
            ticket_price: newVal.ticket_price || null,
          };
          this.message = '';
          this.errors = [];
        } else {
          this.resetForm();
        }
      }
    }
  },
  async created() {
    await this.fetchVenues();
  },
  methods: {
    resetForm() {
      this.event = {
        id: null,
        title: '',
        description: '',
        venue_id: '',
        start_time: '',
        end_time: '',
        is_ticketed: false,
      };
      this.errors = [];
      this.message = '';
      this.messageClass = '';
    },
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
        this.messageClass = 'bg-red-100 text-red-700';
      }
    },

    validateForm() {
      this.errors = [];
      
      if (!this.event.title.trim()) {
        this.errors.push('Event title is required');
      }
      
      if (!this.event.description.trim()) {
        this.errors.push('Event description is required');
      }
      
      if (!this.event.venue_id) {
        this.errors.push('Please select a venue');
      }
      
      if (!this.event.start_time) {
        this.errors.push('Start time is required');
      }
      
      if (!this.event.end_time) {
        this.errors.push('End time is required');
      }
      
      if (this.event.start_time && this.event.end_time && 
          new Date(this.event.start_time) >= new Date(this.event.end_time)) {
        this.errors.push('End time must be after start time');
      }
      
      return this.errors.length === 0;
    },

    async submitEvent() {
      // Clear previous errors
      this.errors = [];
      this.message = '';
      
      // Validate form
      if (!this.validateForm()) {
        return;
      }

      try {
        console.log('Sending event data:', this.event); // Debug log

        const url = this.isEditing ? `/api/events/${this.event.id}` : '/api/events';
        const method = this.isEditing ? 'PUT' : 'POST';

        const response = await fetch(url, {
          method: method,
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(this.event),
        });

        const data = await response.json();
        
        if (response.ok) {
          this.message = this.isEditing ? 'Event updated successfully!' : 'Event created successfully!';
          this.messageClass = 'bg-green-100 text-green-700';
          
          // Reset form if creating new event
          if (!this.isEditing) {
            this.resetForm();
          }
          
          // Emit event to notify parent of success
          this.$emit('eventSaved', data.data || data);
        } else {
          // Handle validation errors from backend
          if (data.errors) {
            this.errors = Object.values(data.errors).flat();
          } else {
            this.message = 'Failed to save event: ' + (data.message || 'Unknown error');
            this.messageClass = 'bg-red-100 text-red-700';
          }
        }
      } catch (error) {
        this.message = 'Error: ' + error.message;
        this.messageClass = 'bg-red-100 text-red-700';
      }
    },
  },
};
</script>
