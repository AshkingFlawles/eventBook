<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Define the paths that should be CORS-enabled
    'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, etc.)
    'allowed_origins' => ['http://localhost:5173'], // Allow requests from this specific origin
    'allowed_origins_patterns' => [], // Patterns for allowed origins (not used here)
    'allowed_headers' => ['*'], // Allow all headers in requests
    'exposed_headers' => [], // Headers that can be exposed to the browser
    'max_age' => 0, // Maximum age for preflight requests
    'supports_credentials' => true, // Indicates whether the browser should include credentials (cookies, authorization headers, etc.)

];
