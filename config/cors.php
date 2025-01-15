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

    'paths' => ['api/*'], // Apply CORS to API routes
    'allowed_methods' => ['get','post','delete'], // Allow all HTTP methods
    'allowed_origins' => ['http://localhost:8000'], // Replace with your Flutter app's port
    'allowed_origins_patterns' => ['/^http:\/\/localhost:\d+$/'], // Allow any localhost port
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,

];
