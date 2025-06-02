<template>
  <!-- Full-width sticky header with padding, shadow, and flex layout -->
  <header class="w-full sticky top-0 z-50 bg-white shadow-md px-6 py-4 flex justify-between items-center" style="width: 100%;">
    <h1 class="text-2xl font-bold">Dashboard Header</h1>

    <button
      @click="logout"
      class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition"
      style="background-color: black;"
    >
      Logout
    </button>
  </header>
</template>

<script>
import axios from 'axios';

export default {
  methods: {
    logout() {
      axios.post('/logout', {}, { withCredentials: true })
        .then(() => {
          window.location.href = '/api/login';
        })
        .catch(() => {
          alert('Logout failed. Please try again.');
        });
    }
  }
};
</script>

<style scoped>
/* No changes needed */
</style>
