<template>
  <!-- Dashboard Grid: Responsive layout for cards and components -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    
    <!-- Stats Card: Total Events -->
    <div class="bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-2">Total Events</h2>
      <p class="text-4xl font-bold text-blue-600">58</p>
    </div>

    <!-- Stats Card: Total Venues -->
    <div class="bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-2">Total Venues</h2>
      <p class="text-4xl font-bold text-green-600">12</p>
    </div>

    <!-- Stats Card: Total Bookings -->
    <div class="bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-2">Total Bookings</h2>
      <p class="text-4xl font-bold text-purple-600">1023</p>
    </div>

    <!-- Weather Widget: Occupies 1 card space -->
    <WeatherWidget />

    <!-- Booking Trends Chart: Spans across 3 columns on large screens -->
    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-4">Booking Trends</h2>
      <BookingTrendsChart />
    </div>

    <!-- Recent Activities Log: Spans across 3 columns on large screens -->
    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-4">Recent Activities</h2>
      <ul class="space-y-2 text-gray-700">
        <li>🎉 New booking for "Jazz Night" at Downtown Venue</li>
        <li>🏟 Venue "Skyline Hall" added</li>
        <li>📅 Event "Tech Meetup" updated</li>
      </ul>
    </div>
    
  </div>
</template>

<script>
// Import subcomponents used on the dashboard home
import BookingTrendsChart from './BookingTrendsChart.vue';
import WeatherWidget from './WeatherWidget.vue';

export default {
  components: {
    BookingTrendsChart,
    WeatherWidget
  }
};
</script>
