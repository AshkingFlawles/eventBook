<template>
  <div v-if="visible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
      <h2 class="text-2xl font-bold mb-4">Book {{ itemType }}</h2>
      <form @submit.prevent="submitBooking">
        <div v-if="itemType === 'Event'" class="mb-4">
          <label class="block text-gray-700 mb-2" for="numTickets">Number of Tickets</label>
          <input
            id="numTickets"
            type="number"
            min="1"
            v-model.number="numTickets"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            required
          />
        </div>
        <div v-if="itemType === 'Venue'" class="mb-4">
          <p class="text-gray-700 mb-2">Booking a venue will be confirmed by the admin.</p>
        </div>
        <div class="flex justify-end space-x-4">
          <button
            type="button"
            @click="close"
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 focus:outline-none"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none"
          >
            Book Now
          </button>
        </div>
      </form>
      <p v-if="errorMessage" class="text-red-600 mt-4">{{ errorMessage }}</p>
      <p v-if="successMessage" class="text-green-600 mt-4">{{ successMessage }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'BookingWidget',
  props: {
    visible: {
      type: Boolean,
      required: true,
    },
    item: {
      type: Object,
      required: true,
    },
    itemType: {
      type: String,
      required: true, // 'Event' or 'Venue'
    },
  },
  data() {
    return {
      numTickets: 1,
      errorMessage: '',
      successMessage: '',
      loading: false,
    };
  },
  methods: {
    close() {
      this.$emit('close');
      this.errorMessage = '';
      this.successMessage = '';
      this.numTickets = 1;
    },
    async submitBooking() {
      this.errorMessage = '';
      this.successMessage = '';
      this.loading = true;
      try {
        const payload = {
          num_tickets: this.numTickets,
        };
        if (this.itemType === 'Event') {
          payload.event_id = this.item.id;
          payload.venue_id = null;
        } else if (this.itemType === 'Venue') {
          payload.venue_id = this.item.id;
          payload.event_id = null;
        }
        const response = await axios.post('/bookings', payload);
        this.successMessage = response.data.message || 'Booking successful!';
        this.$emit('booked', response.data.booking);
        setTimeout(() => {
          this.close();
        }, 2000);
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Failed to create booking.';
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
/* Add any additional styling if needed */
</style>
