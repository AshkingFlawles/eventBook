import axios from 'axios';

// Configure axios to use Laravel backend
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = true;

// Add CSRF token to all requests
axios.interceptors.request.use(config => {
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        config.headers['X-CSRF-TOKEN'] = token.content;
    }
    return config;
});

// Add response interceptor for handling errors
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

export default axios;
