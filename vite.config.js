// import { defineConfig } from 'vite';
// import vue from '@vitejs/plugin-vue';
// import laravel from 'laravel-vite-plugin';

// export default defineConfig({
//   root: './resources', // Set the root directory to resources
//   plugins: [
//     vue(),
//     laravel({
//       input: [
//         'js/app.js',
//         'sass/app.scss',
//       ],
//       refresh: true,
//     }),
//   ],
// });











import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  root: './resources', // Set the root directory to resources
  plugins: [
    vue(),
    laravel({
      input: [
        'js/app.js',
        'sass/app.scss',
      ],
      refresh: true,
    }),
  ],
  server: {
    proxy: {
      '/api': 'http://127.0.0.1:8000', // proxy requests to Laravel API
    },
  },
});