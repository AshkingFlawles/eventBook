<template>
  <div class="max-w-md mx-auto p-4 pt-6 md:p-6 lg:p-12 bg-white shadow-md rounded">
    <h1 class="text-2xl font-bold mb-4">Register Form</h1>
    <form @submit.prevent="register" class="flex flex-col">
      <label for="name" class="block mb-2 text-gray-700">Name:</label>
      <input type="text" id="name" v-model="form.name" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      <br />
      <label for="email" class="block mb-2 text-gray-700">Email:</label>
      <input type="email" id="email" v-model="form.email" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      <br />
      <label for="password" class="block mb-2 text-gray-700">Password:</label>
      <input type="password" id="password" v-model="form.password" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      <br />
      <label for="password_confirmation" class="block mb-2 text-gray-700">Confirm Password:</label>
      <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 rounded" />
      <br />
      <button type="submit" style="background-color: #776e8c; color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 0.25rem;">Register</button> 
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
    };
  },
  
  methods: {
    register() {
      console.log(this.form);
      this.$axios.post('http://127.0.0.1:8000/testreg', this.form)
      .then(response => {
          console.log('Registration successful:', response.data);
          // Handle successful registration
        })
        .catch(error => {
          console.error('Registration error:', error.response.data);
          // Handle registration errors
        });
    }
  },
  mounted() {
    console.log('RegistrationForm component mounted');
  }
};
</script>

<style scoped>
.max-w-md {
  max-width: 400px;
  margin: 40px auto;
}
</style>
