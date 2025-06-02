<template>
  <div class="max-w-md mx-auto p-4 pt-6 md:p-6 lg:p-12 bg-white shadow-md rounded">
    <h1 class="text-2xl font-bold mb-4">Login Form</h1>
    <form @submit.prevent="login" class="flex flex-col">
      <div v-if="errors.length" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <p v-for="(error, index) in errors" :key="index">{{ error }}</p>
      </div>
      <label for="email" class="block mb-2 text-gray-700">Email:</label>
      <input type="email" id="email" v-model="form.email" required class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      <label for="password" class="block mb-2 text-gray-700">Password:</label>
      <input type="password" id="password" v-model="form.password" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      <button type="submit" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded">Login</button>
    </form>
  </div>
</template>

<script>
import api from '../axios';

export default {
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      errors: [],
      // To check authentication status in Vue:
      // 1. Using localStorage (if you store user data there):
      //    - this.$store.state.user - if using Vuex store
      //    - localStorage.getItem('user') - if storing in localStorage
      //    - localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null
      
      // 2. Using VueX store (if implemented):
      //    - this.$store.getters.isAuthenticated
      //    - this.$store.state.user
      
      // 3. Using a computed property:
      //    computed: {
      //      isAuthenticated() {
      //        return !!localStorage.getItem('user');
      //      },
      //      currentUser() {
      //        return localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;
      //      }
      //    }
      
      // 4. Using a method:
      //    methods: {
      //      checkAuth() {
      //        return !!localStorage.getItem('user');
      //      },
      //      getUser() {
      //        return localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;
      //      }
      //    }
    }
  },
  methods: {
    login() {
      // Get CSRF token from meta tag
      const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
      
      api.post('/api/login', this.form, {
        headers: {
          'X-CSRF-TOKEN': csrfToken
        }
      })
      .then(response => {
        // Clear any existing errors
        this.errors = [];
        
        // Update the UI
        this.$emit('authenticated', true);
        
        // The server will handle the redirect to /api/dashboard
        window.location.href = '/api/dashboard';
      })
      .catch(error => {
        // Handle error response
        this.errors = error.response?.data?.message ? [error.response.data.message] : ['Invalid credentials'];
        console.error('Login error:', error);
        
        // Update the UI
        this.$emit('authenticated', false);
      });
    }
  }
}
</script>