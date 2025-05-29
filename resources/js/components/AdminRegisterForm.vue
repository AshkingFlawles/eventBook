<template>
  <div class="max-w-md mx-auto p-4 pt-6 md:p-6 lg:p-12 bg-white shadow-md rounded">
    <h1 class="text-2xl font-bold mb-4">Event Manager Registration</h1>
    
    <form @submit.prevent="register" class="flex flex-col">
      <div v-if="currentStep === 1">
        <!-- Stage 1 Fields -->
        <label for="name" class="block mb-2 text-gray-700">Name:</label>
        <input type="text" id="name" v-model="form.name" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />

        <label for="email" class="block mb-2 text-gray-700">Business Email:</label>
        <input type="email" id="email" v-model="form.business_email" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />

        <label for="company" class="block mb-2 text-gray-700">Company/Organization Name:</label>
        <input type="text" id="company" v-model="form.company" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />

        <label for="phone" class="block mb-2 text-gray-700">Phone Number:</label>
        <input type="text" id="phone" v-model="form.phone" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />

        <label for="password" class="block mb-2 text-gray-700">Password:</label>
        <input type="password" id="password" v-model="form.password" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />

        <label for="password_confirmation" class="block mb-2 text-gray-700">Confirm Password:</label>
        <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />

        <button type="button" @click="nextStep" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded admin-reg-stage_1">Next</button>
      </div>

      <div v-else-if="currentStep === 2">
        <!-- Stage 2 Fields -->
        <label for="address" class="block mb-2 text-gray-700">Business Address:</label>
        <input type="text" id="address" v-model="form.address" class="w-full p-2 text-sm text-gray-700 bg-gray-100 rounded" />

        <label for="business_type" class="block mb-2 text-gray-700">Business Type:</label>
        <input type="text" id="business_type" v-model="form.business_type" class="w-full p-2 text-sm text-gray-700 bg-gray-100 rounded" />

        <label for="employees" class="block mb-2 text-gray-700">Number of Employees:</label>
        <input type="number" id="employees" v-model="form.employees" class="w-full p-2 text-sm text-gray-700 bg-gray-100 rounded" />

        <label for="website" class="block mb-2 text-gray-700">Website:</label>
        <input type="url" id="website" v-model="form.website" class="w-full p-2 text-sm text-gray-700 bg-gray-100 rounded" />

        <label for="description" class="block mb-2 text-gray-700">Business Description:</label>
        <textarea id="description" v-model="form.description" class="w-full p-2 text-sm text-gray-700 bg-gray-100 rounded"></textarea>

        <label for="terms" class="flex items-center">
          <input type="checkbox" id="terms" v-model="form.terms" class="mr-2" />
          I accept the terms and conditions
        </label>

        <button type="button" @click="prevStep" class="mt-4 bg-gray-500 text-white font-bold py-2 px-4 rounded admin-reg-stage_1">Previous</button>
        <button type="submit" class="mt-4 bg-blue-500 text-white font-bold py-2 px-4 rounded admin-reg-stage_1">Register</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentStep: 1, // Track the current step of the form
      form: {
        name: '',
        business_email: '',
        company: '',
        phone: '',
        password: '',
        password_confirmation: '',
        address: '',
        business_type: '',
        employees: '',
        website: '',
        description: '',
        terms: false, // For terms and conditions acceptance
      },
      errors: []
    };
  },
  methods: {
    nextStep() {
      this.currentStep++;
    },
    prevStep() {
      this.currentStep--;
    },
    async register() {
      try {
        const response = await this.$axios.post('/api/adminRegister', this.form);
        console.log('Registration successful:', response.data);
        this.errors = [];
      } catch (error) {
        console.error('Registration error:', error.response.data);
        this.errors = error.response?.data?.errors || ['An error occurred during registration'];
      }
    }
  }
};
</script>