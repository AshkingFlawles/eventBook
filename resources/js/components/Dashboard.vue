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
    <div class="text-center">
      <h2 class="text-2xl font-bold mb-4">Please Login</h2>
      <p class="text-gray-600 mb-4">You need to be logged in to access the dashboard</p>
      <router-link to="/login" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
        Go to Login
      </router-link>
    </div>
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
  methods: {
    async checkAuth() {
      try {
        const response = await axios.get('/api/user');
        if (response.data) {
          this.user = response.data;
        } else {
          this.handleUnauthenticated();
        }
      } catch (error) {
        this.handleUnauthenticated();
      }
    },
    handleUnauthenticated() {
      // Clear any stored user data
      this.user = null;
      localStorage.removeItem('user');
      
      // Redirect to login
      window.location.href = '/';
    },
    async logout() {
      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        await axios.post('/api/logout', {}, {
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        
        // Clear local storage
        localStorage.removeItem('user');
        
        // Redirect to login page
        window.location.href = '/';
      } catch (error) {
        console.error('Logout error:', error);
        this.handleUnauthenticated();
      }
    }
  },
  data() {
    return {
      selected: 'dashboardHome',
      user: null
    };
  },
  created() {
    this.checkAuth();
    
    // Watch for authentication changes
    window.addEventListener('storage', this.handleStorageChange);

    // Log user auth details for debugging
    console.log('Authenticated user:', this.user);

    // Log token for debugging
    const token = localStorage.getItem('token') || null;
    console.log('Auth token:', token);

    // Also log token from axios default headers if set
    if (this.$axios && this.$axios.defaults.headers.common['Authorization']) {
      console.log('Axios Authorization header:', this.$axios.defaults.headers.common['Authorization']);
    }
  },
  created() {
    // Initialize user from Laravel global variable
    this.user = window.Laravel.user;
    
    // Watch for authentication changes
    window.addEventListener('storage', this.handleStorageChange);

    // Log user auth details for debugging
    console.log('Authenticated user:', this.user);

    // Log token for debugging
    const token = localStorage.getItem('token') || null;
    console.log('Auth token:', token);

    // Also log token from axios default headers if set
    if (this.$axios && this.$axios.defaults.headers.common['Authorization']) {
      console.log('Axios Authorization header:', this.$axios.defaults.headers.common['Authorization']);
    }
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
