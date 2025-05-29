<template>
  <!-- Container for the Create Event form -->
  <div class="p-6 bg-white rounded shadow-md max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Create Event</h1>
    <form @submit.prevent="submitEvent" class="flex flex-col space-y-4">
      <!-- Event Name input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Event Name</span>
        <input 
          v-model="event.name" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>
      
      <!-- Event Description input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Description</span>
        <textarea 
          v-model="event.description" 
          rows="4"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="Describe your event..."
          required
        ></textarea>
      </label>
      
      <!-- Event Type input -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Event Type</span>
        <select 
          v-model="event.event_type" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          required
        >
          <option disabled value="">Please select</option>
          <option value="wedding">Wedding</option>
          <option value="birthday">Birthday Party</option>
          <option value="corporate">Corporate Event</option>
          <option value="conference">Conference</option>
          <option value="workshop">Workshop</option>
          <option value="concert">Concert</option>
          <option value="exhibition">Exhibition</option>
          <option value="graduation">Graduation</option>
          <option value="anniversary">Anniversary</option>
          <option value="other">Other</option>
        </select>
      </label>
      
      <!-- Custom event type -->
      <label v-if="event.event_type === 'other'" class="block">
        <span class="text-gray-700 font-semibold">Custom Event Type</span>
        <input 
          v-model="event.custom_event_type" 
          type="text" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>

      <!-- Date and Time inputs -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Start Date</span>
          <input 
            v-model="event.start_date" 
            type="date" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            required
          />
        </label>
        
        <label class="block">
          <span class="text-gray-700 font-semibold">Start Time</span>
          <input 
            v-model="event.start_time" 
            type="time" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            required
          />
        </label>
        
        <label class="block">
          <span class="text-gray-700 font-semibold">End Date</span>
          <input 
            v-model="event.end_date" 
            type="date" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            required
          />
        </label>
        
        <label class="block">
          <span class="text-gray-700 font-semibold">End Time</span>
          <input 
            v-model="event.end_time" 
            type="time" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
            required
          />
        </label>
      </div>

      <!-- Venue Selection -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Venue</span>
        <select 
          v-model="event.venue_id" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          required
        >
          <option disabled value="">Please select a venue</option>
          <option v-for="venue in venues" :key="venue.id" :value="venue.id">
            {{ venue.name }} - {{ venue.city }}
          </option>
        </select>
      </label>

      <!-- Expected Attendees -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Expected Attendees</span>
        <input 
          v-model.number="event.expected_attendees" 
          type="number" 
          min="1"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          required
        />
      </label>

      <!-- Budget -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Budget</span>
        <input 
          v-model.number="event.budget" 
          type="number" 
          step="0.01" 
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
        />
      </label>

      <!-- Event Status -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Status</span>
        <select 
          v-model="event.status" 
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
        >
          <option value="draft">Draft</option>
          <option value="published">Published</option>
          <option value="cancelled">Cancelled</option>
          <option value="completed">Completed</option>
        </select>
      </label>

      <!-- Event Requirements -->
      <div class="block">
        <span class="text-gray-700 font-semibold">Event Requirements</span>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.catering_required" class="rounded" />
            <i class="fas fa-utensils fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Catering Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.decoration_required" class="rounded" />
            <i class="fas fa-paint-roller fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Decoration Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.sound_system_required" class="rounded" />
            <i class="fas fa-volume-up fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Sound System Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.photography_required" class="rounded" />
            <i class="fas fa-camera fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Photography Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.security_required" class="rounded" />
            <i class="fas fa-shield-alt fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Security Required</span>
          </label>
          <label class="flex items-center space-x-2">
            <input type="checkbox" v-model="event.parking_required" class="rounded" />
            <i class="fas fa-parking fa-lg text-blue-600"></i>
            <span class="text-gray-700 font-medium">Parking Required</span>
          </label>
        </div>
      </div>

      <!-- Special Instructions -->
      <label class="block">
        <span class="text-gray-700 font-semibold">Special Instructions</span>
        <textarea 
          v-model="event.special_instructions" 
          rows="3"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          placeholder="Any special requirements or instructions..."
        ></textarea>
      </label>

      <!-- Contact Information -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="block">
          <span class="text-gray-700 font-semibold">Contact Email</span>
          <input 
            v-model="event.contact_email" 
            type="email" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          />
        </label>
        
        <label class="block">
          <span class="text-gray-700 font-semibold">Contact Phone</span>
          <input 
            v-model="event.contact_phone" 
            type="tel" 
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
          />
        </label>
      </div>

      <!-- Is Public Event -->
      <label class="flex items-center space-x-2">
        <input type="checkbox" v-model="event.is_public" class="rounded" />
        <span class="text-gray-700 font-medium">This is a public event</span>
      </label>

      <!-- Submit button -->
      <button 
        type="submit" 
        :disabled="isSubmitting"
        class="bg-blue-500 text-white py-2 px-4 rounded font-bold hover:bg-blue-600 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors"
      >
        {{ isSubmitting ? 'Creating...' : 'Create Event' }}
      </button>
    </form>
    
    <!-- Success or error message -->
    <div 
      v-if="message" 
      :class="messageClass"
      class="mt-4 p-3 rounded transition-all duration-300"
    >
      {{ message }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'CreateEvent',
  data() {
    return {
      isSubmitting: false,
      venues: [], // Will be populated from API
      event: {
        name: '',
        description: '',
        event_type: '',
        custom_event_type: '',
        start_date: '',
        start_time: '',
        end_date: '',
        end_time: '',
        venue_id: '',
        expected_attendees: null,
        budget: null,
        status: 'draft',
        catering_required: false,
        decoration_required: false,
        sound_system_required: false,
        photography_required: false,
        security_required: false,
        parking_required: false,
        special_instructions: '',
        contact_email: '',
        contact_phone: '',
        is_public: false,
        organizer_id: null // Set this dynamically if needed
      },
      message: ''
    };
  },
  computed: {
    messageClass() {
      return this.message.toLowerCase().includes('error')
        ? 'bg-red-100 text-red-700 border border-red-300'
        : 'bg-green-100 text-green-700 border border-green-300';
    }
  },
  async mounted() {
    await this.loadVenues();
  },
  methods: {
    async loadVenues() {
      try {
        const response = await this.$axios.get('/api/venues');
        this.venues = response.data;
      } catch (error) {
        console.error('Error loading venues:', error);
        this.message = 'Error loading venues. Please refresh the page.';
      }
    },

    async submitEvent() {
      this.isSubmitting = true;
      this.message = '';

      try {
        // Validation
        if (!this.event.name || !this.event.description || !this.event.event_type) {
          throw new Error('Please fill in all required fields.');
        }

        if (!this.event.start_date || !this.event.start_time || !this.event.end_date || !this.event.end_time) {
          throw new Error('Please provide complete date and time information.');
        }

        if (!this.event.venue_id) {
          throw new Error('Please select a venue.');
        }

        if (this.event.event_type === 'other' && !this.event.custom_event_type) {
          throw new Error('Please specify the custom event type.');
        }

        const startDateTime = new Date(`${this.event.start_date}T${this.event.start_time}`);
        const endDateTime = new Date(`${this.event.end_date}T${this.event.end_time}`);

        if (endDateTime <= startDateTime) {
          throw new Error('End date and time must be after start date and time.');
        }

        if (startDateTime < new Date()) {
          throw new Error('Event cannot be scheduled in the past.');
        }

        // Use custom event type if selected
        const payload = {
          ...this.event,
          event_type:
            this.event.event_type === 'other'
              ? this.event.custom_event_type
              : this.event.event_type
        };

        const response = await this.$axios.post('/api/events', payload);

        this.message = 'Event created successfully!';
        this.resetForm();
      } catch (error) {
        console.error(error);
        this.message = error.response?.data?.message || error.message || 'Error creating event.';
      } finally {
        this.isSubmitting = false;
      }
    },

    resetForm() {
      this.event = {
        name: '',
        description: '',
        event_type: '',
        custom_event_type: '',
        start_date: '',
        start_time: '',
        end_date: '',
        end_time: '',
        venue_id: '',
        expected_attendees: null,
        budget: null,
        status: 'draft',
        catering_required: false,
        decoration_required: false,
        sound_system_required: false,
        photography_required: false,
        security_required: false,
        parking_required: false,
        special_instructions: '',
        contact_email: '',
        contact_phone: '',
        is_public: false,
        organizer_id: null
      };
    }
  }
};
</script>
