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
    |api/*
    */

    'paths'                    => ['api/*','*','/login','/logout','/reset/password','/update/password','/sanctum/csrf-cookie'],
    'allowed_methods'          => ['*'],
    'allowed_origins'          => [
                                    'http://localhost:3000',
                                    'http://localhost:3001',
                                    'http://localhost:3002',
                                    'http://localhost:3003',     
                                    'http://localhost:3004', 
                                    'http://localhost:3005', 
                                    'http://localhost:3006', 
                                    'https://api.fqesas.com', 
                                    'https://facturas-dian.fqesas.com',  
                                    'https://fqesas.com',
                                    'https://pagos.fqesas.com', 
                                    'https://admin.productos.fqesas.com', 
                                    ],
    'allowed_origins_patterns' => [],
    'allowed_headers'          => ['*'],
    'exposed_headers'          => false,
    'max_age'                  => false,
    'supports_credentials'     => true,

];
