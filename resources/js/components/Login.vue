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
      errors: []
    }
  },
  methods: {
    login() {
      api.post('/api/login', this.form)
        .then(response => {
          // Clear any existing errors
          this.errors = [];
          
          // Store user data in localStorage for Vue
          localStorage.setItem('user', JSON.stringify(response.data.user));
          
          // Redirect to dashboard
          window.location.href = '/api/dashboard';
        })
        .catch(error => {
          // Handle error response
          this.errors = error.response?.data?.message ? [error.response.data.message] : ['Invalid credentials'];
          console.error('Login error:', error);
        });
    }
  }
}
</script>