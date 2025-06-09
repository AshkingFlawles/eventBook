<template>
  <div class="w-64 bg-white shadow-md h-full p-4 mt-28">
    <h2 class="text-xl font-bold mb-6">Dashboard Menu</h2>
    <ul>
      <li
        v-for="item in menuItems"
        :key="item.name"
        @click="selectItem(item.name)"
        :class="[
          'cursor-pointer p-2 rounded mb-2',
          selected === item.name
            ? 'bg-blue-500 text-white'
            : 'text-gray-700 hover:bg-blue-100'
        ]"
      >
        {{ item.label }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'Sidebar',
  props: {
    selected: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      menuItems: [
        { name: 'dashboardHome', label: 'Dashboard Home' },
        { name: 'createVenue', label: 'Create Venue' },
        { name: 'manageEvents', label: 'Manage Events' },
        { name: 'manageVenues', label: 'Manage Venues' },
        { name: 'createEvent', label: 'Create Event' }
      ]
    };
  },
  methods: {
    selectItem(itemName) {
      this.$emit('select', itemName);
    }
  }
};
</script>

<style scoped>
/* Add some hover effects */
li:hover {
  transition: background-color 0.3s ease;
}
</style>
