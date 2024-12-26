<template>
  <!-- Main container for the registration form -->
  <div class="max-w-md mx-auto p-4 pt-6 md:p-6 lg:p-12 bg-white shadow-md rounded">
    <h1 class="text-2xl font-bold mb-4">Register Form</h1>
    <form @submit.prevent="register" class="flex flex-col">
      <div v-if="errors.length" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <p v-for="(error, index) in errors" :key="index">{{ error }}</p>
      </div>
      
      <label for="name" class="block mb-2 text-gray-700">Name:</label>
      <input type="text" id="name" v-model="form.name" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      
      <label for="email" class="block mb-2 text-gray-700">Email:</label>
      <input type="email" id="email" v-model="form.email" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      
      <label for="password" class="block mb-2 text-gray-700">Password:</label>
      <input type="password" id="password" v-model="form.password" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      
      <label for="password_confirmation" class="block mb-2 text-gray-700">Confirm Password:</label>
      <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      
      <button type="submit" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded">Register</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '', // User's name
        email: '', // User's email
        password: '', // User's password
        password_confirmation: '', // Confirmation for the password
      },
      errors: [] // Array to hold validation error messages
    };
  },

  methods: {
    async register() {
      try {
        // Send registration data to the server
        const response = await this.$axios.post('/api/testreg', this.form);
        console.log('Registration successful:', response.data);
        this.errors = []; // Clear errors on successful registration
      } catch (error) {
        // Handle registration errors
        console.error('Registration error:', error.response.data);
        this.errors = error.response?.data?.errors || ['An error occurred during registration'];
      }
    }
  }
};
</script>
