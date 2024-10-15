<template>
  <div>
      <h1>Register Form</h1>
      <form @submit.prevent="register">
          <label for="name">Name:</label>
          <input type="text" id="name" v-model="form.name" />
          <br />
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="form.email" />
          <br />
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="form.password" />
          <br />
          <label for="password_confirmation">Confirm Password:</label>
          <input type="password" id="password_confirmation" v-model="form.password_confirmation" />
          <br />
          <button type="submit">Register</button>
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
          fetch('/register', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
              },
              body: JSON.stringify(this.form),
          })
          .then(response => response.json())
          .then(data => {
              console.log(data);
              // Handle successful registration
          })
          .catch(error => {
              console.error(error);
              // Handle registration errors
          });
      },
  },
  mounted() {
      console.log('RegistrationForm component mounted');
  },
};
</script>
