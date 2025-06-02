<template>
  <div v-if="user" class="flex min-h-screen bg-gray-100">
    <!-- Sidebar component -->
    <Sidebar :selected="selected" @select="navigate" />

    <!-- Right-side content (Header + Main) -->
    <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
      <!-- Sticky Header -->
      <Header />

      <!-- Main content below header -->
      <main class="flex-1 overflow-y-auto p-6 mt-2">
        <h1 class="text-2xl font-bold mb-4">Welcome, {{ user.name }}</h1>
        <component :is="currentComponent" />
      </main>
    </div>
  </div>
  <div v-else class="flex items-center justify-center min-h-screen">
    <p class="text-gray-600">Loading...</p>
  </div>
</template>

<script>
import api from '../axios';
// Import necessary components
import Sidebar from './Sidebar.vue';
import CreateVenue from './CreateVenue.vue';
import ManageEvents from './ManageEvents.vue';
import CreateEvent from './CreateEvent.vue';
import DashboardHome from './DashboardHome.vue';
import Header from './Header.vue';
import ManageVenues from './ManageVenues.vue';

export default {
  components: {
    Sidebar,
    CreateVenue,
    ManageEvents,
    CreateEvent,
    DashboardHome,
    Header,
    ManageVenues
  },
  data() {
    return {
      selected: 'dashboardHome',
      user: null
    };
  },
  created() {
    // Initialize user from Laravel global variable
    this.user = window.Laravel.user;
    
    // Watch for authentication changes
    window.addEventListener('storage', this.handleStorageChange);
  },
  beforeUnmount() {
    window.removeEventListener('storage', this.handleStorageChange);
  },
  methods: {
    navigate(componentName) {
      this.selected = componentName;
    },
    async logout() {
      try {
        await api.post('/api/logout');
        localStorage.removeItem('user');
        window.location.href = '/login';
      } catch (error) {
        console.error('Logout failed:', error);
      }
    },
    handleStorageChange(event) {
      if (event.key === 'user') {
        this.user = event.newValue ? JSON.parse(event.newValue) : null;
      }
    }
  },
  computed: {
    currentComponent() {
      const components = {
        dashboardHome: 'DashboardHome',
        createVenue: 'CreateVenue',
        manageEvents: 'ManageEvents',
        manageVenues: 'ManageVenues',
        createEvent: 'CreateEvent'
      };
      return components[this.selected] || 'DashboardHome';
    }
  }
};
</script>
