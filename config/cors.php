<?php

return [
    // Only enable for API routes
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Allow requests from your own domain (Blade)
    'allowed_origins' => [env('APP_URL', 'http://localhost:8000')],

    // Keep other defaults minimal
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'allowed_origins_patterns' => [],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // No need for cookies in same-domain requests
];
