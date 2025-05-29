<template>
  <!-- Main dashboard layout with sidebar and content area -->
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar component with selected menu item and event handler -->
    <Sidebar :selected="selected" @select="selected = $event" />
    <!-- Main content area displaying the selected component -->
    <main class="flex-1 p-6">
      <component :is="currentComponent" />
    </main>
  </div>
</template>

<script>
// Import child components for the dashboard
import Sidebar from './Sidebar.vue';
import CreateVenue from './CreateVenue.vue';
import ManageEvents from './ManageEvents.vue';
import CreateEvent from './CreateEvent.vue';
import DashboardHome from './DashboardHome.vue';

export default {
  components: {
    Sidebar,
    CreateVenue,
    ManageEvents,
    CreateEvent,
    DashboardHome
  },
  data() {
    return {
      // Currently selected menu item, default to dashboard home
      selected: 'dashboardHome'
    };
  },
  computed: {
    // Compute the component to display based on selected menu item
    currentComponent() {
      switch (this.selected) {
        case 'createVenue':
          return 'CreateVenue';
        case 'manageEvents':
          return 'ManageEvents';
        case 'createEvent':
          return 'CreateEvent';
          // Default to dashboard home
          case 'dashboardHome':
          return 'DashboardHome';
        default:
          // Default dashboard home content
          return {
            template: '<div class="p-6 bg-white rounded shadow-md max-w-3xl mx-auto"><h1 class="text-2xl font-bold">Welcome to the Dashboard</h1><p>Select an option from the left menu.</p></div>'
          };
      }
    }
  }
};
</script>
