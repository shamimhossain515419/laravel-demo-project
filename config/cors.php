<?php
return [
    // Specifies the paths where CORS will be applied
    'paths' => ['api/*'],

    // Allows all HTTP methods
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH', 'HEAD'],

    // Allows requests from all origins
    'allowed_origins' => ['*'],

    // You can specify patterns for allowed origins if needed
    'allowed_origins_patterns' => [],

    // Allows all headers
    'allowed_headers' => ['*'],

    // Exposed headers that can be exposed to the browser
    'exposed_headers' => [],

    // Maximum age of the preflight request (in seconds)
    'max_age' => 86400, // Example: 1 day

    // Allows credentials to be included in requests
    'supports_credentials' => true, // Set to true if you want to allow cookies and HTTP authentication
];
