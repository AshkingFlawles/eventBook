<template>
  <div class="min-h-screen bg-gradient-to-b from-pink-100 via-purple-100 to-indigo-200 p-8">
    <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-12">Discover Events & Venues</h1>

    <section class="mb-16">
      <h2 class="text-3xl font-semibold text-gray-700 mb-6">Upcoming Events</h2>
      <div v-if="events.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div v-for="event in events" :key="event.id" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
          <div class="p-6">
            <h3 class="text-xl font-bold text-indigo-600 mb-2 truncate">{{ event.title }}</h3>
            <p class="text-gray-600 mb-3 line-clamp-3">{{ event.description }}</p>
            <p class="text-sm text-gray-500 mb-1"><i class="fa fa-calendar-alt mr-2"></i>{{ formatDate(event.start_time) }} - {{ formatDate(event.end_time) }}</p>
            <p class="text-sm text-gray-500"><i class="fa fa-map-marker-alt mr-2"></i>{{ event.venue ? event.venue.name : 'No venue info' }}</p>
            <button
              @click="openBookingWidget(event, 'Event')"
              class="mt-4 w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition"
            >
              Book Now
            </button>
          </div>
        </div>
      </div>
      <p v-else class="text-center text-gray-500">No upcoming events found.</p>
    </section>

    <section>
      <h2 class="text-3xl font-semibold text-gray-700 mb-6">Featured Venues</h2>
      <div v-if="venues.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div v-for="venue in venues" :key="venue.id" class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
          <div class="p-6">
            <h3 class="text-xl font-bold text-green-600 mb-2 truncate">{{ venue.name }}</h3>
            <p class="text-gray-600 mb-3 line-clamp-3">{{ venue.description || 'No description available.' }}</p>
            <p class="text-sm text-gray-500 mb-1"><i class="fa fa-map-marker-alt mr-2"></i>{{ venue.city }}, {{ venue.country }}</p>
            <p class="text-sm text-gray-500"><i class="fa fa-dollar-sign mr-2"></i>Pricing: {{ formatPrice(venue) }}</p>
            <button
              @click="openBookingWidget(venue, 'Venue')"
              class="mt-4 w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
            >
              Book Now
            </button>
          </div>
        </div>
      </div>
      <p v-else class="text-center text-gray-500">No venues found.</p>
    </section>

    <BookingWidget
      :visible="bookingWidgetVisible"
      :item="selectedItem"
      :itemType="selectedItemType"
      @close="bookingWidgetVisible = false"
      @booked="handleBookingSuccess"
    />
  </div>
</template>

<script>
import axios from 'axios';
import BookingWidget from './BookingWidget.vue';

export default {
  name: 'HomePage',
  components: {
    BookingWidget,
  },
  data() {
    return {
      events: [],
      venues: [],
      bookingWidgetVisible: false,
      selectedItem: null,
      selectedItemType: '',
    };
  },
  methods: {
    async fetchEvents() {
      try {
        const response = await axios.get('/api/events');
        this.events = response.data;
      } catch (error) {
        console.error('Failed to fetch events:', error);
      }
    },
    async fetchVenues() {
      try {
        const response = await axios.get('/api/venues');
        this.venues = response.data;
      } catch (error) {
        console.error('Failed to fetch venues:', error);
      }
    },
    formatDate(dateStr) {
      const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateStr).toLocaleDateString(undefined, options);
    },
    formatPrice(venue) {
      if (venue.price_per_hour) return `$${venue.price_per_hour}/hr`;
      if (venue.price_per_day) return `$${venue.price_per_day}/day`;
      if (venue.price_per_week) return `$${venue.price_per_week}/week`;
      if (venue.price_per_month) return `$${venue.price_per_month}/month`;
      return 'Contact for pricing';
    },
    openBookingWidget(item, itemType) {
      this.selectedItem = item;
      this.selectedItemType = itemType;
      this.bookingWidgetVisible = true;
    },
    handleBookingSuccess(booking) {
      this.bookingWidgetVisible = false;
      // Optionally refresh data or show notification
      alert('Booking successful!');
    },
  },
  mounted() {
    this.fetchEvents();
    this.fetchVenues();
  }
};
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
</style>
