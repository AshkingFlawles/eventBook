<template>
  <!-- Sidebar container with fixed width and styling -->
  <div class="w-64 bg-white shadow-md h-full p-4">
    <!-- Dashboard title -->
    <h2 class="text-xl font-bold mb-6">Dashboard</h2>
    <ul>
      <!-- Loop through menu items and render each as a clickable list item -->
      <li
        v-for="item in menuItems"
        :key="item.name"
        @click="$emit('select', item.name)" 
        :class="[
          'cursor-pointer p-2 rounded mb-2',  /* Base styles for list items */
          selected === item.name ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-blue-100'  /* Highlight selected item */
        ]"
      >
        {{ item.label }} <!-- Display menu label -->
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    // The currently selected menu item name, required for highlighting
    selected: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      // Define the sidebar menu items with internal names and display labels
      menuItems: [
        { name: 'createVenue', label: 'Create Venue' },
        { name: 'manageEvents', label: 'Manage Events' },
        { name: 'createEvent', label: 'Create Event' },
        { name: 'dashboardHome', label: 'Dashboard Home' }
      ]
    };
  }
};
</script>

<style scoped>
/* Scoped styles can be added here if needed */
</style>
