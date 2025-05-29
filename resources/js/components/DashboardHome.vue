<!-- DashboardHome.vue -->
<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Stats Cards -->
    <div class="bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-2">Total Events</h2>
      <p class="text-4xl font-bold text-blue-600">58</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-2">Total Venues</h2>
      <p class="text-4xl font-bold text-green-600">12</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-2">Total Bookings</h2>
      <p class="text-4xl font-bold text-purple-600">1023</p>
    </div>
    <WeatherWidget />

    <!-- Booking Trends Chart Placeholder -->
    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-4">Booking Trends</h2>
      <BookingTrendsChart />
    </div>

    <!-- Recent Activities -->
    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white p-6 rounded-xl shadow-md">
      <h2 class="text-xl font-semibold mb-4">Recent Activities</h2>
      <ul class="space-y-2">
        <li class="text-gray-700">🎉 New booking for "Jazz Night" at Downtown Venue</li>
        <li class="text-gray-700">🏟 Venue "Skyline Hall" added</li>
        <li class="text-gray-700">📅 Event "Tech Meetup" updated</li>
      </ul>
    </div>
  </div>
</template>

<script>
import BookingTrendsChart from './BookingTrendsChart.vue';
import WeatherWidget from './WeatherWidget.vue';

export default {
  components: {
    BookingTrendsChart,
    WeatherWidget
  }
};
</script>
