// import { createApp } from 'vue';
// import RegisterForm from './components/RegistrationForm.vue'; // Ensure the path is correct

// const app = createApp({});
// app.component('register-form', RegisterForm);
// app.mount('#app');

// console.log('Vue app mounted', app.mount('#app'));
// import { createApp } from 'vue';
// import RegisterForm from './components/RegistrationForm.vue';

// const App = {
//   components: { RegisterForm },
//   template: '<register-form />',
// };

// const app = createApp(App);


//perfect code latest 
//100%
// import axios from 'axios';
// import { createApp } from 'vue';
// import RegisterForm from './components/RegistrationForm.vue'; // Ensure the path is correct
// import Calendar from './components/Calendar.vue';


// createApp(RegisterForm).mount('#app');
// createApp(Calendar).mount('#calendar-app');

// app.config.globalProperties.$axios = axios;




import axios from 'axios';
import { createApp } from 'vue';
import RegisterForm from './components/RegistrationForm.vue';
import Calendar from './components/Calendar.vue';

// Axios setup to include CSRF token
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

const axiosPlugin = {
  install(app) {
    app.config.globalProperties.$axios = axios;
  }
};

const app = createApp(RegisterForm);
app.use(axiosPlugin);
app.mount('#app');

const calendarApp = createApp(Calendar);
calendarApp.use(axiosPlugin);
calendarApp.mount('#calendar-app');





// //test
// import { createApp } from 'vue';
// import RegisterForm from './components/RegistrationForm.vue';
// import Calendar from './components/Calendar.vue';

// // Function to create and mount a Vue app for a specific component
// function mountComponent(selector, component) {
//   const el = document.querySelector(selector);
//   if (el) {
//     createApp(component).mount(el);
//   }
// }

// // Mount the RegisterForm component if the element is present
// mountComponent('#register-app', RegisterForm);

// // Mount the Calendar component if the element is present
// mountComponent('#calendar-app', Calendar);
