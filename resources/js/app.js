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



// createApp(Calendar).mount('#calendar-app');

// app.config.globalProperties.$axios = axios;


//*

// import axios from 'axios';
// import { createApp } from 'vue';
// import RegisterForm from './components/RegistrationForm.vue';
// import Calendar from './components/Calendar.vue';

// // Axios setup to include CSRF token
// axios.defaults.withCredentials = true; 
// axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
// axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

// const axiosPlugin = {
//   install(app) {
//     app.config.globalProperties.$axios = axios;
//   }
// };

// const app = createApp(RegisterForm);
// app.use(axiosPlugin);
// app.mount('#app');

// const calendarApp = createApp(Calendar);
// calendarApp.use(axiosPlugin);
// calendarApp.mount('#calendar-app');

//*************************************_________________________________ */



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


import axios from 'axios';
import { createApp } from 'vue';
import RegisterForm from './components/RegistrationForm.vue';
import Calendar from './components/Calendar.vue';
import ImageUploader from './components/ImageUploader.vue';
import FileUploader from './components/FileUploader.vue';

import AdminRegisterForm from './components/AdminRegisterForm.vue';
import Login from './components/Login.vue';
import Dashboard from './components/Dashboard.vue';
import Homepage from './components/HomePage.vue';

// Get CSRF token
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

// Define the axios plugin
const axiosPlugin = {
    install(app) {
        app.config.globalProperties.$axios = axios;
    }
};

// Register global components for all apps
const registerGlobalComponents = (app) => {
    app.component('ImageUploader', ImageUploader);
    app.component('FileUploader', FileUploader);
};

// Function to safely mount components
const mountComponent = (selector, component) => {
    const element = document.querySelector(selector);
    if (element) {
        const app = createApp(component);
        app.use(axiosPlugin);
        registerGlobalComponents(app);
        app.mount(selector);
        return app;
    }
    return null;
};

// Initialize apps after CSRF cookie is set (or skip if not using Sanctum SPA)
const initializeApps = () => {
    // Mount RegisterForm
    mountComponent('#app', RegisterForm);
    
    // Mount AdminRegisterForm
    mountComponent('#app_admin_register', AdminRegisterForm);
    
    // Mount Calendar
    mountComponent('#calendar-app', Calendar);
    
    // Mount Login
    mountComponent('#loginapp', Login);
    mountComponent('#HomePage', Homepage);
    
    // Mount Dashboard
    mountComponent('#dashboard', Dashboard);
};

// If you're using Sanctum SPA authentication, get CSRF cookie first
// Otherwise, just initialize the apps directly
if (document.querySelector('meta[name="sanctum-spa"]')) {
    axios.get('/sanctum/csrf-cookie').then(() => {
        initializeApps();
    }).catch(error => {
        console.error('Failed to initialize CSRF protection:', error);
        // Initialize apps anyway if CSRF fails
        initializeApps();
    });
} else {
    // For regular Laravel apps, initialize directly
    initializeApps();
}
